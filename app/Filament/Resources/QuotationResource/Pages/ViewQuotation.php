<?php

namespace App\Filament\Resources\QuotationResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Filament\Resources\QuotationResource;
use App\Services\QuotationService;
use Filament\Actions\Action;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Section as InfoSection;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;

class ViewQuotation extends ViewRecord
{
    protected static string $resource = QuotationResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            InfoSection::make('Quotation '.$this->getRecord()->code)->schema([
                TextEntry::make('customer.name')->default('—')->label('Customer'),
                TextEntry::make('status')->badge(),
                TextEntry::make('quotation_date')->date('d M Y'),
                TextEntry::make('expired_date')->date('d M Y')->placeholder('—'),
                TextEntry::make('subtotal')->money('IDR'),
                TextEntry::make('discount')->money('IDR'),
                TextEntry::make('shipping')->money('IDR'),
                TextEntry::make('total')->money('IDR')->weight('bold'),
                TextEntry::make('notes')->columnSpanFull()->placeholder('—'),
                TextEntry::make('terms')->columnSpanFull()->placeholder('—'),
            ])->columns(4),

            InfoSection::make('Items')->schema([
                RepeatableEntry::make('items')->schema([
                    TextEntry::make('name'),
                    TextEntry::make('item_type')->badge(),
                    TextEntry::make('quantity'),
                    TextEntry::make('price')->money('IDR'),
                    TextEntry::make('total')->money('IDR'),
                ])->columns(5)->contained(false),
            ]),
        ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('mark_sent')
                ->label('Kirim (Sent)')
                ->icon('heroicon-m-paper-airplane')
                ->visible(fn () => $this->getRecord()->status === 'draft')
                ->action(function () {
                    try {
                        QuotationService::markSent($this->getRecord());
                        Notification::make()->title('Quotation dikirim')->success()->send();
                    } catch (\DomainException $e) {
                        Notification::make()->title('Gagal')->body($e->getMessage())->danger()->send();
                    }
                }),

            Action::make('mark_accepted')
                ->label('Accepted')
                ->icon('heroicon-m-check')
                ->color('success')
                ->visible(fn () => $this->getRecord()->status === 'sent')
                ->requiresConfirmation()
                ->action(fn () => $this->getRecord()->update(['status' => 'accepted'])),

            Action::make('convert')
                ->label('Convert → Order')
                ->icon('heroicon-m-arrow-right-circle')
                ->color('primary')
                ->visible(fn () => $this->getRecord()->status === 'accepted' && ! $this->getRecord()->order_id)
                ->requiresConfirmation()
                ->action(function () {
                    try {
                        $order = QuotationService::convertToOrder($this->getRecord());
                        Notification::make()->title("Order {$order->code} dibuat dari quotation")->success()->send();
                        $this->redirect(OrderResource::getUrl('view', ['record' => $order]));
                    } catch (\DomainException $e) {
                        Notification::make()->title('Gagal konversi')->body($e->getMessage())->danger()->send();
                    }
                }),
        ];
    }
}
