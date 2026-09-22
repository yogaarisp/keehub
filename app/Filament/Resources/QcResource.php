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
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class QcResource extends Resource
{
    protected static ?string $model = QcRecord::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static ?string $navigationGroup = 'Service';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'QC / Testing';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('service_id')->relationship('service', 'code')->searchable()->preload()
                ->helperText('QC untuk service/rakit PC. Untuk order build tanpa service, hubungkan via order.'),
            Select::make('order_id')->relationship('order', 'code')->searchable()->preload(),
            Select::make('technician_id')->label('Technician')->options(fn () => User::query()->whereIn('role', ['owner', 'staff'])->pluck('name', 'id'))->searchable(),

            Section::make('Hardware')->schema([
                CheckboxList::make('checklist_hardware')->columns(3)->dehydrated(false)
                    ->options(collect(QcRecord::CHECKLIST['hardware'])->mapWithKeys(fn ($label, $key) => [$key => $label])->all()),
            ]),
            Section::make('Software')->schema([
                CheckboxList::make('checklist_software')->columns(4)->dehydrated(false)
                    ->options(collect(QcRecord::CHECKLIST['software'])->mapWithKeys(fn ($label, $key) => [$key => $label])->all()),
            ]),
            Section::make('Testing')->schema([
                CheckboxList::make('checklist_testing')->columns(4)->dehydrated(false)
                    ->options(collect(QcRecord::CHECKLIST['testing'])->mapWithKeys(fn ($label, $key) => [$key => $label])->all()),
            ]),
            Radio::make('result')->options(['pass' => 'PASS', 'fail' => 'FAIL', 'pending' => 'PENDING'])->default('pending')->inline(),
            Textarea::make('notes')->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('service.code')->placeholder('—'),
                TextColumn::make('order.code')->placeholder('—'),
                TextColumn::make('technician.name')->placeholder('—'),
                TextColumn::make('result')->badge()->color(fn (string $state) => match ($state) {
                    'pass' => 'success',
                    'fail' => 'danger',
                    'pending' => 'warning',
                }),
                TextColumn::make('checked_at')->dateTime('d M Y H:i'),
            ])
            ->actions([EditAction::make(), DeleteAction::make()])
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
