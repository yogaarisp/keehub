<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    protected static ?string $navigationGroup = 'Catalog';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Informasi Produk')->schema([
                TextInput::make('sku')->required()->unique(ignoreRecord: true)->label('SKU'),
                TextInput::make('name')->required()->live(onBlur: true)
                    ->afterStateUpdated(fn (Set $set, ?string $state, ?string $operation) => $operation === 'create' ? $set('slug', Str::slug((string) $state)) : null),
                TextInput::make('slug')->required()->unique(ignoreRecord: true),
                Select::make('category_id')->relationship('category', 'name')->required()->searchable()->preload(),
                Select::make('brand_id')->relationship('brand', 'name')->searchable()->preload(),
                Textarea::make('description')->columnSpanFull(),
            ])->columns(2),

            Section::make('Harga & Fisik')->schema([
                TextInput::make('price')->numeric()->prefix('Rp')->minValue(0)->required(),
                TextInput::make('cost_price')->numeric()->prefix('Rp')->minValue(0)->label('HPP / Harga Pokok')->helperText('Dipisahkan dari harga jual (PRD rule #15)'),
                TextInput::make('weight_grams')->numeric()->label('Berat (gram)'),
                TextInput::make('dimensions')->label('Dimensi (P x L x T)'),
                TextInput::make('warranty')->label('Garansi'),
            ])->columns(2),

            Section::make('Gambar')->schema([
                FileUpload::make('images_upload')->image()->imageEditor()->directory('products')->multiple()->minFiles(0)->maxFiles(10)
                    ->helperText('Gambar dioptimalkan otomatis (WebP + thumbnail).'),
            ])->collapsible(),

            Section::make('Spesifikasi Terstruktur')->schema([
                Repeater::make('specs_data')->label('Spesifikasi')
                    ->schema([
                        TextInput::make('key')->required()->label('Field')
                            ->datalist([
                                'socket', 'chipset', 'core', 'thread', 'tdp_watt', 'generation', 'capacity_gb',
                                'frequency_mhz', 'vram_gb', 'memory_type', 'power_consumption_watt', 'length_mm',
                                'recommended_psu_watt', 'ram_type', 'ram_slots', 'max_ram_gb', 'm2_slots', 'form_factor',
                                'supported_form_factors', 'wattage', 'efficiency', 'modular', 'height_mm',
                                'gpu_clearance_mm', 'cooler_clearance_mm', 'integrated_graphics', 'architecture', 'cas_latency',
                            ]),
                        TextInput::make('value')->required(),
                        TextInput::make('value_numeric')->numeric()->nullable()->label('Nilai Angka'),
                        TextInput::make('unit')->label('Satuan'),
                    ])->columns(4)
                    ->reorderable()
                    ->helperText('Field teknis harus terstruktur — digunakan Compatibility Engine & Power Calculator (PRD #8, #10, #11).'),
            ])->collapsible(),

            Section::make('Status & SEO')->schema([
                Toggle::make('is_active')->default(true),
                Toggle::make('is_featured'),
                TextInput::make('meta_title')->maxLength(255),
                Textarea::make('meta_description')->maxLength(500),
                TextInput::make('keywords'),
            ])->columns(2),
        ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            TextEntry::make('stock')->label('Stok Saat Ini')->state(fn (Product $record) => $record->inventory?->current_stock ?? 0),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('sku')->searchable(),
                TextColumn::make('name')->searchable()->sortable()->limit(40),
                TextColumn::make('category.name')->sortable(),
                TextColumn::make('brand.name')->sortable(),
                TextColumn::make('price')->money('IDR')->sortable(),
                TextColumn::make('inventory.current_stock')->label('Stock')->badge()
                    ->color(fn ($state, $record) => ($state ?? 0) <= 0 ? 'danger' : (($state ?? 0) <= ($record->inventory?->min_stock ?? 0) ? 'warning' : 'success')),
                IconColumn::make('is_active')->boolean(),
            ])
            ->filters([
                SelectFilter::make('category')->relationship('category', 'name'),
                SelectFilter::make('brand')->relationship('brand', 'name'),
                TernaryFilter::make('is_active'),
            ])
            ->actions([EditAction::make()])
            ->bulkActions([])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\SpecsRelationManager::class,
            RelationManagers\ImagesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
