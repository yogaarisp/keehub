@php
    $user = auth()->user();
    $name = $user?->name ?? 'Admin KeeHub';
    $role = $user?->role ?? 'staff';
    $roleLabel = match($role) {
        'owner' => 'Owner',
        'staff' => 'Staff',
        default => 'Admin',
    };
    $initials = collect(explode(' ', $name))
        ->filter()
        ->map(fn($part) => strtoupper(substr($part, 0, 1)))
        ->take(2)
        ->join('');
    if (empty($initials)) {
        $initials = 'KH';
    }
@endphp

<div class="fi-sidebar-custom-footer">
    {{-- Expanded Mode --}}
    <div
        x-data="{}"
        @if (filament()->isSidebarCollapsibleOnDesktop())
            x-show="$store.sidebar.isOpen"
            x-transition:enter="transition ease-out duration-150 delay-75"
            x-transition:enter-start="opacity-0 -translate-x-1"
            x-transition:enter-end="opacity-100 translate-x-0"
        @endif
        class="fi-footer-expanded"
    >
        <div class="fi-footer-user-info">
            {{-- Avatar with Online Indicator --}}
            <div style="position: relative; flex-shrink: 0;">
                <div class="fi-user-avatar">
                    {{ $initials }}
                </div>
                <span class="fi-online-badge" title="Online"></span>
            </div>

            {{-- User Details --}}
            <div class="fi-footer-meta">
                <span class="fi-footer-name">{{ $name }}</span>
                <div class="fi-footer-sub">
                    <span class="fi-user-role-badge">{{ $roleLabel }}</span>
                    <span class="fi-footer-status">Online</span>
                </div>
            </div>
        </div>

        {{-- Quick Link to Website --}}
        <a
            href="{{ url('/') }}"
            target="_blank"
            rel="noopener noreferrer"
            title="Buka Website Toko"
            class="fi-footer-store-btn"
        >
            <x-filament::icon
                icon="heroicon-o-arrow-top-right-on-square"
                style="width: 1rem; height: 1rem;"
            />
        </a>
    </div>

    {{-- Collapsed Mode --}}
    @if (filament()->isSidebarCollapsibleOnDesktop())
        <div
            x-data="{}"
            x-show="! $store.sidebar.isOpen"
            x-cloak
            x-transition:enter="transition ease-out duration-150 delay-75"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            class="fi-footer-collapsed"
        >
            <div
                class="fi-collapsed-avatar-wrap"
                title="{{ $name }} ({{ $roleLabel }})"
            >
                <div class="fi-user-avatar">
                    {{ $initials }}
                </div>
                <span class="fi-online-badge"></span>
            </div>
        </div>
    @endif
</div>
