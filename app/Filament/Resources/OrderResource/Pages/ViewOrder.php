<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Services\OrderService;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Section as InfoSection;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            InfoSection::make('Order '.$this->getRecord()->code)->schema([
                TextEntry::make('customer.name')->default('—')->label('Customer'),
                TextEntry::make('type')->badge(),
                TextEntry::make('status')->badge(),
                TextEntry::make('channel'),
                TextEntry::make('subtotal')->money('IDR'),
                TextEntry::make('discount')->money('IDR'),
                TextEntry::make('shipping_cost')->money('IDR'),
                TextEntry::make('total')->money('IDR')->weight('bold'),
                TextEntry::make('notes')->columnSpanFull(),
            ])->columns(4),

            InfoSection::make('Items')->schema([
                RepeatableEntry::make('items')->schema([
                    TextEntry::make('name'),
                    TextEntry::make('item_type')->badge()
                        ->color(fn (string $state) => $state === 'customer_owned' ? 'gray' : 'primary'),
                    TextEntry::make('quantity'),
                    TextEntry::make('price')->money('IDR'),
                    TextEntry::make('total')->money('IDR'),
                ])->columns(5)->contained(false),
            ]),

            InfoSection::make('Status History')->schema([
                RepeatableEntry::make('statusHistory')->schema([
                    TextEntry::make('from_status')->placeholder('—'),
                    TextEntry::make('to_status')->badge(),
                    TextEntry::make('user.name')->placeholder('system'),
                    TextEntry::make('created_at')->dateTime('d M Y H:i'),
                    TextEntry::make('notes')->placeholder('—'),
                ])->columns(5)->contained(false),
            ]),
        ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            ViewAction::make()->hidden(),

            Action::make('invoice_pdf')
                ->label('Download Invoice PDF')
                ->icon('heroicon-m-document-arrow-down')
                ->color('gray')
                ->visible(fn () => $this->getRecord()->invoice !== null)
                ->url(fn () => route('admin.invoice.pdf', ['invoice' => $this->getRecord()->invoice]))
                ->openUrlInNewTab(),

            Action::make('advance_status')
                ->label('Ubah Status')
                ->icon('heroicon-m-arrow-path')
                ->form([
                    Select::make('to_status')->label('Status baru')
                        ->options(collect(OrderService::statusFlow()[$this->getRecord()->status] ?? [])
                            ->mapWithKeys(fn ($s) => [$s => ucfirst($s)]))
                        ->required(),
                    Textarea::make('notes'),
                ])
                ->action(function (array $data) {
                    try {
                        OrderService::setStatus($this->getRecord(), $data['to_status'], $data['notes'] ?? null, auth()->user());
                        Notification::make()->title('Status order diubah ke '.ucfirst($data['to_status']))->success()->send();
                    } catch (\DomainException $e) {
                        Notification::make()->title('Gagal')->body($e->getMessage())->danger()->send();
                    }
                })
                ->visible(fn () => ! empty(OrderService::statusFlow()[$this->getRecord()->status])),
        ];
    }
}
