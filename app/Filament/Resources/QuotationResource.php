<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuotationResource\Pages;
use App\Models\Quotation;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class QuotationResource extends Resource
{
    protected static ?string $model = Quotation::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Sales';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('customer_id')->relationship('customer', 'name')->searchable()->preload(),
            DatePicker::make('quotation_date')->default(today())->required(),
            DatePicker::make('expired_date'),
            TextInput::make('discount')->numeric()->prefix('Rp')->default(0),
            TextInput::make('shipping')->numeric()->prefix('Rp')->default(0),
            Select::make('status')->options(array_combine(Quotation::STATUSES, array_map(ucfirst(...), Quotation::STATUSES)))->default('draft'),
            Textarea::make('notes')->columnSpanFull(),
            Textarea::make('terms')->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')->searchable()->sortable(),
                TextColumn::make('customer.name')->default('—'),
                TextColumn::make('total')->money('IDR')->sortable(),
                TextColumn::make('status')->badge()->color(fn (string $state) => match ($state) {
                    'draft' => 'gray',
                    'sent' => 'info',
                    'accepted' => 'success',
                    'rejected' => 'danger',
                    'expired' => 'warning',
                    'converted' => 'primary',
                }),
                TextColumn::make('expired_date')->date('d M Y'),
            ])
            ->filters([
                SelectFilter::make('status')->options(array_combine(Quotation::STATUSES, array_map(ucfirst(...), Quotation::STATUSES))),
            ])
            ->actions([ViewAction::make()])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuotations::route('/'),
            'create' => Pages\CreateQuotation::route('/create'),
            'view' => Pages\ViewQuotation::route('/{record}'),
        ];
    }
}
