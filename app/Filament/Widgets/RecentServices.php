<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ServiceResource;
use App\Models\Service;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class RecentServices extends TableWidget
{
    protected static ?string $heading = 'Antrean Servis Aktif';

    protected static ?int $sort = 4;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Service::query()
                    ->with(['customer', 'technician'])
                    ->whereNotIn('status', ['completed', 'cancelled'])
                    ->orderByRaw('CASE WHEN due_date IS NULL THEN 1 ELSE 0 END, due_date ASC')
                    ->latest()
                    ->limit(6)
            )
            ->paginated(false)
            ->headerActions([
                Action::make('all_services')
                    ->label('Lihat Semua')
                    ->url(ServiceResource::getUrl('index'))
                    ->color('gray')
                    ->size('xs'),
            ])
            ->columns([
                TextColumn::make('code')
                    ->label('No. Servis')
                    ->weight('semibold')
                    ->description(fn (Service $record): string => ($record->customer?->name ?? 'Umum').' • '.($record->device_name ?: 'Unit PC')),

                TextColumn::make('customer.name')
                    ->label('Klien')
                    ->default('—')
                    ->visibleFrom('md'),

                TextColumn::make('device_name')
                    ->label('Unit / Perangkat')
                    ->limit(28)
                    ->default('—')
                    ->visibleFrom('md'),

                TextColumn::make('technician.name')
                    ->label('Teknisi')
                    ->placeholder('Belum ditugaskan')
                    ->visibleFrom('lg'),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'received' => 'gray',
                        'checking' => 'warning',
                        'waiting_approval' => 'info',
                        'processing', 'testing' => 'primary',
                        'ready', 'completed' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'received' => 'Masuk',
                        'checking' => 'Pengecekan',
                        'waiting_approval' => 'Approval',
                        'processing' => 'Dikerjakan',
                        'testing' => 'QC Test',
                        'ready' => 'Siap Ambil',
                        'completed' => 'Selesai',
                        'cancelled' => 'Dibatalkan',
                        default => ucfirst(str_replace('_', ' ', $state)),
                    }),

                TextColumn::make('due_date')
                    ->label('Target Selesai')
                    ->date('d M Y')
                    ->placeholder('—')
                    ->visibleFrom('sm')
                    ->alignEnd(),
            ])
            ->recordUrl(fn (Service $record): string => ServiceResource::getUrl('view', ['record' => $record]))
            ->emptyStateHeading('Tidak ada antrean servis aktif')
            ->emptyStateDescription('Semua unit servis sudah selesai atau belum ada permintaan baru.')
            ->emptyStateIcon('heroicon-o-wrench-screwdriver');
    }
}
