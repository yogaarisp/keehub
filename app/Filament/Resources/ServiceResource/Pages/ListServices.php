<?php

namespace App\Filament\Resources\ServiceResource\Pages;

use App\Filament\Resources\ServiceResource;
use App\Models\Service;
use App\Models\ServiceStatusHistory;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Database\Eloquent\Builder;

class ListServices extends ListRecords
{
    protected static string $resource = ServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('+ Servis Baru')
                ->modalHeading('Buat Tiket Servis Baru')
                ->modalSubmitActionLabel('Simpan Tiket Servis')
                ->modalCancelAction(false)
                ->modalWidth(MaxWidth::FiveExtraLarge)
                ->url(null)
                ->mutateFormDataUsing(function (array $data): array {
                    $data['code'] = $data['code'] ?? Service::generateCode();
                    $data['invoice_number'] = $data['invoice_number'] ?? Service::generateInvoiceNumber();

                    return $data;
                })
                ->after(function (Service $record) {
                    foreach ($record->items as $item) {
                        $item->total = (int) $item->quantity * (int) $item->price;
                        $item->save();
                    }

                    $record->syncTotalCost();

                    ServiceStatusHistory::query()->create([
                        'service_id' => $record->id,
                        'from_status' => null,
                        'to_status' => $record->status,
                        'notes' => 'Servis baru dibuat oleh admin (B2B / Manual)',
                        'user_id' => auth()->id(),
                    ]);
                })
                ->successNotificationTitle('Tiket servis baru berhasil dibuat!')
                ->successRedirectUrl(fn (Service $record): string => ServiceResource::getUrl('view', ['record' => $record]))
                ->createAnother(false),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Semua'),
            'processing' => Tab::make('Dalam Proses')
                ->badge(fn () => Service::query()->whereIn('status', ['received', 'checking', 'waiting_approval', 'processing', 'testing'])->count())
                ->badgeColor('warning')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereIn('status', ['received', 'checking', 'waiting_approval', 'processing', 'testing'])),
            'ready' => Tab::make('Siap Diambil')
                ->badge(fn () => Service::query()->where('status', 'ready')->count())
                ->badgeColor('success')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'ready')),
            'completed' => Tab::make('Selesai')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'completed')),
        ];
    }
}
