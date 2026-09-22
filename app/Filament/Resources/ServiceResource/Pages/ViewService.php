<?php

namespace App\Filament\Resources\ServiceResource\Pages;

use App\Filament\Resources\ServiceResource;
use App\Models\Service;
use App\Services\ServiceService;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Section as InfoSection;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;

class ViewService extends ViewRecord
{
    protected static string $resource = ServiceResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            InfoSection::make('Service '.$this->getRecord()->code)->schema([
                TextEntry::make('customer.name')->default('—')->label('Customer'),
                TextEntry::make('customer.whatsapp'),
                TextEntry::make('service_type')->formatStateUsing(fn ($state) => Service::TYPES[$state] ?? $state)->badge(),
                TextEntry::make('source'),
                TextEntry::make('technician.name')->default('—')->label('Technician'),
                TextEntry::make('status')->badge(),
                TextEntry::make('problem_description')->columnSpanFull(),
                TextEntry::make('diagnosis')->columnSpanFull(),
            ])->columns(3),

            InfoSection::make('Items')->schema([
                RepeatableEntry::make('items')->schema([
                    TextEntry::make('name'),
                    TextEntry::make('item_type')->badge()
                        ->color(fn (string $state) => $state === 'customer_owned' ? 'gray' : ($state === 'labor' ? 'warning' : 'primary')),
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

            Action::make('advance_status')
                ->label('Ubah Status')
                ->icon('heroicon-m-arrow-path')
                ->form([
                    Select::make('to_status')->label('Status baru')
                        ->options(collect(ServiceService::statusFlow()[$this->getRecord()->status] ?? [])
                            ->mapWithKeys(fn ($s) => [$s => str_replace('_', ' ', ucfirst($s))]))
                        ->required(),
                    Textarea::make('notes'),
                ])
                ->action(function (array $data) {
                    try {
                        ServiceService::setStatus($this->getRecord(), $data['to_status'], $data['notes'] ?? null, auth()->user());
                        Notification::make()->title('Status service diubah')->success()->send();
                    } catch (\DomainException $e) {
                        Notification::make()->title('Gagal')->body($e->getMessage())->danger()->send();
                    }
                })
                ->visible(fn () => ! empty(ServiceService::statusFlow()[$this->getRecord()->status])),
        ];
    }
}
