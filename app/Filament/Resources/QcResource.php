<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QcResource\Pages;
use App\Models\QcRecord;
use App\Models\User;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class QcResource extends Resource
{
    protected static ?string $model = QcRecord::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static ?string $navigationGroup = 'Service';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'QC / Testing';

    protected static ?string $modelLabel = 'QC Record';

    protected static ?string $pluralModelLabel = 'QC / Testing';

    public static function resultLabel(string $state): string
    {
        return match ($state) {
            'pass' => 'PASS',
            'fail' => 'FAIL',
            'pending' => 'PENDING',
            default => strtoupper($state),
        };
    }

    public static function resultColor(string $state): string
    {
        return match ($state) {
            'pass' => 'success',
            'fail' => 'danger',
            'pending' => 'warning',
            default => 'gray',
        };
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Informasi Unit & Teknisi')
                ->icon('heroicon-o-clipboard-document-check')
                ->schema([
                    Select::make('service_id')
                        ->label('No. Servis')
                        ->relationship('service', 'code')
                        ->searchable()
                        ->preload()
                        ->helperText('QC untuk service/rakit PC. Untuk order build tanpa service, hubungkan via order.'),
                    Select::make('order_id')
                        ->label('No. Order (Opsional)')
                        ->relationship('order', 'code')
                        ->searchable()
                        ->preload(),
                    Select::make('technician_id')
                        ->label('Teknisi')
                        ->options(fn () => User::query()->whereIn('role', ['owner', 'staff'])->pluck('name', 'id'))
                        ->searchable(),
                ])
                ->columns(['default' => 1, 'md' => 3]),

            Section::make('Checklist Hardware')
                ->icon('heroicon-o-cpu-chip')
                ->schema([
                    CheckboxList::make('checklist_hardware')
                        ->hiddenLabel()
                        ->columns(['default' => 1, 'sm' => 2, 'md' => 3])
                        ->dehydrated(false)
                        ->options(collect(QcRecord::CHECKLIST['hardware'])->mapWithKeys(fn ($label, $key) => [$key => $label])->all()),
                ]),
            Section::make('Checklist Software')
                ->icon('heroicon-o-command-line')
                ->schema([
                    CheckboxList::make('checklist_software')
                        ->hiddenLabel()
                        ->columns(['default' => 1, 'sm' => 2, 'md' => 4])
                        ->dehydrated(false)
                        ->options(collect(QcRecord::CHECKLIST['software'])->mapWithKeys(fn ($label, $key) => [$key => $label])->all()),
                ]),
            Section::make('Checklist Testing')
                ->icon('heroicon-o-beaker')
                ->schema([
                    CheckboxList::make('checklist_testing')
                        ->hiddenLabel()
                        ->columns(['default' => 1, 'sm' => 2, 'md' => 4])
                        ->dehydrated(false)
                        ->options(collect(QcRecord::CHECKLIST['testing'])->mapWithKeys(fn ($label, $key) => [$key => $label])->all()),
                ]),
            Section::make('Hasil Pemeriksaan')
                ->icon('heroicon-o-check-badge')
                ->schema([
                    Radio::make('result')
                        ->label('Hasil QC')
                        ->options(['pass' => 'PASS', 'fail' => 'FAIL', 'pending' => 'PENDING'])
                        ->default('pending')
                        ->required()
                        ->inline(),
                    Textarea::make('notes')
                        ->label('Catatan Teknisi')
                        ->rows(3)
                        ->columnSpanFull(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('service.code')
                    ->label('No. Servis')
                    ->placeholder('—')
                    ->searchable()
                    ->copyable()
                    ->weight('bold')
                    ->description(fn (QcRecord $record): string => ($record->order?->code ? 'Order: '.$record->order->code.' • ' : '').($record->technician?->name ?? 'Belum ada teknisi')),
                TextColumn::make('order.code')->label('No. Order')->placeholder('—')->searchable()->copyable()->visibleFrom('md'),
                TextColumn::make('technician.name')->label('Teknisi')->placeholder('—')->visibleFrom('md'),
                TextColumn::make('result')
                    ->label('Hasil')
                    ->badge()
                    ->color(fn (string $state): string => static::resultColor($state))
                    ->formatStateUsing(fn (string $state): string => static::resultLabel($state))
                    ->description(fn (QcRecord $record): string => $record->checked_at ? $record->checked_at->format('d M Y H:i') : 'Belum dicek'),
                TextColumn::make('checked_at')->label('Waktu Cek')->dateTime('d M Y H:i')->sortable()->visibleFrom('lg'),
            ])
            ->filters([
                SelectFilter::make('result')
                    ->label('Hasil QC')
                    ->options(['pass' => 'PASS', 'fail' => 'FAIL', 'pending' => 'PENDING']),
            ])
            ->actions([
                ActionGroup::make([
                    EditAction::make(),
                    DeleteAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQcs::route('/'),
            'create' => Pages\CreateQc::route('/create'),
            'edit' => Pages\EditQc::route('/{record}/edit'),
        ];
    }
}
