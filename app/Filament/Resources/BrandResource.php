<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BrandResource\Pages;
use App\Models\Brand;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class BrandResource extends Resource
{
    protected static ?string $model = Brand::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationGroup = 'Catalog';

    protected static ?string $navigationLabel = 'Brand';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Informasi Brand')
                ->icon('heroicon-o-tag')
                ->schema([
                    TextInput::make('name')
                        ->label('Nama Brand')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug((string) $state))),
                    TextInput::make('slug')
                        ->label('Slug URL')
                        ->required()
                        ->unique(ignoreRecord: true),
                    FileUpload::make('logo')
                        ->label('Logo Brand')
                        ->image()
                        ->disk('public')
                        ->directory('brands')
                        ->columnSpanFull(),
                    Toggle::make('is_active')
                        ->label('Brand Aktif')
                        ->default(true)
                        ->columnSpanFull(),
                ])->columns(['default' => 1, 'sm' => 2]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo')
                    ->label('Logo')
                    ->disk('public')
                    ->square()
                    ->size(36)
                    ->checkFileExistence(false)
                    ->visibleFrom('sm'),
                TextColumn::make('name')
                    ->label('Nama Brand')
                    ->searchable()
                    ->sortable()
                    ->weight('semibold')
                    ->description(fn (Brand $record): string => $record->slug),
                TextColumn::make('products_count')
                    ->counts('products')
                    ->label('Produk')
                    ->badge()
                    ->color('info')
                    ->suffix(' produk'),
                IconColumn::make('is_active')->label('Aktif')->boolean()->visibleFrom('md'),
            ])
            ->filters([
                TernaryFilter::make('is_active')->label('Status Aktif'),
            ])
            ->actions([
                ActionGroup::make([
                    EditAction::make(),
                    DeleteAction::make(),
                ]),
            ])
            ->bulkActions([DeleteBulkAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBrands::route('/'),
            'create' => Pages\CreateBrand::route('/create'),
            'edit' => Pages\EditBrand::route('/{record}/edit'),
        ];
    }
}
