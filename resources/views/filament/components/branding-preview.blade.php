@php
    $logoUrl = \App\Models\Setting::logoUrl();
    $faviconUrl = \App\Models\Setting::faviconUrl();
    $heroBgUrl = \App\Models\Setting::heroBackgroundUrl();
    $storeName = \App\Models\Setting::get('store_name', 'KeeHub') ?: 'KeeHub';

    $hasCustomLogo = \App\Models\Setting::storedFileUrl('store_logo') !== null;
    $hasCustomFavicon = \App\Models\Setting::storedFileUrl('store_favicon') !== null;
    $hasCustomHero = $heroBgUrl !== null;
@endphp

<style>
    .kh-branding-wrap {
        border: 1px solid #e2e8f0;
        border-radius: 0.75rem;
        background: #f8fafc;
        padding: 1rem;
    }
    .dark .kh-branding-wrap {
        border-color: rgba(255, 255, 255, 0.1);
        background: rgba(17, 24, 39, 0.55);
    }
    .kh-branding-header {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 0.5rem;
        margin-bottom: 0.875rem;
    }
    .kh-branding-title {
        font-size: 0.875rem;
        font-weight: 600;
        color: #0f172a;
        margin: 0;
    }
    .dark .kh-branding-title {
        color: #f8fafc;
    }
    .kh-branding-subtitle {
        font-size: 0.75rem;
        color: #64748b;
        margin: 0;
    }
    .dark .kh-branding-subtitle {
        color: #94a3b8;
    }
    .kh-branding-grid {
        display: grid;
        grid-template-columns: repeat(1, minmax(0, 1fr));
        gap: 0.75rem;
    }
    @media (min-width: 768px) {
        .kh-branding-grid {
            grid-template-columns: repeat(4, minmax(0, 1fr));
        }
        .kh-branding-hero-col {
            grid-column: span 2 / span 2;
        }
    }
    .kh-branding-card {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        gap: 0.625rem;
        border: 1px solid #e2e8f0;
        border-radius: 0.625rem;
        background: #ffffff;
        padding: 0.75rem;
    }
    .dark .kh-branding-card {
        border-color: rgba(255, 255, 255, 0.08);
        background: #0f172a;
    }
    .kh-branding-card-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.5rem;
    }
    .kh-branding-label {
        font-size: 0.75rem;
        font-weight: 600;
        color: #334155;
    }
    .dark .kh-branding-label {
        color: #e2e8f0;
    }
    .kh-badge-custom {
        display: inline-flex;
        align-items: center;
        border-radius: 9999px;
        background: #ecfdf5;
        color: #047857;
        border: 1px solid #a7f3d0;
        padding: 0.125rem 0.5rem;
        font-size: 0.6875rem;
        font-weight: 600;
    }
    .dark .kh-badge-custom {
        background: rgba(16, 185, 129, 0.15);
        color: #6ee7b7;
        border-color: rgba(16, 185, 129, 0.35);
    }
    .kh-badge-default {
        display: inline-flex;
        align-items: center;
        border-radius: 9999px;
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #cbd5e1;
        padding: 0.125rem 0.5rem;
        font-size: 0.6875rem;
        font-weight: 600;
    }
    .dark .kh-badge-default {
        background: rgba(148, 163, 184, 0.15);
        color: #cbd5e1;
        border-color: rgba(148, 163, 184, 0.25);
    }
    .kh-asset-box {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 5.5rem;
        border-radius: 0.5rem;
        border: 1px dashed #cbd5e1;
        background: #f8fafc;
        padding: 0.5rem;
    }
    .dark .kh-asset-box {
        border-color: rgba(255, 255, 255, 0.12);
        background: rgba(30, 41, 59, 0.6);
    }
    .kh-tab-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        max-width: 100%;
        border: 1px solid #e2e8f0;
        border-radius: 0.5rem;
        background: #ffffff;
        padding: 0.45rem 0.75rem;
        font-size: 0.75rem;
        font-weight: 500;
        color: #0f172a;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    }
    .dark .kh-tab-pill {
        border-color: rgba(255, 255, 255, 0.12);
        background: #0f172a;
        color: #f8fafc;
    }
    .kh-hero-box {
        position: relative;
        overflow: hidden;
        height: 5.5rem;
        border-radius: 0.5rem;
        background: linear-gradient(135deg, #030712 0%, #111827 55%, #1f2937 100%);
        display: flex;
        align-items: center;
        padding: 0.75rem 1rem;
        color: #ffffff;
    }
    .kh-hero-img {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
    }
    .kh-hero-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(90deg, rgba(2, 6, 23, 0.88) 0%, rgba(2, 6, 23, 0.68) 60%, rgba(2, 6, 23, 0.45) 100%);
    }
    .kh-hero-text {
        position: relative;
        z-index: 1;
        line-height: 1.2;
    }
</style>

<div class="kh-branding-wrap">
    <div class="kh-branding-header">
        <p class="kh-branding-title">Gambar Aktif Saat Ini</p>
        <p class="kh-branding-subtitle">Otomatis diperbarui setelah klik tombol Simpan Pengaturan.</p>
    </div>

    <div class="kh-branding-grid">
        {{-- Logo Utama --}}
        <div class="kh-branding-card">
            <div class="kh-branding-card-top">
                <span class="kh-branding-label">Logo Utama</span>
                <span class="{{ $hasCustomLogo ? 'kh-badge-custom' : 'kh-badge-default' }}">
                    {{ $hasCustomLogo ? 'Custom' : 'Default' }}
                </span>
            </div>
            <div class="kh-asset-box">
                <img src="{{ $logoUrl }}" alt="Logo Utama Aktif" style="max-height: 4rem; max-width: 100%; object-fit: contain;">
            </div>
        </div>

        {{-- Favicon --}}
        <div class="kh-branding-card">
            <div class="kh-branding-card-top">
                <span class="kh-branding-label">Favicon Browser</span>
                <span class="{{ $hasCustomFavicon ? 'kh-badge-custom' : 'kh-badge-default' }}">
                    {{ $hasCustomFavicon ? 'Custom' : 'Default' }}
                </span>
            </div>
            <div class="kh-asset-box">
                <div class="kh-tab-pill">
                    <img src="{{ $faviconUrl }}" alt="Favicon Aktif" style="width: 1.25rem; height: 1.25rem; object-fit: contain; flex-shrink: 0;">
                    <span style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $storeName }}</span>
                </div>
            </div>
        </div>

        {{-- Background Hero --}}
        <div class="kh-branding-card kh-branding-hero-col">
            <div class="kh-branding-card-top">
                <span class="kh-branding-label">Background Hero Halaman Utama</span>
                <span class="{{ $hasCustomHero ? 'kh-badge-custom' : 'kh-badge-default' }}">
                    {{ $hasCustomHero ? 'Custom Gambar' : 'Gradient Default' }}
                </span>
            </div>
            <div class="kh-hero-box">
                @if ($heroBgUrl)
                    <img src="{{ $heroBgUrl }}" alt="Background Hero Aktif" class="kh-hero-img">
                    <div class="kh-hero-overlay"></div>
                @endif
                <div class="kh-hero-text">
                    <div style="font-size: 0.6875rem; color: #fbbf24; font-weight: 600;">{{ $storeName }}</div>
                    <div style="font-size: 0.875rem; font-weight: 700;">Build Your PC. <span style="color: #fbbf24;">Your Way.</span></div>
                </div>
            </div>
        </div>
    </div>
</div>
