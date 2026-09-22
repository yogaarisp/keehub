<?php

namespace App\Filament\Pages;

use App\Exports\ReportExport;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Service;
use App\Services\InventoryService;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Maatwebsite\Excel\Facades\Excel;

class Reports extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    protected static ?string $navigationGroup = 'Reports';

    protected static ?string $navigationLabel = 'Reports';

    protected static ?int $navigationSort = 1;

    protected static string $view = 'filament.pages.reports';

    public ?string $date_from;

    public ?string $date_to;

    public function mount(): void
    {
        $this->date_from = now()->startOfMonth()->toDateString();
        $this->date_to = now()->toDateString();
    }

    protected function getFormSchema(): array
    {
        return [
            DatePicker::make('date_from')->label('Dari')->native(false),
            DatePicker::make('date_to')->label('Sampai')->native(false),
        ];
    }

    public function updated($property): void
    {
        $this->validateOnly($property, [
            'date_from' => ['nullable', 'date'],
            'date_to' => ['nullable', 'date', 'after_or_equal:date_from'],
        ]);
    }

    public function getSummary(): array
    {
        $from = $this->date_from ?? now()->startOfMonth()->toDateString();
        $to = ($this->date_to ?? now()->toDateString()).' 23:59:59';

        $paidInPeriod = Payment::query()->whereBetween('paid_at', [$from, $to]);

        $ordersInPeriod = Order::query()->whereBetween('created_at', [$from, $to])->where('status', '!=', 'cancelled');

        return [
            'revenue' => (int) $paidInPeriod->sum('amount'),
            'orders' => (clone $ordersInPeriod)->count(),
            'order_value' => (clone $ordersInPeriod)->sum('total'),
            'services' => Service::query()->whereBetween('created_at', [$from, $to])->count(),
            'unpaid' => (int) Invoice::query()->whereIn('status', ['unpaid', 'partial'])->whereBetween('created_at', [$from, $to])->get()->sum(fn ($i) => $i->remainingAmount()),
        ];
    }

    public function getBestSellers(int $limit = 10)
    {
        return Product::query()->with('inventory')->orderByDesc('sold_count')->limit($limit)->get();
    }

    public function getLowStock()
    {
        return InventoryService::lowStockProducts();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('export_excel')->label('Export Excel')->icon('heroicon-m-arrow-down-tray')
                ->action(function () {
                    $summary = $this->getSummary();
                    $bestSellers = $this->getBestSellers();
                    $filename = 'keehub-report-'.now()->format('YmdHis').'.xlsx';

                    Excel::store(new ReportExport($summary, $bestSellers), $filename, 'local');

                    return response()->download(storage_path('app/'.$filename))->deleteFileAfterSend();
                }),
        ];
    }
}
