@php
    $isProducts = request()->is('admin/products*');
    $isOrders = request()->is('admin/orders*');
    $isServices = request()->is('admin/services*');
    $isUsers = request()->is('admin/users*');
@endphp

<nav x-data="{}" class="fi-mobile-bottom-nav">
    <div class="fi-bottom-nav-grid">
        {{-- 1. Hamburger Menu (Toggles Sidebar) --}}
        <button
            type="button"
            x-on:click="$store.sidebar.isOpen ? $store.sidebar.close() : $store.sidebar.open()"
            class="fi-bottom-nav-item"
            x-bind:class="{ 'active': $store.sidebar.isOpen }"
            aria-label="Buka Menu"
        >
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
            <span>Menu</span>
        </button>

        {{-- 2. Produk --}}
        <a
            href="{{ url('/admin/products') }}"
            class="fi-bottom-nav-item {{ $isProducts ? 'active' : '' }}"
        >
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="{{ $isProducts ? '2.25' : '2' }}">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
            </svg>
            <span>Produk</span>
        </a>

        {{-- 3. Pesanan (Elevated Center Button) --}}
        <a
            href="{{ url('/admin/orders') }}"
            class="fi-bottom-nav-center {{ $isOrders ? 'active' : '' }}"
        >
            <div class="fi-bottom-nav-center-btn">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                </svg>
            </div>
            <span>Pesanan</span>
        </a>

        {{-- 4. Service --}}
        <a
            href="{{ url('/admin/services') }}"
            class="fi-bottom-nav-item {{ $isServices ? 'active' : '' }}"
        >
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="{{ $isServices ? '2.25' : '2' }}">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085" />
            </svg>
            <span>Service</span>
        </a>

        {{-- 5. Akun --}}
        <a
            href="{{ url('/admin/users') }}"
            class="fi-bottom-nav-item {{ $isUsers ? 'active' : '' }}"
        >
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="{{ $isUsers ? '2.25' : '2' }}">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
            </svg>
            <span>Akun</span>
        </a>
    </div>
</nav>
