<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use App\Models\ProductImage;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
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
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    protected static ?string $navigationGroup = 'Catalog';

    protected static ?string $navigationLabel = 'Produk';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Group::make()
                ->schema([
                    Section::make('Informasi Produk')->schema([
                        TextInput::make('sku')->required()->unique(ignoreRecord: true)->label('SKU'),
                        TextInput::make('name')->required()->live(onBlur: true)->label('Nama Produk')
                            ->afterStateUpdated(fn (Set $set, ?string $state, ?string $operation) => $operation === 'create' ? $set('slug', Str::slug((string) $state)) : null),
                        TextInput::make('slug')->required()->unique(ignoreRecord: true)->label('Slug URL'),
                        Select::make('category_id')->relationship('category', 'name')->required()->searchable()->preload()->label('Kategori'),
                        Select::make('brand_id')->relationship('brand', 'name')->searchable()->preload()->label('Brand'),
                        Textarea::make('description')->columnSpanFull()->label('Deskripsi Produk'),
                    ])->columns(['default' => 1, 'sm' => 2]),

                    Section::make('Harga & Fisik')->schema([
                        TextInput::make('price')->numeric()->prefix('Rp')->minValue(0)->required()->label('Harga Jual'),
                        TextInput::make('cost_price')->numeric()->prefix('Rp')->minValue(0)->label('HPP / Harga Pokok')->helperText('Dipisahkan dari harga jual (PRD rule #15)'),
                        TextInput::make('weight_grams')->numeric()->label('Berat (gram)'),
                        TextInput::make('dimensions')->label('Dimensi (P x L x T)'),
                        TextInput::make('warranty')->label('Garansi'),
                    ])->columns(['default' => 1, 'sm' => 2]),

                    Section::make('Spesifikasi Terstruktur')->schema([
                        Repeater::make('specs_data')->label('Spesifikasi')
                            ->defaultItems(0)
                            ->schema([
                                TextInput::make('key')->required()->label('Field')
                                    ->datalist([
                                        'socket', 'chipset', 'core', 'thread', 'tdp_watt', 'generation', 'capacity_gb',
                                        'frequency_mhz', 'vram_gb', 'memory_type', 'power_consumption_watt', 'length_mm',
                                        'recommended_psu_watt', 'ram_type', 'ram_slots', 'max_ram_gb', 'm2_slots', 'form_factor',
                                        'supported_form_factors', 'wattage', 'efficiency', 'modular', 'height_mm',
                                        'gpu_clearance_mm', 'cooler_clearance_mm', 'integrated_graphics', 'architecture', 'cas_latency',
                                    ]),
                                TextInput::make('value')->required()->label('Nilai'),
                                TextInput::make('value_numeric')->numeric()->nullable()->label('Nilai Angka'),
                                TextInput::make('unit')->label('Satuan'),
                            ])->columns(['default' => 1, 'sm' => 2, 'lg' => 4])
                            ->reorderable()
                            ->helperText('Field teknis harus terstruktur — digunakan Compatibility Engine & Power Calculator (PRD #8, #10, #11).'),
                    ])->collapsible(),
                ])
                ->columnSpan(['lg' => 2]),

            Group::make()
                ->schema([
                    Section::make('Foto Produk')->schema([
                        FileUpload::make('images_upload')
                            ->label('Unggah Foto')
                            ->image()
                            ->imageEditor()
                            ->directory('products')
                            ->disk('public')
                            ->multiple()
                            ->reorderable()
                            ->panelLayout('grid')
                            ->minFiles(0)
                            ->maxFiles(10)
                            ->helperText('Format JPG, PNG, WEBP. Foto paling pertama/teratas menjadi foto utama.'),
                    ]),

                    Section::make('Status & SEO')->schema([
                        Toggle::make('is_active')->label('Produk Aktif')->default(true),
                        Toggle::make('is_featured')->label('Produk Unggulan'),
                        TextInput::make('meta_title')->label('Meta Title')->maxLength(255),
                        Textarea::make('meta_description')->label('Meta Description')->maxLength(500),
                        TextInput::make('keywords')->label('Keywords'),
                    ]),
                ])
                ->columnSpan(['lg' => 1]),
        ])->columns(['default' => 1, 'lg' => 3]);
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
            ->modifyQueryUsing(fn (Builder $query) => $query->with(['category', 'brand', 'inventory', 'images']))
            ->columns([
                ImageColumn::make('images.path')
                    ->label('Foto')
                    ->disk('public')
                    ->square()
                    ->size(44)
                    ->stacked()
                    ->limit(2)
                    ->limitedRemainingText()
                    ->defaultImageUrl(asset('storage/products/placeholder.svg'))
                    ->checkFileExistence(false)
                    ->extraImgAttributes(['class' => 'rounded-lg object-cover shadow-xs border border-gray-200 dark:border-gray-700']),
                TextColumn::make('sku')->label('SKU')->searchable()->sortable()->visibleFrom('lg'),
                TextColumn::make('name')
                    ->label('Nama Produk')
                    ->searchable()
                    ->sortable()
                    ->limit(40)
                    ->description(fn (Product $record): string => ($record->sku ? $record->sku.' • ' : '').'Rp '.number_format((int) $record->price, 0, ',', '.')),
                TextColumn::make('category.name')->label('Kategori')->sortable()->visibleFrom('md'),
                TextColumn::make('brand.name')->label('Brand')->sortable()->visibleFrom('lg'),
                TextColumn::make('price')->label('Harga')->money('IDR')->sortable()->visibleFrom('md'),
                TextColumn::make('inventory.current_stock')->label('Stok')->badge()
                    ->color(fn ($state, $record) => ($state ?? 0) <= 0 ? 'danger' : (($state ?? 0) <= ($record->inventory?->min_stock ?? 0) ? 'warning' : 'success')),
                IconColumn::make('is_active')->label('Aktif')->boolean()->visibleFrom('md'),
            ])
            ->filters([
                SelectFilter::make('category')->relationship('category', 'name')->label('Kategori'),
                SelectFilter::make('brand')->relationship('brand', 'name')->label('Brand'),
                TernaryFilter::make('is_active')->label('Status Aktif'),
            ])
            ->actions([
                ActionGroup::make([
                    EditAction::make(),
                    Action::make('manage_images')
                        ->label('Kelola Foto')
                        ->tooltip('Kelola Foto Produk')
                        ->icon('heroicon-o-photo')
                        ->color('gray')
                        ->modalHeading(fn (Product $record): string => 'Kelola Foto: '.$record->name)
                        ->modalDescription('Upload, atur urutan, atau hapus foto produk. Foto pertama akan menjadi foto utama.')
                        ->modalSubmitActionLabel('Simpan Foto')
                        ->modalWidth('lg')
                        ->form([
                            FileUpload::make('images_upload')
                                ->label('Foto Produk')
                                ->image()
                                ->imageEditor()
                                ->directory('products')
                                ->disk('public')
                                ->multiple()
                                ->reorderable()
                                ->panelLayout('grid')
                                ->maxFiles(10)
                                ->helperText('Klik atau seret foto ke sini. Gambar pertama adalah foto utama.'),
                        ])
                        ->fillForm(fn (Product $record): array => [
                            'images_upload' => $record->images->pluck('path')->toArray(),
                        ])
                        ->action(function (Product $record, array $data): void {
                            $record->images()->delete();
                            foreach (($data['images_upload'] ?? []) as $i => $path) {
                                ProductImage::query()->create([
                                    'product_id' => $record->id,
                                    'path' => $path,
                                    'is_primary' => $i === 0,
                                    'sort_order' => $i,
                                ]);
                            }
                            Notification::make()
                                ->title('Foto produk berhasil disimpan')
                                ->success()
                                ->send();
                        }),
                ]),
            ])
            ->bulkActions([])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\SpecsRelationManager::class,
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
