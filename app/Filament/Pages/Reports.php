<?php

namespace App\Filament\Pages;

use App\Exports\ReportExport;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Service;
use App\Services\InventoryService;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Facades\Excel;

class Reports extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    protected static ?string $navigationGroup = 'Reports';

    protected static ?string $navigationLabel = 'Laporan';

    protected static ?int $navigationSort = 1;

    protected static string $view = 'filament.pages.reports';

    public ?string $date_from = null;

    public ?string $date_to = null;

    public string $activePreset = 'month';

    /** @var array<string, mixed>|null */
    protected ?array $cachedSummary = null;

    public function getTitle(): string
    {
        return 'Laporan Penjualan & Servis';
    }

    public function getSubheading(): ?string
    {
        $from = Carbon::parse($this->date_from ?: now()->startOfMonth()->toDateString())->format('d M Y');
        $to = Carbon::parse($this->date_to ?: now()->toDateString())->format('d M Y');

        return "Periode aktif: {$from} — {$to}";
    }

    public function mount(): void
    {
        $this->applyPreset('month');
    }

    public function applyPreset(string $preset): void
    {
        $this->activePreset = $preset;
        $today = now();

        [$from, $to] = match ($preset) {
            'today' => [$today->toDateString(), $today->toDateString()],
            'week' => [$today->copy()->subDays(6)->toDateString(), $today->toDateString()],
            'last30' => [$today->copy()->subDays(29)->toDateString(), $today->toDateString()],
            'year' => [$today->copy()->startOfYear()->toDateString(), $today->toDateString()],
            default => [$today->copy()->startOfMonth()->toDateString(), $today->toDateString()],
        };

        $this->date_from = $from;
        $this->date_to = $to;
        $this->cachedSummary = null;

        $this->form->fill([
            'date_from' => $this->date_from,
            'date_to' => $this->date_to,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('date_from')
                    ->label('Dari Tanggal')
                    ->native(false)
                    ->displayFormat('d M Y')
                    ->closeOnDateSelection(),
                DatePicker::make('date_to')
                    ->label('Sampai Tanggal')
                    ->native(false)
                    ->displayFormat('d M Y')
                    ->closeOnDateSelection(),
            ])
            ->columns(['default' => 1, 'sm' => 2]);
    }

    public function updated($property): void
    {
        $this->cachedSummary = null;

        if (in_array($property, ['date_from', 'date_to'], true)) {
            $this->activePreset = 'custom';
        }

        $this->validateOnly($property, [
            'date_from' => ['nullable', 'date'],
            'date_to' => ['nullable', 'date', 'after_or_equal:date_from'],
        ]);
    }

    public function applyFilter(): void
    {
        $this->validate([
            'date_from' => ['nullable', 'date'],
            'date_to' => ['nullable', 'date', 'after_or_equal:date_from'],
        ]);

        $this->activePreset = 'custom';
        $this->cachedSummary = null;
    }

    /**
     * @return array<string, mixed>
     */
    public function getSummary(): array
    {
        if ($this->cachedSummary !== null) {
            return $this->cachedSummary;
        }

        $fromDate = $this->date_from ?: now()->startOfMonth()->toDateString();
        $toDate = $this->date_to ?: now()->toDateString();
        $fromTs = $fromDate.' 00:00:00';
        $toTs = $toDate.' 23:59:59';

        $paymentsInPeriod = Payment::query()
            ->whereDate('paid_at', '>=', $fromDate)
            ->whereDate('paid_at', '<=', $toDate);

        $ordersInPeriod = Order::query()
            ->whereBetween('created_at', [$fromTs, $toTs])
            ->where('status', '!=', 'cancelled');

        $servicesInPeriod = Service::query()
            ->whereBetween('created_at', [$fromTs, $toTs]);

        $paymentsByMethod = (clone $paymentsInPeriod)
            ->selectRaw('method, COUNT(*) as count, SUM(amount) as total')
            ->groupBy('method')
            ->orderByDesc('total')
            ->get()
            ->map(fn ($row): array => [
                'method' => (string) $row->method,
                'count' => (int) $row->count,
                'total' => (int) $row->total,
            ])
            ->all();

        $servicesByStatus = (clone $servicesInPeriod)
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->orderByDesc('count')
            ->get()
            ->map(fn ($row): array => [
                'status' => (string) $row->status,
                'count' => (int) $row->count,
            ])
            ->all();

        $this->cachedSummary = [
            'revenue' => (int) (clone $paymentsInPeriod)->sum('amount'),
            'orders' => (int) (clone $ordersInPeriod)->count(),
            'order_value' => (int) (clone $ordersInPeriod)->sum('total'),
            'services' => (int) (clone $servicesInPeriod)->count(),
            'service_value' => (int) (clone $servicesInPeriod)->where('status', '!=', 'cancelled')->sum('total_cost'),
            'unpaid' => (int) Invoice::query()
                ->whereIn('status', ['unpaid', 'partial'])
                ->whereBetween('created_at', [$fromTs, $toTs])
                ->get()
                ->sum(fn (Invoice $invoice): int => $invoice->remainingAmount()),
            'payments_by_method' => $paymentsByMethod,
            'services_by_status' => $servicesByStatus,
        ];

        return $this->cachedSummary;
    }

    public function getBestSellers(int $limit = 10): Collection
    {
        return Product::query()->with('inventory')->orderByDesc('sold_count')->limit($limit)->get();
    }

    public function getLowStock(): Collection
    {
        return InventoryService::lowStockProducts();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('export_excel')
                ->label('Export Excel')
                ->icon('heroicon-m-arrow-down-tray')
                ->color('primary')
                ->action(function () {
                    $summary = $this->getSummary();
                    $bestSellers = $this->getBestSellers();
                    $filename = 'keehub-report-'.now()->format('YmdHis').'.xlsx';

                    return Excel::download(new ReportExport($summary, $bestSellers), $filename);
                }),
        ];
    }
}
