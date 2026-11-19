<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectInvoiceResource\Pages;
use App\Models\Customer;
use App\Models\ProjectInvoice;
use App\Models\Setting;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;

class ProjectInvoiceResource extends Resource
{
    protected static ?string $model = ProjectInvoice::class;

    protected static ?string $navigationIcon = 'heroicon-o-code-bracket-square';

    protected static ?string $navigationGroup = 'Keetech Solutions';

    protected static ?string $navigationLabel = 'Invoice Project (Keetech)';

    protected static ?string $modelLabel = 'Invoice Project';

    protected static ?string $pluralModelLabel = 'Invoice Project';

    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        $count = ProjectInvoice::whereIn('status', ['unpaid', 'partial'])->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(['default' => 1, 'lg' => 12])->schema([
                // Kolom Kiri: Detail Project, Klien & Scope
                Group::make([
                    Section::make('Informasi Project & Klien')
                        ->icon('heroicon-o-briefcase')
                        ->description('Data project website / aplikasi dan identitas klien atau perusahaan')
                        ->schema([
                            Grid::make(['default' => 1, 'sm' => 2])->schema([
                                TextInput::make('project_name')
                                    ->label('Nama Project / Aplikasi')
                                    ->placeholder('Contoh: Pengembangan Website Profil & Sistem Kasir')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpan(['default' => 1, 'sm' => 2]),

                                Select::make('project_type')
                                    ->label('Kategori Layanan')
                                    ->options(ProjectInvoice::PROJECT_TYPES)
                                    ->default('website')
                                    ->required(),

                                Select::make('payment_term')
                                    ->label('Tahapan / Termin')
                                    ->options(ProjectInvoice::PAYMENT_TERMS)
                                    ->default('full')
                                    ->required()
                                    ->live(),

                                TextInput::make('payment_term_label')
                                    ->label('Label Termin Khusus (Opsional)')
                                    ->placeholder('Contoh: DP 50% di awal sebelum development')
                                    ->maxLength(255)
                                    ->columnSpan(['default' => 1, 'sm' => 2]),
                            ]),

                            Grid::make(['default' => 1, 'sm' => 3])->schema([
                                Select::make('customer_id')
                                    ->label('Pilih Klien Terdaftar (Opsional)')
                                    ->options(fn () => Customer::pluck('name', 'id'))
                                    ->searchable()
                                    ->preload()
                                    ->live()
                                    ->afterStateUpdated(function (Get $get, Set $set, ?string $state): void {
                                        if ($state && ($customer = Customer::find($state))) {
                                            $set('client_name', $customer->name);
                                            $set('client_phone', $customer->whatsapp);
                                            $set('client_email', $customer->email);
                                        }
                                    })
                                    ->placeholder('Pilih dari kontak klien...'),

                                TextInput::make('client_name')
                                    ->label('Nama Klien / PIC')
                                    ->placeholder('Contoh: Bpk. Budi Santoso')
                                    ->required()
                                    ->maxLength(255),

                                TextInput::make('client_company')
                                    ->label('Perusahaan / Instansi (Opsional)')
                                    ->placeholder('Contoh: PT Surya Pratama Mandiri')
                                    ->maxLength(255),

                                TextInput::make('client_phone')
                                    ->label('WhatsApp / Nomor HP')
                                    ->placeholder('0812-xxxx-xxxx')
                                    ->tel(),

                                TextInput::make('client_email')
                                    ->label('Email Klien')
                                    ->placeholder('klien@perusahaan.com')
                                    ->email(),

                                Textarea::make('client_address')
                                    ->label('Alamat Klien / Kantor')
                                    ->placeholder('Alamat domisili atau kantor instansi...')
                                    ->rows(2)
                                    ->columnSpan(['default' => 1, 'sm' => 3]),
                            ]),
                        ]),

                    Section::make('Ruang Lingkup Pekerjaan (Scope of Work & Items)')
                        ->icon('heroicon-o-list-bullet')
                        ->description('Rincian modul, fitur aplikasi, atau jasa implementasi yang ditagihkan')
                        ->schema([
                            Repeater::make('items')
                                ->relationship('items')
                                ->hiddenLabel()
                                ->schema([
                                    Grid::make(['default' => 1, 'sm' => 12])->schema([
                                        TextInput::make('item_name')
                                            ->label('Nama Item / Modul Fitur')
                                            ->placeholder('Contoh: Frontend Responsive & Integrasi Payment Gateway')
                                            ->required()
                                            ->columnSpan(['default' => 1, 'sm' => 12]),

                                        Textarea::make('description')
                                            ->label('Rincian / Scope Pekerjaan (Opsional)')
                                            ->placeholder('Rincian fitur: Halaman Katalog, Keranjang Belanja, Integrasi Midtrans, Notifikasi WhatsApp...')
                                            ->rows(2)
                                            ->columnSpan(['default' => 1, 'sm' => 12]),

                                        TextInput::make('quantity')
                                            ->label('Qty')
                                            ->numeric()
                                            ->default(1)
                                            ->minValue(1)
                                            ->required()
                                            ->live()
                                            ->afterStateUpdated(function (Get $get, Set $set): void {
                                                $qty = max(1, (int) ($get('quantity') ?? 1));
                                                $price = max(0, (int) ($get('price') ?? 0));
                                                $set('total', $qty * $price);
                                            })
                                            ->columnSpan(['default' => 1, 'sm' => 2]),

                                        TextInput::make('unit')
                                            ->label('Satuan')
                                            ->default('Paket')
                                            ->placeholder('Paket/Bulan/Modul')
                                            ->required()
                                            ->columnSpan(['default' => 1, 'sm' => 3]),

                                        TextInput::make('price')
                                            ->label('Harga Satuan')
                                            ->numeric()
                                            ->prefix('Rp')
                                            ->default(0)
                                            ->required()
                                            ->live(debounce: 350)
                                            ->afterStateUpdated(function (Get $get, Set $set): void {
                                                $qty = max(1, (int) ($get('quantity') ?? 1));
                                                $price = max(0, (int) ($get('price') ?? 0));
                                                $set('total', $qty * $price);
                                            })
                                            ->columnSpan(['default' => 1, 'sm' => 4]),

                                        TextInput::make('total')
                                            ->label('Total')
                                            ->numeric()
                                            ->prefix('Rp')
                                            ->dehydrated()
                                            ->readOnly()
                                            ->columnSpan(['default' => 1, 'sm' => 3]),
                                    ]),
                                ])
                                ->defaultItems(1)
                                ->reorderableWithButtons()
                                ->collapsible()
                                ->addActionLabel('+ Tambah Item / Modul Fitur'),
                        ]),

                    Section::make('Ketentuan, Garansi & Rekening Pembayaran')
                        ->icon('heroicon-o-shield-check')
                        ->collapsed()
                        ->schema([
                            Grid::make(['default' => 1, 'sm' => 2])->schema([
                                Textarea::make('terms')
                                    ->label('Syarat & Ketentuan Project')
                                    ->rows(4)
                                    ->default("1. Penyerahan source code dan akses admin dilakukan setelah kewajiban pembayaran terselesaikan.\n2. Termasuk garansi perbaikan bug / error teknis selama 30 hari kalender sejak tanggal serah terima.\n3. Perubahan fitur baru di luar ruang lingkup (scope) yang tertera akan dicatat sebagai addendum terpisah."),

                                Textarea::make('notes')
                                    ->label('Catatan Tambahan / SLA Garansi')
                                    ->rows(4)
                                    ->placeholder('Contoh: Termasuk maintenance cloud hosting & domain selama 1 tahun pertama.'),
                            ]),

                            Grid::make(['default' => 1, 'sm' => 3])->schema([
                                TextInput::make('bank_name')
                                    ->label('Bank')
                                    ->default(fn () => Setting::get('bank_name', 'BCA')),

                                TextInput::make('bank_account_number')
                                    ->label('Nomor Rekening')
                                    ->default(fn () => Setting::get('bank_account_number', '8030808861')),

                                TextInput::make('bank_account_holder')
                                    ->label('Atas Nama')
                                    ->default(fn () => Setting::get('bank_account_holder', 'PT Keetech Solusi Indonesia')),
                            ]),

                            TextInput::make('signer_name')
                                ->label('Nama Bagian Penandatangan / Finance')
                                ->default('Keetech Finance & Billing')
                                ->maxLength(255),
                        ]),
                ])->columnSpan(['default' => 1, 'lg' => 8]),

                // Kolom Kanan: Status & Ringkasan Finansial
                Group::make([
                    Section::make('Status & Dokumen')
                        ->icon('heroicon-o-document')
                        ->schema([
                            TextInput::make('code')
                                ->label('Nomor Invoice')
                                ->placeholder('Otomatis di-generate sistem')
                                ->readOnly()
                                ->dehydrated(),

                            Grid::make(2)->schema([
                                DatePicker::make('invoice_date')
                                    ->label('Tgl Invoice')
                                    ->default(today())
                                    ->required(),

                                DatePicker::make('due_date')
                                    ->label('Jatuh Tempo')
                                    ->default(fn () => today()->addDays(14)),
                            ]),

                            Select::make('status')
                                ->label('Status Pembayaran')
                                ->options(ProjectInvoice::STATUSES)
                                ->default('unpaid')
                                ->required()
                                ->live(),
                        ]),

                    Section::make('Ringkasan Finansial')
                        ->icon('heroicon-o-calculator')
                        ->schema([
                            TextInput::make('discount')
                                ->label('Potongan Diskon')
                                ->numeric()
                                ->prefix('Rp')
                                ->default(0)
                                ->minValue(0)
                                ->live(debounce: 350),

                            TextInput::make('tax')
                                ->label('PPN / Pajak (Opsional)')
                                ->numeric()
                                ->prefix('Rp')
                                ->default(0)
                                ->minValue(0)
                                ->live(debounce: 350),

                            TextInput::make('paid_amount')
                                ->label('Nominal Sudah Dibayar (DP / Titipan)')
                                ->numeric()
                                ->prefix('Rp')
                                ->default(0)
                                ->minValue(0)
                                ->live(debounce: 350)
                                ->helperText('Isi jika klien sudah melakukan DP / pembayaran sebagian.'),

                            Placeholder::make('financial_breakdown')
                                ->label('Kalkulasi Live')
                                ->content(function (Get $get): HtmlString {
                                    $items = $get('items') ?? [];
                                    $subtotal = 0;
                                    foreach ($items as $item) {
                                        $qty = max(1, (int) ($item['quantity'] ?? 1));
                                        $price = max(0, (int) ($item['price'] ?? 0));
                                        $subtotal += ($qty * $price);
                                    }
                                    $discount = max(0, (int) ($get('discount') ?? 0));
                                    $tax = max(0, (int) ($get('tax') ?? 0));
                                    $total = max(0, $subtotal - $discount + $tax);
                                    $paid = max(0, (int) ($get('paid_amount') ?? 0));
                                    $remaining = max(0, $total - $paid);

                                    return new HtmlString('
                                        <div class="rounded-lg bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 p-3 space-y-1.5 text-xs">
                                            <div class="flex justify-between text-slate-600 dark:text-slate-400">
                                                <span>Subtotal Items:</span>
                                                <span class="font-semibold text-slate-800 dark:text-slate-200">Rp '.number_format($subtotal, 0, ',', '.').'</span>
                                            </div>
                                            '.($discount > 0 ? '
                                            <div class="flex justify-between text-rose-600 dark:text-rose-400">
                                                <span>Diskon:</span>
                                                <span>-Rp '.number_format($discount, 0, ',', '.').'</span>
                                            </div>' : '').'
                                            '.($tax > 0 ? '
                                            <div class="flex justify-between text-slate-600 dark:text-slate-400">
                                                <span>PPN / Pajak:</span>
                                                <span>Rp '.number_format($tax, 0, ',', '.').'</span>
                                            </div>' : '').'
                                            <div class="pt-1.5 border-t border-slate-200 dark:border-slate-700 flex justify-between font-bold text-sm text-sky-600 dark:text-sky-400">
                                                <span>Grand Total:</span>
                                                <span>Rp '.number_format($total, 0, ',', '.').'</span>
                                            </div>
                                            '.($paid > 0 ? '
                                            <div class="flex justify-between text-emerald-600 dark:text-emerald-400 font-semibold">
                                                <span>Telah Dibayar (DP):</span>
                                                <span>Rp '.number_format($paid, 0, ',', '.').'</span>
                                            </div>' : '').'
                                            <div class="pt-1 border-t border-dashed border-slate-200 dark:border-slate-700 flex justify-between font-bold text-xs '.($remaining > 0 ? 'text-amber-600 dark:text-amber-400' : 'text-emerald-600 dark:text-emerald-400').'">
                                                <span>Sisa Tagihan:</span>
                                                <span>Rp '.number_format($remaining, 0, ',', '.').'</span>
                                            </div>
                                        </div>
                                    ');
                                }),
                        ]),
                ])->columnSpan(['default' => 1, 'lg' => 4]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->label('No. Invoice')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->weight('bold')
                    ->color('primary'),

                TextColumn::make('project_name')
                    ->label('Project / Layanan')
                    ->searchable()
                    ->weight('semibold')
                    ->description(fn (ProjectInvoice $record): string => $record->projectTypeLabel())
                    ->wrap(),

                TextColumn::make('client_name')
                    ->label('Klien')
                    ->searchable()
                    ->description(fn (ProjectInvoice $record): ?string => $record->client_company)
                    ->wrap(),

                TextColumn::make('payment_term')
                    ->label('Termin')
                    ->badge()
                    ->color('info')
                    ->formatStateUsing(fn (ProjectInvoice $record): string => $record->paymentTermLabel()),

                TextColumn::make('total')
                    ->label('Total Tagihan')
                    ->money('IDR')
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('paid_amount')
                    ->label('Dibayar')
                    ->money('IDR')
                    ->color(fn (ProjectInvoice $record): string => $record->paid_amount > 0 ? 'success' : 'gray'),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (ProjectInvoice $record): string => $record->statusColor())
                    ->formatStateUsing(fn (string $state): string => ProjectInvoice::STATUSES[$state] ?? ucfirst($state)),

                TextColumn::make('invoice_date')
                    ->label('Tgl Invoice')
                    ->date('d M Y')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('due_date')
                    ->label('Jatuh Tempo')
                    ->date('d M Y')
                    ->sortable()
                    ->toggleable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->label('Status Pembayaran')
                    ->options(ProjectInvoice::STATUSES),

                SelectFilter::make('project_type')
                    ->label('Kategori Project')
                    ->options(ProjectInvoice::PROJECT_TYPES),
            ])
            ->actions([
                ActionGroup::make([
                    // Cetak / View PDF di browser
                    Action::make('preview_pdf')
                        ->label('Cetak / View PDF')
                        ->icon('heroicon-o-printer')
                        ->color('info')
                        ->url(fn (ProjectInvoice $record): string => route('admin.project-invoice.pdf', $record))
                        ->openUrlInNewTab(),

                    // Download PDF langsung
                    Action::make('download_pdf')
                        ->label('Download File PDF')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->color('success')
                        ->url(fn (ProjectInvoice $record): string => route('admin.project-invoice.pdf.download', $record)),

                    // Kirim Pesan WhatsApp Tagihan ke Klien
                    Action::make('send_whatsapp')
                        ->label('Kirim WhatsApp Tagihan')
                        ->icon('heroicon-o-chat-bubble-left-right')
                        ->color('success')
                        ->visible(fn (ProjectInvoice $record): bool => ! empty($record->client_phone))
                        ->url(function (ProjectInvoice $record): string {
                            $phone = preg_replace('/[^0-9]/', '', $record->client_phone);
                            if (str_starts_with($phone, '0')) {
                                $phone = '62'.substr($phone, 1);
                            }

                            $publicUrl = route('project-invoice.public.pdf', $record);
                            $msg = "Halo Bpk/Ibu *{$record->client_name}*,\n\n"
                                ."Berikut kami sampaikan tagihan resmi untuk project *{$record->project_name}* dari PT Keetech Solusi Indonesia:\n\n"
                                ."📄 *No. Invoice:* {$record->code}\n"
                                ."📌 *Termin:* {$record->paymentTermLabel()}\n"
                                .'💰 *Total Tagihan:* Rp '.number_format($record->total, 0, ',', '.')."\n"
                                .($record->paid_amount > 0 ? '✅ *Sudah Dibayar:* Rp '.number_format($record->paid_amount, 0, ',', '.')."\n" : '')
                                .'⚡ *Sisa Pembayaran:* Rp '.number_format($record->remainingAmount(), 0, ',', '.')."\n\n"
                                ."Bank Transfer:\n"
                                ."*{$record->bank_name}*: `{$record->bank_account_number}` a/n {$record->bank_account_holder}\n\n"
                                ."Dokumen PDF dapat diakses melalui:\n{$publicUrl}\n\n"
                                ."Terima kasih atas kerja samanya.\n*PT Keetech Solusi Indonesia*";

                            return 'https://api.whatsapp.com/send?phone='.$phone.'&text='.urlencode($msg);
                        })
                        ->openUrlInNewTab(),

                    // Action Cepat Tandai Lunas
                    Action::make('mark_paid')
                        ->label('Tandai Lunas (100%)')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->visible(fn (ProjectInvoice $record): bool => $record->status !== 'paid')
                        ->action(function (ProjectInvoice $record): void {
                            $record->update([
                                'status' => 'paid',
                                'paid_amount' => $record->total,
                            ]);

                            Notification::make()
                                ->title('Invoice Ditandai Lunas')
                                ->body("Invoice {$record->code} berhasil diperbarui menjadi Lunas.")
                                ->success()
                                ->send();
                        }),

                    EditAction::make(),
                    DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjectInvoices::route('/'),
            'create' => Pages\CreateProjectInvoice::route('/create'),
            'edit' => Pages\EditProjectInvoice::route('/{record}/edit'),
        ];
    }
}
