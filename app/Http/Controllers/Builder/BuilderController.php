<?php

namespace App\Http\Controllers\Builder;

use App\Http\Controllers\Controller;
use App\Models\PcBuild;
use App\Models\Product;
use App\Services\CartService;
use App\Services\CompatibilityService;
use App\Services\PowerCalculatorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BuilderController extends Controller
{
    public function index(?string $token = null): View
    {
        $build = null;

        if ($token) {
            $build = PcBuild::query()->where('share_token', $token)->orWhereKey($token)->with('items.product')->first();
        }

        $selected = [];

        if ($build) {
            foreach ($build->items as $item) {
                if ($item->product) {
                    $selected[$item->slot] = $item->product->id;
                }
            }
        }

        return view('builder.index', [
            'build' => $build,
            'selected' => $selected,
            'purposes' => PcBuild::PURPOSES,
            'slots' => PcBuild::SLOTS,
        ]);
    }

    public function components(Request $request, string $slot): JsonResponse
    {
        if (! in_array($slot, PcBuild::SLOTS, true)) {
            return response()->json(['error' => 'Invalid slot'], 404);
        }

        $query = Product::query()
            ->active()
            ->with(['brand', 'images', 'inventory', 'specs'])
            ->whereHas('category', fn ($q) => $q->where('slug', $this->categorySlug($slot)))
            ->when($request->filled('q'), fn ($q) => $q->where('name', 'like', '%'.$request->q.'%'));

        $this->applyCompatibilityFilters($query, $slot, $request);

        $products = $query->orderByDesc('sold_count')->limit(30)->get()->map(fn (Product $p) => [
            'id' => $p->id,
            'name' => $p->name,
            'brand' => $p->brand?->name,
            'price' => $p->price,
            'in_stock' => ($p->inventory?->current_stock ?? 0) > 0,
            'specs' => $p->specs->map(fn ($s) => ['key' => $s->key, 'value' => $s->value])->values()->all(),
        ]);

        return response()->json(['slot' => $slot, 'products' => $products]);
    }

    public function check(Request $request): JsonResponse
    {
        $selected = $this->resolveSelectedProducts($request);

        $compatibility = CompatibilityService::check($selected);
        $power = PowerCalculatorService::estimate($selected);

        $total = collect($selected)->sum(fn ($p) => $p instanceof Product ? $p->price : 0);

        return response()->json([
            'compatibility' => $compatibility,
            'power' => $power,
            'recommended_psu' => PowerCalculatorService::recommendedPsu($selected),
            'total' => (int) $total,
        ]);
    }

    public function save(Request $request): JsonResponse
    {
        $data = $request->validate([
            'build_id' => ['nullable', 'integer'],
            'name' => ['nullable', 'string', 'max:255'],
            'purpose' => ['nullable', 'string', 'in:'.implode(',', PcBuild::PURPOSES)],
            'budget' => ['nullable', 'integer', 'min:0'],
            'items' => ['required', 'array'],
            'items.*.slot' => ['required', 'in:'.implode(',', PcBuild::SLOTS)],
            'items.*.product_id' => ['nullable', 'integer', 'exists:products,id'],
        ]);

        $build = isset($data['build_id'])
            ? PcBuild::query()->where('user_id', Auth::id())->findOrFail($data['build_id'])
            : PcBuild::query()->create([
                'code' => PcBuild::generateCode(),
                'user_id' => Auth::id(),
                'name' => $data['name'] ?? null,
                'purpose' => $data['purpose'] ?? null,
                'budget' => $data['budget'] ?? null,
                'status' => 'draft',
                'share_token' => bin2hex(random_bytes(12)),
            ]);

        $build->fill([
            'name' => $data['name'] ?? $build->name,
            'purpose' => $data['purpose'] ?? $build->purpose,
            'budget' => $data['budget'] ?? $build->budget,
        ])->save();

        $build->items()->delete();

        $total = 0;

        foreach ($data['items'] as $item) {
            if (empty($item['product_id'])) {
                continue;
            }

            $product = Product::query()->find($item['product_id']);
            $price = $product?->price ?? 0;
            $total += $price;

            $build->items()->create([
                'slot' => $item['slot'],
                'product_id' => $product?->id,
                'price' => $price,
            ]);
        }

        $build->update(['total_price' => $total]);

        return response()->json([
            'code' => $build->code,
            'share_token' => $build->share_token,
            'total_price' => $build->total_price,
        ]);
    }

    public function addToCart(Request $request): JsonResponse
    {
        $validated = $request->validate(['build_id' => ['required', 'integer']]);

        $build = PcBuild::query()->where('user_id', Auth::id())->findOrFail($validated['build_id']);

        CartService::addBuild($build->id);

        return response()->json(['ok' => true]);
    }

    public function show(string $token): View
    {
        $build = PcBuild::query()->where('share_token', $token)->with(['items.product.brand', 'items.product.images'])->firstOrFail();

        $selected = [];

        foreach ($build->items as $item) {
            if ($item->product) {
                $selected[$item->slot] = $item->product;
            }
        }

        return view('builder.share', [
            'build' => $build,
            'selected' => $selected,
            'compatibility' => CompatibilityService::check($selected),
            'power' => PowerCalculatorService::estimate($selected),
        ]);
    }

    private function categorySlug(string $slot): string
    {
        return match ($slot) {
            'cpu' => 'cpu',
            'motherboard' => 'motherboard',
            'ram' => 'ram',
            'gpu' => 'gpu',
            'storage' => 'ssd',
            'psu' => 'psu',
            'case' => 'casing',
            'cooler' => 'cpu-cooler',
        };
    }

    private function applyCompatibilityFilters($query, string $slot, Request $request): void
    {
        $selected = $this->resolveSelectedProducts($request);
        $categoryCache = $this->categorySlug($slot);

        if ($slot === 'motherboard' && isset($selected['cpu'])) {
            $socket = $selected['cpu']->specValue('socket');
            if ($socket) {
                $query->whereHas('specs', fn ($q) => $q->where('key', 'socket')->where('value', $socket));
            }
        }

        if (in_array($slot, ['cpu', 'motherboard'], true) && isset($selected['ram']) && $slot === 'motherboard') {
            $gen = $selected['ram']->specValue('generation');
            if ($gen) {
                $query->whereHas('specs', fn ($q) => $q->where('key', 'ram_type')->where('value', $gen));
            }
        }

        if ($slot === 'ram' && isset($selected['motherboard'])) {
            $gen = $selected['motherboard']->specValue('ram_type');
            if ($gen) {
                $query->whereHas('specs', fn ($q) => $q->where('key', 'generation')->where('value', $gen));
            }
        }

        if ($slot === 'case' && isset($selected['motherboard'])) {
            $form = $selected['motherboard']->specValue('form_factor');
            if ($form) {
                $query->whereHas('specs', fn ($q) => $q->where('key', 'supported_form_factors')->where('value', 'like', '%'.$form.'%'));
            }
        }
    }

    private function resolveSelectedProducts(Request $request): array
    {
        $selected = [];

        foreach (PcBuild::SLOTS as $slot) {
            $id = $request->input("items.{$slot}") ?? $request->input($slot);

            if (is_array($id)) {
                $id = $id['product_id'] ?? null;
            }

            if ($id) {
                $product = Product::query()->with('specs')->find((int) $id);
                if ($product) {
                    $selected[$slot] = $product;
                }
            }
        }

        return $selected;
    }
}
