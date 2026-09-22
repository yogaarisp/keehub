<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Models\Service;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';

    protected static ?string $navigationGroup = 'Service';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('customer_id')->relationship('customer', 'name')->searchable()->preload()
                ->createOptionForm([
                    TextInput::make('name')->required(),
                    TextInput::make('whatsapp')->required()->tel(),
                    TextInput::make('email')->email(),
                ]),
            Select::make('source')->options([
                'website' => 'Website',
                'walk_in' => 'Walk-in (datang langsung)',
                'whatsapp' => 'WhatsApp',
                'admin' => 'Admin manual',
            ])->default('admin'),
            Select::make('service_type')->options(Service::TYPES)->required(),
            Textarea::make('problem_description')->columnSpanFull(),
            Select::make('technician_id')->label('Technician')->options(fn () => User::query()->whereIn('role', ['owner', 'staff'])->pluck('name', 'id'))->searchable(),
            Textarea::make('diagnosis')->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')->searchable()->sortable(),
                TextColumn::make('customer.name')->default('—'),
                TextColumn::make('service_type')->badge()->formatStateUsing(fn ($state) => Service::TYPES[$state] ?? $state),
                TextColumn::make('technician.name')->placeholder('—'),
                TextColumn::make('status')->badge()->color(fn (string $state) => match ($state) {
                    'received' => 'gray',
                    'checking' => 'warning',
                    'waiting_approval' => 'info',
                    'processing', 'testing' => 'primary',
                    'ready' => 'success',
                    'completed' => 'success',
                    'cancelled' => 'danger',
                }),
                TextColumn::make('created_at')->dateTime('d M Y H:i')->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')->options(array_combine(Service::STATUSES, array_map(fn ($s) => str_replace('_', ' ', ucfirst($s)), Service::STATUSES))),
            ])
            ->actions([EditAction::make()])
            ->defaultSort('created_at', 'desc')
            ->poll('60s');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
            'view' => Pages\ViewService::route('/{record}'),
        ];
    }
}
