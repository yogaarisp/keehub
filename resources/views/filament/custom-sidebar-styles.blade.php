<style>
    /* ========================================================
       KEEHUB MODERN & MINIMALIST SIDEBAR REDESIGN
       ======================================================== */

    /* Typography & Base */
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

    .fi-sidebar,
    .fi-sidebar * {
        font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif !important;
    }

    /* Sidebar Shell & Backdrop */
    aside.fi-sidebar {
        border-right: 1px solid rgba(226, 232, 240, 0.8) !important;
        background-color: #ffffff !important;
        box-shadow: none !important;
        transition: width 0.25s cubic-bezier(0.4, 0, 0.2, 1), transform 0.25s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }

    .dark aside.fi-sidebar {
        border-right: 1px solid rgba(255, 255, 255, 0.06) !important;
        background-color: #0b0f19 !important;
    }

    /* Sidebar Header (Clean & Minimalist) */
    .fi-sidebar-header {
        height: 4.25rem !important;
        padding-left: 1rem !important;
        padding-right: 0.85rem !important;
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        border-bottom: 1px solid rgba(226, 232, 240, 0.7) !important;
        background-color: #ffffff !important;
        box-shadow: none !important;
    }

    .dark .fi-sidebar-header {
        border-bottom: 1px solid rgba(255, 255, 255, 0.06) !important;
        background-color: #0b0f19 !important;
    }
    .fi-sidebar-header > div:first-child {
        min-width: 0 !important;
        flex: 1 1 auto !important;
        align-items: center !important;
    }

    @media (min-width: 1024px) {
        .fi-sidebar.fi-sidebar-open .fi-sidebar-header > div:first-child {
            display: flex !important;
        }

        aside.fi-sidebar:not(.fi-sidebar-open) .fi-sidebar-header > div:first-child {
            display: none !important;
        }
    }

    /* Brand Logo & Title Area */
    .fi-sidebar-header .fi-logo {
        display: flex !important;
        align-items: center !important;
        min-width: 0 !important;
        text-decoration: none !important;
    }

    /* Alpine Cloak - Prevent pre-render flash of hidden elements */
    [x-cloak] {
        display: none !important;
    }

    /* Minimalist Collapse / Expand Toggle Button */
    .fi-sidebar-header button.fi-icon-btn,
    .fi-sidebar-header .fi-icon-btn {
        flex-shrink: 0 !important;
        width: 1.75rem !important;
        height: 1.75rem !important;
        border-radius: 0.375rem !important;
        border: none !important;
        background-color: transparent !important;
        color: #94a3b8 !important;
        transition: all 0.15s ease !important;
        box-shadow: none !important;
    }

    .fi-sidebar-header button.fi-icon-btn:hover,
    .fi-sidebar-header .fi-icon-btn:hover {
        background-color: rgba(241, 245, 249, 0.9) !important;
        color: #0f172a !important;
    }

    .dark .fi-sidebar-header button.fi-icon-btn,
    .dark .fi-sidebar-header .fi-icon-btn {
        color: #64748b !important;
        background-color: transparent !important;
    }

    .dark .fi-sidebar-header button.fi-icon-btn:hover,
    .dark .fi-sidebar-header .fi-icon-btn:hover {
        background-color: rgba(255, 255, 255, 0.08) !important;
        color: #f8fafc !important;
    }

    .fi-sidebar-header .fi-icon-btn svg {
        width: 1.05rem !important;
        height: 1.05rem !important;
    }

    /* Sidebar Nav Container */
    .fi-sidebar-nav {
        padding: 1rem 0.85rem !important;
        scrollbar-width: thin;
        scrollbar-color: rgba(148, 163, 184, 0.2) transparent;
    }

    .fi-sidebar-nav::-webkit-scrollbar {
        width: 4px;
    }

    .fi-sidebar-nav::-webkit-scrollbar-track {
        background: transparent;
    }

    .fi-sidebar-nav::-webkit-scrollbar-thumb {
        background: rgba(148, 163, 184, 0.2);
        border-radius: 9999px;
    }

    .fi-sidebar-nav::-webkit-scrollbar-thumb:hover {
        background: rgba(148, 163, 184, 0.4);
    }

    /* Navigation Groups */
    .fi-sidebar-nav-groups {
        row-gap: 1.25rem !important;
    }

    .fi-sidebar-group {
        row-gap: 0.25rem !important;
    }

    /* Group Label (Minimalist Micro-Header) */
    .fi-sidebar-group-button {
        padding: 0.35rem 0.5rem 0.25rem 0.65rem !important;
        border-radius: 0.5rem !important;
        transition: background-color 0.15s ease !important;
    }

    .fi-sidebar-group-label {
        font-size: 0.6875rem !important;
        font-weight: 700 !important;
        letter-spacing: 0.08em !important;
        text-transform: uppercase !important;
        color: #94a3b8 !important;
    }

    .dark .fi-sidebar-group-label {
        color: #64748b !important;
    }

    /* Group Collapse Icon */
    .fi-sidebar-group-button button {
        opacity: 0.5;
        transition: opacity 0.15s ease, transform 0.15s ease !important;
    }

    .fi-sidebar-group-button:hover button {
        opacity: 1;
    }

    /* Navigation Items */
    .fi-sidebar-item {
        position: relative !important;
        margin-bottom: 2px !important;
    }

    .fi-sidebar-item-button {
        position: relative !important;
        border-radius: 0.65rem !important;
        padding: 0.55rem 0.75rem !important;
        font-size: 0.84rem !important;
        font-weight: 500 !important;
        color: #475569 !important;
        background: transparent !important;
        transition: all 0.15s cubic-bezier(0.4, 0, 0.2, 1) !important;
        overflow: hidden;
    }

    .dark .fi-sidebar-item-button {
        color: #94a3b8 !important;
        background: transparent !important;
    }

    /* Inactive Hover */
    .fi-sidebar-item-button:hover {
        color: #0f172a !important;
        background: rgba(241, 245, 249, 0.85) !important;
        transform: translateX(3px) !important;
    }

    .dark .fi-sidebar-item-button:hover {
        color: #f8fafc !important;
        background: rgba(255, 255, 255, 0.05) !important;
        transform: translateX(3px) !important;
    }

    /* Active State (Sleek Minimal Accent Pill) */
    .fi-sidebar-item.fi-active > .fi-sidebar-item-button,
    .fi-sidebar-item-active > .fi-sidebar-item-button {
        background: linear-gradient(135deg, rgba(254, 243, 199, 0.65) 0%, rgba(254, 243, 199, 0.3) 100%) !important;
        color: #b45309 !important;
        font-weight: 600 !important;
        border: 1px solid rgba(245, 158, 11, 0.22) !important;
        box-shadow: 0 1px 3px rgba(245, 158, 11, 0.08) !important;
        transform: none !important;
    }

    .dark .fi-sidebar-item.fi-active > .fi-sidebar-item-button,
    .dark .fi-sidebar-item-active > .fi-sidebar-item-button {
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.15) 0%, rgba(245, 158, 11, 0.05) 100%) !important;
        color: #fbbf24 !important;
        font-weight: 600 !important;
        border: 1px solid rgba(245, 158, 11, 0.25) !important;
        box-shadow: 0 0 16px rgba(245, 158, 11, 0.08) !important;
        transform: none !important;
    }

    /* Left Indicator Bar for Active Item */
    .fi-sidebar-item.fi-active > .fi-sidebar-item-button::before,
    .fi-sidebar-item-active > .fi-sidebar-item-button::before {
        content: '';
        position: absolute;
        left: 0;
        top: 22%;
        bottom: 22%;
        width: 3.5px;
        border-radius: 0 4px 4px 0;
        background: #f59e0b;
        box-shadow: 0 0 8px rgba(245, 158, 11, 0.5);
    }

    /* Item Icons */
    .fi-sidebar-item-icon {
        width: 1.25rem !important;
        height: 1.25rem !important;
        color: #94a3b8 !important;
        transition: transform 0.15s ease, color 0.15s ease !important;
    }

    .dark .fi-sidebar-item-icon {
        color: #64748b !important;
    }

    .fi-sidebar-item-button:hover .fi-sidebar-item-icon {
        color: #d97706 !important;
        transform: scale(1.1) !important;
    }

    .dark .fi-sidebar-item-button:hover .fi-sidebar-item-icon {
        color: #fbbf24 !important;
        transform: scale(1.1) !important;
    }

    .fi-sidebar-item.fi-active .fi-sidebar-item-icon,
    .fi-sidebar-item-active .fi-sidebar-item-icon {
        color: #d97706 !important;
    }

    .dark .fi-sidebar-item.fi-active .fi-sidebar-item-icon,
    .dark .fi-sidebar-item-active .fi-sidebar-item-icon {
        color: #fbbf24 !important;
    }

    /* Badges */
    .fi-sidebar-item .fi-badge {
        border-radius: 9999px !important;
        font-size: 0.6875rem !important;
        font-weight: 600 !important;
        padding: 0.1rem 0.5rem !important;
        box-shadow: none !important;
    }

    /* ========================================================
       COLLAPSED (MINIMIZED) SIDEBAR MODE - SLEEK DOCK STYLE (DESKTOP >= 1024px)
       ======================================================== */
    @media (min-width: 1024px) {
        aside.fi-sidebar:not(.fi-sidebar-open) {
            width: 4.5rem !important;
            overflow-x: hidden !important;
        }

        /* Collapsed Header */
        aside.fi-sidebar:not(.fi-sidebar-open) .fi-sidebar-header {
            padding-left: 0 !important;
            padding-right: 0 !important;
            justify-content: center !important;
            align-items: center !important;
            width: 100% !important;
        }

        aside.fi-sidebar:not(.fi-sidebar-open) .fi-sidebar-header button.ms-auto,
        aside.fi-sidebar:not(.fi-sidebar-open) .fi-sidebar-header .fi-icon-btn.ms-auto {
            display: none !important;
        }

        aside.fi-sidebar.fi-sidebar-open .fi-sidebar-header button.mx-auto,
        aside.fi-sidebar.fi-sidebar-open .fi-sidebar-header .fi-icon-btn.mx-auto {
            display: none !important;
        }

        aside.fi-sidebar:not(.fi-sidebar-open) .fi-sidebar-header button.mx-auto,
        aside.fi-sidebar:not(.fi-sidebar-open) .fi-sidebar-header .fi-icon-btn.mx-auto {
            margin: 0 auto !important;
            width: 2.15rem !important;
            height: 2.15rem !important;
            border-radius: 0.5rem !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            background-color: #f8fafc !important;
            border: 1px solid rgba(226, 232, 240, 0.8) !important;
            color: #64748b !important;
            transition: all 0.15s ease !important;
        }

        .dark aside.fi-sidebar:not(.fi-sidebar-open) .fi-sidebar-header button.mx-auto,
        .dark aside.fi-sidebar:not(.fi-sidebar-open) .fi-sidebar-header .fi-icon-btn.mx-auto {
            background-color: rgba(255, 255, 255, 0.05) !important;
            border-color: rgba(255, 255, 255, 0.08) !important;
            color: #94a3b8 !important;
        }

        aside.fi-sidebar:not(.fi-sidebar-open) .fi-sidebar-header button.mx-auto:hover,
        aside.fi-sidebar:not(.fi-sidebar-open) .fi-sidebar-header .fi-icon-btn.mx-auto:hover {
            background-color: #f1f5f9 !important;
            color: #0f172a !important;
            transform: scale(1.08) !important;
        }

        .dark aside.fi-sidebar:not(.fi-sidebar-open) .fi-sidebar-header button.mx-auto:hover,
        .dark aside.fi-sidebar:not(.fi-sidebar-open) .fi-sidebar-header .fi-icon-btn.mx-auto:hover {
            background-color: rgba(255, 255, 255, 0.1) !important;
            color: #ffffff !important;
        }

        /* Collapsed Nav Container */
        aside.fi-sidebar:not(.fi-sidebar-open) .fi-sidebar-nav {
            padding: 0.85rem 0.35rem !important;
            overflow-x: hidden !important;
            align-items: center !important;
        }

        aside.fi-sidebar:not(.fi-sidebar-open) .fi-sidebar-nav-groups {
            row-gap: 0.65rem !important;
            width: 100% !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
        }

        aside.fi-sidebar:not(.fi-sidebar-open) .fi-sidebar-group {
            width: 100% !important;
            row-gap: 0.35rem !important;
        }

        aside.fi-sidebar:not(.fi-sidebar-open) .fi-sidebar-group-button {
            display: none !important;
        }

        /* Collapsed Items: Perfect Centered Squares */
        aside.fi-sidebar:not(.fi-sidebar-open) .fi-sidebar-item {
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            width: 100% !important;
            margin-bottom: 0.25rem !important;
        }

        aside.fi-sidebar:not(.fi-sidebar-open) .fi-sidebar-item-button {
            width: 2.65rem !important;
            height: 2.65rem !important;
            padding: 0 !important;
            margin: 0 auto !important;
            border-radius: 0.65rem !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            transform: none !important;
            border: 1px solid transparent !important;
            box-shadow: none !important;
        }

        aside.fi-sidebar:not(.fi-sidebar-open) .fi-sidebar-item-button:hover {
            transform: scale(1.08) !important;
            background-color: rgba(241, 245, 249, 1) !important;
            color: #0f172a !important;
        }

        .dark aside.fi-sidebar:not(.fi-sidebar-open) .fi-sidebar-item-button:hover {
            background-color: rgba(255, 255, 255, 0.08) !important;
            color: #f8fafc !important;
        }

        /* Collapsed Active Item (Centered Glowing Tile) */
        aside.fi-sidebar:not(.fi-sidebar-open) .fi-sidebar-item.fi-active > .fi-sidebar-item-button,
        aside.fi-sidebar:not(.fi-sidebar-open) .fi-sidebar-item-active > .fi-sidebar-item-button {
            background: linear-gradient(135deg, rgba(254, 243, 199, 0.75) 0%, rgba(254, 243, 199, 0.4) 100%) !important;
            border: 1px solid rgba(245, 158, 11, 0.35) !important;
            box-shadow: 0 2px 6px rgba(245, 158, 11, 0.15) !important;
            color: #b45309 !important;
            transform: none !important;
        }

        .dark aside.fi-sidebar:not(.fi-sidebar-open) .fi-sidebar-item.fi-active > .fi-sidebar-item-button,
        .dark aside.fi-sidebar:not(.fi-sidebar-open) .fi-sidebar-item-active > .fi-sidebar-item-button {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.22) 0%, rgba(245, 158, 11, 0.08) 100%) !important;
            border: 1px solid rgba(245, 158, 11, 0.35) !important;
            box-shadow: 0 0 14px rgba(245, 158, 11, 0.15) !important;
            color: #fbbf24 !important;
        }

        /* Disable side indicator bar when collapsed */
        aside.fi-sidebar:not(.fi-sidebar-open) .fi-sidebar-item.fi-active > .fi-sidebar-item-button::before,
        aside.fi-sidebar:not(.fi-sidebar-open) .fi-sidebar-item-active > .fi-sidebar-item-button::before {
            display: none !important;
        }

        aside.fi-sidebar:not(.fi-sidebar-open) .fi-sidebar-item-icon {
            width: 1.35rem !important;
            height: 1.35rem !important;
            margin: 0 !important;
        }

        /* Hide text & badges completely in collapsed items */
        aside.fi-sidebar:not(.fi-sidebar-open) .fi-sidebar-item-label,
        aside.fi-sidebar:not(.fi-sidebar-open) .fi-badge {
            display: none !important;
        }

        /* Collapsed Footer */
        aside.fi-sidebar:not(.fi-sidebar-open) .fi-sidebar-custom-footer {
            padding: 0.75rem 0 !important;
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            width: 100% !important;
        }

        aside.fi-sidebar.fi-sidebar-open .fi-footer-collapsed {
            display: none !important;
        }

        aside.fi-sidebar:not(.fi-sidebar-open) .fi-footer-expanded {
            display: none !important;
        }

        aside.fi-sidebar:not(.fi-sidebar-open) .fi-footer-collapsed {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 100% !important;
        }

        .fi-collapsed-avatar-wrap {
            position: relative !important;
            width: 2.35rem !important;
            height: 2.35rem !important;
            flex-shrink: 0 !important;
            cursor: pointer !important;
            transition: transform 0.15s ease !important;
        }

        .fi-collapsed-avatar-wrap:hover {
            transform: scale(1.08) !important;
        }

        .fi-collapsed-avatar-wrap .fi-user-avatar {
            width: 2.35rem !important;
            height: 2.35rem !important;
            border-radius: 0.6rem !important;
        }

        .fi-collapsed-avatar-wrap .fi-online-badge {
            position: absolute !important;
            bottom: -1px !important;
            right: -1px !important;
        }
    }

    /* ========================================================
       MOBILE SIDEBAR DRAWER & RESPONSIVE LAYOUT (< 1024px)
       ======================================================== */
    @media (max-width: 1023px) {
        /* Mobile Sidebar Drawer */
        aside.fi-sidebar {
            width: min(18.5rem, 85vw) !important;
            max-width: 18.5rem !important;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3), 0 8px 10px -6px rgba(0, 0, 0, 0.3) !important;
            z-index: 50 !important;
        }

        /* Ensure header shows logo, brand name, and mobile close button */
        aside.fi-sidebar .fi-sidebar-header {
            padding-left: 1.25rem !important;
            padding-right: 1rem !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            width: 100% !important;
        }

        aside.fi-sidebar .fi-sidebar-header > div:first-child {
            display: flex !important;
            align-items: center !important;
            min-width: 0 !important;
            flex: 1 1 auto !important;
        }

        /* Mobile Header and Logo Container */
        aside.fi-sidebar .fi-sidebar-header > div:first-child {
            width: 100% !important;
            flex: 1 1 100% !important;
            display: flex !important;
        }

        aside.fi-sidebar .fi-sidebar-header .fi-logo {
            width: 100% !important;
            display: flex !important;
        }

        /* Hide Filament's default collapse/expand buttons on mobile header in favor of dedicated close button */
        aside.fi-sidebar .fi-sidebar-header > button.fi-icon-btn,
        aside.fi-sidebar .fi-sidebar-header > button.mx-auto,
        aside.fi-sidebar .fi-sidebar-header > button.ms-auto {
            display: none !important;
        }

        /* Navigation in Mobile Drawer */
        aside.fi-sidebar .fi-sidebar-nav {
            padding: 1rem 0.85rem !important;
        }

        aside.fi-sidebar .fi-sidebar-group-button {
            display: flex !important;
        }

        aside.fi-sidebar .fi-sidebar-item {
            display: block !important;
            width: 100% !important;
        }

        aside.fi-sidebar .fi-sidebar-item-button {
            width: 100% !important;
            height: auto !important;
            padding: 0.625rem 0.85rem !important;
            display: flex !important;
            align-items: center !important;
            justify-content: flex-start !important;
            gap: 0.75rem !important;
            border-radius: 0.65rem !important;
        }

        aside.fi-sidebar .fi-sidebar-item-label {
            display: inline-block !important;
            font-size: 0.85rem !important;
            font-weight: 500 !important;
        }

        aside.fi-sidebar .fi-badge {
            display: inline-flex !important;
            margin-left: auto !important;
        }

        /* Full footer on mobile */
        aside.fi-sidebar .fi-footer-expanded {
            display: flex !important;
        }

        aside.fi-sidebar .fi-footer-collapsed {
            display: none !important;
        }

        /* Dimmed Backdrop Overlay with Smooth Blur */
        .fi-sidebar-close-overlay {
            background-color: rgba(15, 23, 42, 0.65) !important;
            backdrop-filter: blur(4px) !important;
            -webkit-backdrop-filter: blur(4px) !important;
            z-index: 40 !important;
        }

        /* Mobile Topbar Adjustments */
        .fi-topbar > nav {
            height: 3.75rem !important;
            padding-left: 0.75rem !important;
            padding-right: 0.75rem !important;
            gap: 0.5rem !important;
        }

        /* Hide Topbar Hamburger Button on Mobile (Replaced by Bottom Navigation 'Menu' Button) */
        button.fi-topbar-open-sidebar-btn {
            display: none !important;
        }

        /* Mobile Main Content Area Padding (Leaves space for fixed bottom navigation bar) */
        .fi-main {
            padding-left: 0.85rem !important;
            padding-right: 0.85rem !important;
            padding-top: 1rem !important;
            padding-bottom: 5.5rem !important;
        }

        /* Ensure Tables Scroll Horizontally without Breaking Layout */
        .fi-ta-content {
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch !important;
        }
    }


    /* ========================================================
       SIDEBAR FOOTER CARD STYLES
       ======================================================== */
    .fi-sidebar-custom-footer {
        border-top: 1px solid rgba(226, 232, 240, 0.8) !important;
        background-color: #fafbfc !important;
        padding: 0.75rem 0.85rem !important;
        width: 100% !important;
        box-sizing: border-box !important;
    }

    .dark .fi-sidebar-custom-footer {
        border-top: 1px solid rgba(255, 255, 255, 0.06) !important;
        background-color: #0d121f !important;
    }

    .fi-footer-expanded {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.65rem;
        width: 100%;
    }

    .fi-footer-user-info {
        display: flex;
        align-items: center;
        gap: 0.65rem;
        min-width: 0;
        flex: 1;
    }

    .fi-user-avatar {
        width: 2.15rem;
        height: 2.15rem;
        border-radius: 0.55rem;
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: #ffffff;
        font-weight: 700;
        font-size: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 6px rgba(245, 158, 11, 0.25);
        flex-shrink: 0;
    }

    .fi-online-badge {
        position: absolute;
        bottom: -2px;
        right: -2px;
        width: 0.625rem;
        height: 0.625rem;
        background-color: #10b981;
        border: 2px solid #ffffff;
        border-radius: 9999px;
    }

    .dark .fi-online-badge {
        border-color: #0b0f19;
    }

    .fi-footer-meta {
        min-width: 0;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .fi-footer-name {
        font-size: 0.8rem;
        font-weight: 600;
        color: #1e293b;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        line-height: 1.2;
    }

    .dark .fi-footer-name {
        color: #f1f5f9;
    }

    .fi-footer-sub {
        display: flex;
        align-items: center;
        gap: 0.35rem;
        margin-top: 0.15rem;
    }

    .fi-user-role-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.05rem 0.35rem;
        border-radius: 0.25rem;
        font-size: 0.625rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.025em;
        background-color: rgba(245, 158, 11, 0.12);
        color: #b45309;
        border: 1px solid rgba(245, 158, 11, 0.2);
    }

    .dark .fi-user-role-badge {
        color: #fbbf24;
        background-color: rgba(245, 158, 11, 0.15);
        border-color: rgba(245, 158, 11, 0.25);
    }

    .fi-footer-status {
        font-size: 0.625rem;
        color: #94a3b8;
    }

    .dark .fi-footer-status {
        color: #64748b;
    }

    .fi-footer-store-btn {
        width: 1.85rem;
        height: 1.85rem;
        border-radius: 0.45rem;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
        background-color: transparent;
        transition: all 0.15s ease;
        flex-shrink: 0;
    }

    .fi-footer-store-btn:hover {
        color: #d97706;
        background-color: rgba(241, 245, 249, 1);
        transform: scale(1.05);
    }

    .dark .fi-footer-store-btn:hover {
        color: #fbbf24;
        background-color: rgba(255, 255, 255, 0.08);
    }

    /* ========================================================
       TOPBAR / HEADER MODERN & MINIMALIST REDESIGN
       ======================================================== */
    .fi-topbar {
        position: sticky !important;
        top: 0 !important;
        z-index: 20 !important;
        backdrop-filter: blur(12px) !important;
        -webkit-backdrop-filter: blur(12px) !important;
    }

    .fi-topbar > nav {
        height: 4.25rem !important;
        background-color: rgba(255, 255, 255, 0.9) !important;
        border-bottom: 1px solid rgba(226, 232, 240, 0.8) !important;
        box-shadow: none !important;
        padding-left: 1.25rem !important;
        padding-right: 1.25rem !important;
        transition: background-color 0.2s ease, border-color 0.2s ease !important;
    }

    .dark .fi-topbar > nav {
        background-color: rgba(11, 15, 25, 0.9) !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.06) !important;
    }

    /* Theme Switcher in Topbar */
    .fi-theme-switcher {
        background-color: rgba(241, 245, 249, 0.85) !important;
        border: 1px solid rgba(226, 232, 240, 0.9) !important;
        border-radius: 0.6rem !important;
        padding: 0.15rem !important;
        gap: 0.1rem !important;
    }

    .dark .fi-theme-switcher {
        background-color: rgba(15, 23, 42, 0.8) !important;
        border-color: rgba(255, 255, 255, 0.08) !important;
    }

    .fi-theme-switcher-btn {
        border-radius: 0.45rem !important;
        padding: 0.25rem 0.35rem !important;
        transition: all 0.15s ease !important;
    }

    .fi-theme-switcher-btn svg {
        width: 0.95rem !important;
        height: 0.95rem !important;
    }

    /* Quick Add Button */
    .fi-quick-add-btn {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
        box-shadow: 0 2px 6px rgba(245, 158, 11, 0.25) !important;
    }

    .fi-quick-add-btn:hover {
        transform: translateY(-1px) !important;
        box-shadow: 0 4px 10px rgba(245, 158, 11, 0.35) !important;
    }

    /* User Menu Button */
    .fi-user-menu button {
        border-radius: 0.65rem !important;
        padding: 0.2rem !important;
        transition: all 0.15s ease !important;
    }

    .fi-user-menu button:hover {
        background-color: rgba(241, 245, 249, 0.9) !important;
    }

    .dark .fi-user-menu button:hover {
        background-color: rgba(255, 255, 255, 0.08) !important;
    }

    .fi-user-menu img,
    .fi-user-menu .fi-avatar {
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;
        border-radius: 0.55rem !important;
    }

    /* ========================================================
       MOBILE ADMIN CONTENT OPTIMIZATION (< 1024px)
       Dashboard widgets, tables, forms, infolists, repeater
       ======================================================== */

    /* ---- Force 1-column grids on mobile for form/infolist/repeater ---- */
    /* Filament uses --cols-default CSS var for non-responsive column count.
       Override to 1 col when no responsive --cols-sm breakpoint is set. */
    @media (max-width: 639px) {
        [style*="--cols-default"]:not([style*="--cols-sm"]) {
            --cols-default: repeat(1, minmax(0, 1fr)) !important;
        }
        [style*="--cols-default"]:not([style*="--cols-sm"]) > div[style*="--col-span-default"] {
            grid-column: 1 / -1 !important;
        }
    }

    /* At sm (640px+), cap at 2 columns for sections that had 3+ */
    @media (min-width: 640px) and (max-width: 767px) {
        [style*="--cols-default"]:not([style*="--cols-sm"]):not([style*="--cols-md"]) {
            --cols-default: repeat(2, minmax(0, 1fr)) !important;
        }
    }

    @media (max-width: 1023px) {
        /* ---- Dashboard: Stats overview 2-col compact on mobile ---- */
        .fi-wi-stats-overview-stats-ctn {
            grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
            gap: 0.65rem !important;
        }

        /* Stats card: compact */
        .fi-wi-stats-overview-stat {
            padding: 0.75rem !important;
        }
        .fi-wi-stats-overview-stat-label,
        .fi-wi-stats-overview-stat-value {
            font-size: 0.85rem !important;
        }

        /* Dashboard widgets: tighter gap */
        .fi-wi {
            gap: 0.75rem !important;
        }

        /* Dashboard table widget: compact heading */
        .fi-wi-table-widget-heading {
            font-size: 0.875rem !important;
        }

        /* ---- Page header: compact ---- */
        .fi-header-heading {
            font-size: 1.25rem !important;
            line-height: 1.3 !important;
        }

        .fi-header-subheading {
            font-size: 0.85rem !important;
            margin-top: 0.35rem !important;
        }

        /* Page header actions: wrap on mobile */
        .fi-header > div:last-child {
            flex-wrap: wrap !important;
        }

        /* ---- Page section: compact spacing ---- */
        .fi-page > section {
            padding-top: 1rem !important;
            padding-bottom: 2rem !important;
            gap: 1.25rem !important;
        }

        /* ---- Form sections: compact padding ---- */
        .fi-section-content {
            padding: 0.85rem !important;
        }

        /* Form field labels: slightly smaller */
        .fi-component-label,
        .fi-form-field-label,
        .fi-form-field-label-text {
            font-size: 0.8rem !important;
        }

        /* ---- Infolist sections: compact padding ---- */
        .fi-infolist-section-content {
            padding: 0.85rem !important;
        }

        /* Infolist entry label: smaller */
        .fi-infolist-entry-label {
            font-size: 0.75rem !important;
        }

        /* ---- Repeater items: compact mobile card ---- */
        .fi-fo-repeater-item,
        .fi-repeater-item {
            border-radius: 0.85rem !important;
            border: 1px solid rgba(226, 232, 240, 0.95) !important;
            background-color: #ffffff !important;
            margin-bottom: 0.75rem !important;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04) !important;
            overflow: hidden !important;
        }

        .dark .fi-fo-repeater-item,
        .dark .fi-repeater-item {
            background-color: rgba(15, 23, 42, 0.6) !important;
            border-color: rgba(255, 255, 255, 0.08) !important;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3) !important;
        }

        .fi-fo-repeater-item-header,
        .fi-repeater-item-header {
            padding: 0.45rem 0.75rem !important;
            background-color: #f8fafc !important;
            border-bottom: 1px solid rgba(226, 232, 240, 0.8) !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            min-height: 2.5rem !important;
        }

        .dark .fi-fo-repeater-item-header,
        .dark .fi-repeater-item-header {
            background-color: rgba(30, 41, 59, 0.6) !important;
            border-bottom-color: rgba(255, 255, 255, 0.06) !important;
        }

        .fi-fo-repeater-item-header h4,
        .fi-repeater-item-header h4 {
            font-size: 0.825rem !important;
            font-weight: 600 !important;
            color: #1e293b !important;
            max-width: calc(100vw - 11rem) !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
            white-space: nowrap !important;
        }

        .dark .fi-fo-repeater-item-header h4,
        .dark .fi-repeater-item-header h4 {
            color: #f1f5f9 !important;
        }

        .fi-fo-repeater-item-header ul,
        .fi-repeater-item-header ul {
            gap: 0.25rem !important;
        }

        .fi-fo-repeater-item-header .fi-icon-btn,
        .fi-repeater-item-header .fi-icon-btn {
            width: 1.85rem !important;
            height: 1.85rem !important;
            border-radius: 0.375rem !important;
        }

        /* Repeater mobile containers: prevent grid overflow */
        .fi-fo-repeater,
        .fi-fo-repeater-item,
        .fi-fo-repeater-item-content,
        .fi-fo-field-wrp,
        .fi-fo-field-wrp-label,
        .fi-input-wrp,
        .fi-input {
            min-width: 0 !important;
            max-width: 100% !important;
            box-sizing: border-box !important;
        }

        .fi-fo-repeater-item-content {
            padding: 0.75rem 0.85rem !important;
            width: 100% !important;
            overflow: hidden !important;
        }

        /* Tighten grid gap inside repeater items on mobile */
        .fi-fo-repeater-item-content .grid {
            width: 100% !important;
            max-width: 100% !important;
            min-width: 0 !important;
            gap: 0.55rem 0.5rem !important;
            row-gap: 0.55rem !important;
            column-gap: 0.5rem !important;
        }

        .fi-fo-repeater-item-content .grid > div {
            min-width: 0 !important;
            max-width: 100% !important;
        }

        .fi-fo-repeater-item-content .fi-fo-field-wrp {
            margin-bottom: 0 !important;
        }

        .fi-fo-repeater-item-content .fi-fo-field-wrp-label {
            margin-bottom: 0.2rem !important;
        }

        .fi-fo-repeater-item-content .fi-fo-field-wrp-label label {
            font-size: 0.75rem !important;
            font-weight: 600 !important;
            color: #475569 !important;
            white-space: nowrap !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
        }

        .dark .fi-fo-repeater-item-content .fi-fo-field-wrp-label label {
            color: #94a3b8 !important;
        }

        .fi-fo-repeater-item-content .fi-input-wrp {
            min-height: 2.35rem !important;
            border-radius: 0.5rem !important;
            width: 100% !important;
        }

        .fi-fo-repeater-item-content input,
        .fi-fo-repeater-item-content select {
            min-width: 0 !important;
            font-size: 0.85rem !important;
            padding-top: 0.35rem !important;
            padding-bottom: 0.35rem !important;
        }

        /* Currency prefix inside repeater */
        .fi-fo-repeater-item-content .fi-input-wrp-prefix {
            padding-left: 0.45rem !important;
            padding-right: 0.25rem !important;
            font-size: 0.78rem !important;
            font-weight: 600 !important;
            flex-shrink: 0 !important;
        }

        /* Remove browser number spinner in Qty */
        .fi-fo-repeater-item-content input[type="number"]::-webkit-inner-spin-button,
        .fi-fo-repeater-item-content input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none !important;
            margin: 0 !important;
        }
        .fi-fo-repeater-item-content input[type="number"] {
            -moz-appearance: textfield !important;
        }

        /* Repeater add button: full width */
        .fi-fo-repeater-add-action,
        .fi-repeater-add-action {
            width: 100% !important;
            margin-top: 0.35rem !important;
        }

        .fi-fo-repeater-add-action button,
        .fi-repeater-add-action button {
            width: 100% !important;
            justify-content: center !important;
            min-height: 2.5rem !important;
            font-size: 0.825rem !important;
            font-weight: 600 !important;
            border-radius: 0.65rem !important;
            background-color: #f1f5f9 !important;
            border: 1px dashed #cbd5e1 !important;
            color: #2563eb !important;
            transition: all 0.15s ease !important;
        }

        .dark .fi-fo-repeater-add-action button,
        .dark .fi-repeater-add-action button {
            background-color: rgba(30, 41, 59, 0.4) !important;
            border-color: rgba(255, 255, 255, 0.15) !important;
            color: #60a5fa !important;
        }

        /* ---- Table: compact & scrollable ---- */
        .fi-ta-header {
            padding: 0.75rem !important;
            gap: 0.625rem !important;
        }

        /* Table header heading: compact */
        .fi-ta-header-heading {
            font-size: 0.875rem !important;
        }

        /* Table search: full width */
        .fi-ta-search-ctn {
            width: 100% !important;
        }

        /* Table cells: compact */
        .fi-ta-table td,
        .fi-ta-table th {
            padding-left: 0.65rem !important;
            padding-right: 0.65rem !important;
            padding-top: 0.45rem !important;
            padding-bottom: 0.45rem !important;
            font-size: 0.78rem !important;
        }

        /* Table header cells: prevent wrapping */
        .fi-ta-table th {
            white-space: nowrap !important;
        }

        /* Table pagination: compact, wrap, center */
        .fi-ta-pagination {
            padding: 0.5rem 0.75rem !important;
            flex-wrap: wrap !important;
            gap: 0.5rem !important;
            justify-content: center !important;
        }

        /* Table empty state: compact */
        .fi-ta-empty-state {
            padding: 1.5rem 1rem !important;
        }

        /* Table action icons: tappable but compact */
        .fi-ta-actions .fi-icon-btn {
            width: 2rem !important;
            height: 2rem !important;
            border-radius: 0.5rem !important;
        }

        /* Table cells: compact and vertical align */
        .fi-ta-table td {
            vertical-align: middle !important;
        }

        /* Table column description text (customer, date, subtitle) */
        .fi-ta-text-item-description {
            font-size: 0.72rem !important;
            line-height: 1.25 !important;
            margin-top: 2px !important;
            color: #64748b !important;
        }

        .dark .fi-ta-text-item-description {
            color: #94a3b8 !important;
        }

        /* Badges inside table: neat and compact */
        .fi-ta-table .fi-badge {
            padding: 0.2rem 0.5rem !important;
            font-size: 0.7rem !important;
            font-weight: 600 !important;
            letter-spacing: 0.02em !important;
        }

        /* ---- Action buttons: min touch target (44px) ---- */
        .fi-btn {
            min-height: 2.5rem !important;
        }

        /* ---- Form footer actions: sticky above mobile bottom navigation ---- */
        .fi-footer-actions {
            position: sticky !important;
            bottom: calc(4.25rem + env(safe-area-inset-bottom, 0px)) !important;
            background-color: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(12px) !important;
            -webkit-backdrop-filter: blur(12px) !important;
            padding: 0.75rem 0.85rem !important;
            margin: 0 -0.85rem !important;
            z-index: 25 !important;
            box-shadow: 0 -4px 14px rgba(0, 0, 0, 0.05) !important;
            border-top: 1px solid rgba(226, 232, 240, 0.8) !important;
        }

        .dark .fi-footer-actions {
            background-color: rgba(11, 15, 25, 0.95) !important;
            border-top: 1px solid rgba(255, 255, 255, 0.08) !important;
            box-shadow: 0 -4px 18px rgba(0, 0, 0, 0.35) !important;
        }

        .fi-footer-actions .fi-ac {
            width: 100% !important;
            display: flex !important;
            gap: 0.5rem !important;
        }

        .fi-footer-actions .fi-btn {
            flex: 1 1 auto !important;
            justify-content: center !important;
        }

        /* Ensure page body has room for sticky footer actions + bottom nav */
        .fi-page {
            padding-bottom: calc(7rem + env(safe-area-inset-bottom, 0px)) !important;
        }



        /* ---- Tabs (relation managers): horizontal scroll ---- */
        .fi-tabs {
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch !important;
            scrollbar-width: thin !important;
        }

        .fi-tabs-list {
            flex-wrap: nowrap !important;
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch !important;
        }

        /* ---- Reports page: table scroll ---- */
        .fi-page table {
            display: block !important;
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch !important;
        }

        /* ---- Notification: compact on mobile ---- */
        .fi-notification {
            max-width: calc(100vw - 2rem) !important;
        }

        /* ---- Breadcrumb: already hidden by Filament (hidden sm:block) ---- */

        /* ---- Form select/date inputs: prevent iOS zoom ---- */
        .fi-form-input,
        .fi-select,
        .fi-ta-search-input input {
            font-size: 16px !important;
        }

        /* ---- Manage Settings / custom pages: responsive ---- */
        .fi-page form .flex-wrap {
            gap: 0.75rem !important;
        }

        /* ========================================================
           MOBILE BOTTOM SHEET MODAL (Muncul dari bawah / Bottom Sheet)
           ======================================================== */
        .fi-modal-open .fixed.inset-0.z-40:not(.fi-modal-close-overlay) > div[x-ref="modalContainer"] {
            display: flex !important;
            flex-direction: column !important;
            justify-content: flex-end !important;
            align-items: stretch !important;
            min-height: 100% !important;
            height: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
            grid-template-rows: none !important;
        }

        /* Slide-over modal transforms to bottom sheet on mobile */
        .fi-modal-open .fi-modal-slide-over-window {
            margin: 0 !important;
            margin-top: auto !important;
            width: 100% !important;
            max-width: 100% !important;
            height: auto !important;
            min-height: 50vh !important;
            max-height: 88dvh !important;
            border-top-left-radius: 1.5rem !important;
            border-top-right-radius: 1.5rem !important;
            border-bottom-left-radius: 0 !important;
            border-bottom-right-radius: 0 !important;
            box-shadow: 0 -12px 40px rgba(0, 0, 0, 0.32) !important;
            border-top: 1px solid rgba(226, 232, 240, 0.9) !important;
            border-left: none !important;
            border-right: none !important;
            border-bottom: none !important;
            display: flex !important;
            flex-direction: column !important;
            overflow: hidden !important;
            transition: transform 0.32s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.25s ease !important;
        }

        .dark .fi-modal-open .fi-modal-slide-over-window {
            background-color: #0b0f19 !important;
            border-top: 1px solid rgba(255, 255, 255, 0.12) !important;
            box-shadow: 0 -16px 50px rgba(0, 0, 0, 0.7) !important;
        }

        /* Standard centered modals retain clean rounded card appearance on mobile */
        .fi-modal-open .fi-modal-window:not(.fi-modal-slide-over-window) {
            margin: auto 1rem !important;
            max-width: calc(100vw - 2rem) !important;
            border-radius: 1.25rem !important;
        }

        /* Alpine transition mapping: translate-x transforms to translateY for mobile bottom sheet */
        .fi-modal-open .fi-modal-slide-over-window.translate-x-full,
        .fi-modal-open .fi-modal-slide-over-window[class*="translate-x-full"] {
            transform: translateY(100%) !important;
        }

        .fi-modal-open .fi-modal-slide-over-window.translate-x-0,
        .fi-modal-open .fi-modal-slide-over-window[class*="translate-x-0"] {
            transform: translateY(0) !important;
        }

        /* Bottom Sheet Drag Handle Indicator */
        .fi-modal-slide-over-window::before {
            content: '' !important;
            display: block !important;
            width: 44px !important;
            height: 4px !important;
            background-color: #cbd5e1 !important;
            border-radius: 9999px !important;
            margin: 0.65rem auto 0.25rem auto !important;
            flex-shrink: 0 !important;
        }

        .dark .fi-modal-slide-over-window::before {
            background-color: #475569 !important;
        }

        /* Modal Header */
        .fi-modal-slide-over-window .fi-modal-header {
            padding: 0.35rem 1.25rem 0.65rem 1.25rem !important;
            border-bottom: 1px solid rgba(226, 232, 240, 0.8) !important;
            flex-shrink: 0 !important;
        }

        .dark .fi-modal-slide-over-window .fi-modal-header {
            border-bottom-color: rgba(255, 255, 255, 0.08) !important;
        }

        .fi-modal-slide-over-window .fi-modal-heading {
            font-size: 1.1rem !important;
            font-weight: 700 !important;
            letter-spacing: -0.01em !important;
        }

        /* Modal Scrollable Content */
        .fi-modal-slide-over-window .fi-modal-content {
            padding: 0.75rem 0.85rem 1.25rem 0.85rem !important;
            overflow-y: auto !important;
            -webkit-overflow-scrolling: touch !important;
            flex: 1 1 auto !important;
            overscroll-behavior: contain !important;
        }

        /* Form Sections inside Mobile Bottom Sheet */
        .fi-modal-slide-over-window .fi-section {
            border-radius: 0.85rem !important;
            margin-bottom: 0.75rem !important;
            border: 1px solid rgba(226, 232, 240, 0.95) !important;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03) !important;
            background-color: #ffffff !important;
            overflow: hidden !important;
        }

        .dark .fi-modal-slide-over-window .fi-section {
            background-color: rgba(17, 24, 39, 0.85) !important;
            border-color: rgba(255, 255, 255, 0.08) !important;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3) !important;
        }

        .fi-modal-slide-over-window .fi-section-header {
            padding: 0.6rem 0.85rem !important;
            border-bottom: 1px solid rgba(241, 245, 249, 1) !important;
        }

        .dark .fi-modal-slide-over-window .fi-section-header {
            border-bottom-color: rgba(255, 255, 255, 0.06) !important;
        }

        .fi-modal-slide-over-window .fi-section-header-heading {
            font-size: 0.875rem !important;
            font-weight: 700 !important;
            letter-spacing: -0.01em !important;
        }

        .fi-modal-slide-over-window .fi-section-content {
            padding: 0.75rem 0.85rem !important;
        }

        /* Form Fields spacing in Bottom Sheet */
        .fi-modal-slide-over-window .fi-fo-component-ctn {
            gap: 0.65rem !important;
        }

        .fi-modal-slide-over-window .fi-fo-field-wrp {
            margin-bottom: 0.2rem !important;
        }

        .fi-modal-slide-over-window .fi-fo-field-wrp-label label {
            font-size: 0.78rem !important;
            font-weight: 600 !important;
            color: #334155 !important;
            margin-bottom: 0.2rem !important;
        }

        .dark .fi-modal-slide-over-window .fi-fo-field-wrp-label label {
            color: #cbd5e1 !important;
        }

        /* Inputs & Selects inside Bottom Sheet */
        .fi-modal-slide-over-window .fi-input-wrp {
            border-radius: 0.55rem !important;
            min-height: 2.5rem !important;
        }

        /* Repeater inside Bottom Sheet: ultra-clean card */
        .fi-modal-slide-over-window .fi-fo-repeater-item {
            border-radius: 0.75rem !important;
            border: 1px solid rgba(226, 232, 240, 0.95) !important;
            background-color: #f8fafc !important;
            margin-bottom: 0.65rem !important;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03) !important;
            overflow: hidden !important;
        }

        .dark .fi-modal-slide-over-window .fi-fo-repeater-item {
            background-color: rgba(15, 23, 42, 0.5) !important;
            border-color: rgba(255, 255, 255, 0.08) !important;
        }

        .fi-modal-slide-over-window .fi-fo-repeater-item-header {
            padding: 0.45rem 0.75rem !important;
            background-color: rgba(241, 245, 249, 0.85) !important;
            border-bottom: 1px solid rgba(226, 232, 240, 0.8) !important;
        }

        .dark .fi-modal-slide-over-window .fi-fo-repeater-item-header {
            background-color: rgba(30, 41, 59, 0.5) !important;
            border-bottom-color: rgba(255, 255, 255, 0.06) !important;
        }

        .fi-modal-slide-over-window .fi-fo-repeater-item-content {
            padding: 0.65rem 0.75rem !important;
            width: 100% !important;
            overflow: hidden !important;
        }

        .fi-modal-slide-over-window .fi-fo-repeater-item-content .grid {
            width: 100% !important;
            max-width: 100% !important;
            min-width: 0 !important;
            gap: 0.55rem 0.5rem !important;
            row-gap: 0.55rem !important;
            column-gap: 0.5rem !important;
        }

        .fi-modal-slide-over-window .fi-fo-repeater-item-content .grid > div {
            min-width: 0 !important;
            max-width: 100% !important;
        }

        /* Repeater Add Button */
        .fi-modal-slide-over-window .fi-fo-repeater-add-action {
            width: 100% !important;
            margin-top: 0.25rem !important;
        }

        .fi-modal-slide-over-window .fi-fo-repeater-add-action button {
            width: 100% !important;
            justify-content: center !important;
            min-height: 2.45rem !important;
            font-size: 0.825rem !important;
            font-weight: 600 !important;
            border-radius: 0.65rem !important;
            background-color: rgba(241, 245, 249, 0.9) !important;
            border: 1px dashed #cbd5e1 !important;
            color: #2563eb !important;
        }

        .dark .fi-modal-slide-over-window .fi-fo-repeater-add-action button {
            background-color: rgba(30, 41, 59, 0.4) !important;
            border-color: rgba(255, 255, 255, 0.15) !important;
            color: #60a5fa !important;
        }

        /* Modal Sticky Footer */
        .fi-modal-slide-over-window .fi-modal-footer {
            position: sticky !important;
            bottom: 0 !important;
            z-index: 30 !important;
            padding: 0.75rem 1.15rem calc(0.75rem + env(safe-area-inset-bottom, 0px)) 1.15rem !important;
            background-color: rgba(255, 255, 255, 0.96) !important;
            backdrop-filter: blur(12px) !important;
            -webkit-backdrop-filter: blur(12px) !important;
            border-top: 1px solid rgba(226, 232, 240, 0.9) !important;
            box-shadow: 0 -4px 16px rgba(0, 0, 0, 0.06) !important;
            flex-shrink: 0 !important;
            margin-top: auto !important;
        }

        .dark .fi-modal-slide-over-window .fi-modal-footer {
            background-color: rgba(11, 15, 25, 0.96) !important;
            border-top-color: rgba(255, 255, 255, 0.08) !important;
            box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.4) !important;
        }

        .fi-modal-slide-over-window .fi-modal-footer-actions {
            width: 100% !important;
            display: flex !important;
            flex-direction: row-reverse !important;
            gap: 0.65rem !important;
        }

        .fi-modal-slide-over-window .fi-modal-footer-actions .fi-btn {
            flex: 1 1 auto !important;
            justify-content: center !important;
            min-height: 2.65rem !important;
            font-weight: 600 !important;
            font-size: 0.875rem !important;
            border-radius: 0.75rem !important;
        }
    }

    /* ---- Very narrow screens (< 380px): stats 1-column ---- */
    @media (max-width: 379px) {
        .fi-wi-stats-overview-stats-ctn {
            grid-template-columns: 1fr !important;
        }
    }

    /* ---- Tablet portrait (768px-1023px): refine grid overrides ---- */
    @media (min-width: 768px) and (max-width: 1023px) {
        /* Cap non-responsive grids at 2 columns on tablet portrait */
        [style*="--cols-default"]:not([style*="--cols-sm"]):not([style*="--cols-md"]):not([style*="--cols-lg"]) {
            --cols-default: repeat(2, minmax(0, 1fr)) !important;
        }
    }

    /* ========================================================
       MOBILE BOTTOM NAVIGATION BAR STYLES
       ======================================================== */
    .fi-mobile-bottom-nav {
        position: fixed !important;
        bottom: 0 !important;
        left: 0 !important;
        right: 0 !important;
        width: 100vw !important;
        height: 4.25rem !important;
        background-color: rgba(255, 255, 255, 0.95) !important;
        backdrop-filter: blur(16px) !important;
        -webkit-backdrop-filter: blur(16px) !important;
        border-top: 1px solid rgba(226, 232, 240, 0.9) !important;
        box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.06) !important;
        z-index: 35 !important;
        display: block !important;
        padding-bottom: env(safe-area-inset-bottom, 0px) !important;
        box-sizing: border-box !important;
    }

    .dark .fi-mobile-bottom-nav {
        background-color: rgba(11, 15, 25, 0.95) !important;
        border-top: 1px solid rgba(255, 255, 255, 0.08) !important;
        box-shadow: 0 -4px 25px rgba(0, 0, 0, 0.3) !important;
    }

    /* Hide bottom nav bar when a modal / bottom sheet is open */
    body:has(.fi-modal-open) .fi-mobile-bottom-nav {
        display: none !important;
    }

    @media (min-width: 1024px) {
        .fi-mobile-bottom-nav {
            display: none !important;
        }
    }

    .fi-bottom-nav-grid {
        display: grid !important;
        grid-template-columns: repeat(5, 1fr) !important;
        height: 100% !important;
        max-width: 32rem !important;
        margin: 0 auto !important;
        align-items: center !important;
    }

    .fi-bottom-nav-item {
        display: flex !important;
        flex-direction: column !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 0.25rem !important;
        height: 100% !important;
        width: 100% !important;
        text-decoration: none !important;
        color: #64748b !important;
        transition: all 0.15s ease !important;
        cursor: pointer !important;
        background: transparent !important;
        border: none !important;
        padding: 0 !important;
    }

    .dark .fi-bottom-nav-item {
        color: #94a3b8 !important;
    }

    .fi-bottom-nav-item:hover,
    .fi-bottom-nav-item:active {
        color: #0f172a !important;
    }

    .dark .fi-bottom-nav-item:hover,
    .dark .fi-bottom-nav-item:active {
        color: #ffffff !important;
    }

    .fi-bottom-nav-item.active {
        color: #d97706 !important;
        font-weight: 600 !important;
    }

    .dark .fi-bottom-nav-item.active {
        color: #fbbf24 !important;
    }

    .fi-bottom-nav-item svg {
        width: 1.35rem !important;
        height: 1.35rem !important;
    }

    .fi-bottom-nav-item span {
        font-size: 0.6875rem !important;
        line-height: 1 !important;
        letter-spacing: -0.01em !important;
    }

    /* Center Prominent Button (Pesanan) */
    .fi-bottom-nav-center {
        position: relative !important;
        display: flex !important;
        flex-direction: column !important;
        align-items: center !important;
        justify-content: center !important;
        text-decoration: none !important;
        margin-top: -1.25rem !important;
        height: 100% !important;
    }

    .fi-bottom-nav-center-btn {
        width: 3.15rem !important;
        height: 3.15rem !important;
        border-radius: 1rem !important;
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
        color: #ffffff !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        box-shadow: 0 4px 14px rgba(245, 158, 11, 0.4) !important;
        border: 3px solid #ffffff !important;
        transition: transform 0.15s ease !important;
    }

    .dark .fi-bottom-nav-center-btn {
        border-color: #0b0f19 !important;
        box-shadow: 0 4px 18px rgba(245, 158, 11, 0.35) !important;
    }

    .fi-bottom-nav-center:active .fi-bottom-nav-center-btn {
        transform: scale(0.92) !important;
    }

    .fi-bottom-nav-center-btn svg {
        width: 1.5rem !important;
        height: 1.5rem !important;
    }

    .fi-bottom-nav-center span {
        font-size: 0.6875rem !important;
        font-weight: 700 !important;
        line-height: 1 !important;
        margin-top: 0.25rem !important;
        color: #1e293b !important;
    }

    .dark .fi-bottom-nav-center span {
        color: #f1f5f9 !important;
    }

    .fi-bottom-nav-center.active span {
        color: #d97706 !important;
    }

    .dark .fi-bottom-nav-center.active span {
        color: #fbbf24 !important;
    }

    /* ========================================================
       DARK MODE ENHANCEMENTS FOR SETTINGS, FORMS & TABS
       ======================================================== */
    .dark .fi-section-header-description {
        color: #94a3b8 !important;
    }

    .dark .fi-fo-field-wrp-helper-text,
    .dark .fi-fo-field-wrp-helper-text * {
        color: #94a3b8 !important;
    }

    .dark input::placeholder,
    .dark textarea::placeholder {
        color: #64748b !important;
        opacity: 0.9 !important;
    }

    /* Tabs active/inactive contrast in dark mode */
    .dark .fi-tabs-item:not(.fi-active) .fi-tabs-item-label {
        color: #94a3b8 !important;
    }

    .dark .fi-tabs-item:not(.fi-active):hover .fi-tabs-item-label {
        color: #f8fafc !important;
    }

    .dark .fi-tabs-item.fi-active {
        background-color: rgba(245, 158, 11, 0.12) !important;
    }

    .dark .fi-tabs-item.fi-active .fi-tabs-item-label {
        color: #fbbf24 !important;
        font-weight: 600 !important;
    }

    .dark .fi-tabs-item.fi-active .fi-tabs-item-icon {
        color: #fbbf24 !important;
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Toggle mobile sidebar when topbar hamburger button is clicked while open
        document.addEventListener('click', (e) => {
            const toggleBtn = e.target.closest('.fi-topbar-open-sidebar-btn');
            if (toggleBtn && window.Alpine) {
                const sidebar = window.Alpine.store('sidebar');
                if (sidebar && sidebar.isOpen) {
                    e.stopImmediatePropagation();
                    e.preventDefault();
                    sidebar.close();
                }
            }
        }, true);

        // Auto-close sidebar on mobile when navigating via sidebar link
        document.addEventListener('click', (e) => {
            const navLink = e.target.closest('.fi-sidebar-nav a');
            if (navLink && window.innerWidth < 1024 && window.Alpine) {
                const sidebar = window.Alpine.store('sidebar');
                if (sidebar && sidebar.isOpen) {
                    sidebar.close();
                }
            }
        });
    });

    window.keehubInvoicePreview = function(defaults) {
        return {
            previewMode: 'invoice',
            headerBrand: '',
            headerTagline: '',
            headerContact: '',
            paymentInstructions: '',
            signatureName: '',
            serviceFooter: '',
            invoiceFooterNotes: '',
            warrantyTerms: '',
            defaults: defaults || {},

            init() {
                if (this.$wire) {
                    this.headerBrand = this.$wire.get('data.invoice_header_brand') || '';
                    this.headerTagline = this.$wire.get('data.invoice_header_tagline') || '';
                    this.headerContact = this.$wire.get('data.invoice_header_contact') || '';
                    this.paymentInstructions = this.$wire.get('data.invoice_payment_instructions') || '';
                    this.signatureName = this.$wire.get('data.invoice_signature_name') || '';
                    this.serviceFooter = this.$wire.get('data.service_invoice_footer') || '';
                    this.invoiceFooterNotes = this.$wire.get('data.invoice_footer_notes') || '';
                    this.warrantyTerms = this.$wire.get('data.service_warranty_terms') || '';

                    this.$watch('$wire.data.invoice_header_brand', val => { this.headerBrand = val || ''; });
                    this.$watch('$wire.data.invoice_header_tagline', val => { this.headerTagline = val || ''; });
                    this.$watch('$wire.data.invoice_header_contact', val => { this.headerContact = val || ''; });
                    this.$watch('$wire.data.invoice_payment_instructions', val => { this.paymentInstructions = val || ''; });
                    this.$watch('$wire.data.invoice_signature_name', val => { this.signatureName = val || ''; });
                    this.$watch('$wire.data.service_invoice_footer', val => { this.serviceFooter = val || ''; });
                    this.$watch('$wire.data.invoice_footer_notes', val => { this.invoiceFooterNotes = val || ''; });
                    this.$watch('$wire.data.service_warranty_terms', val => { this.warrantyTerms = val || ''; });
                }
            }
        };
    };

    window.keehubPrinterPreview = function() {
        return {
            paperSize: '58mm',
            connectionType: 'browser',
            printerName: '',
            printLogo: true,
            headerText: '',
            footerText: '',
            autoCut: true,
            cashDrawer: false,
            copies: '1',
            bluetoothStatus: 'idle',
            bluetoothDeviceName: '',
            usbStatus: 'idle',
            usbDeviceName: '',

            init() {
                if (this.$wire) {
                    this.paperSize = this.$wire.get('data.printer_paper_size') || '58mm';
                    this.connectionType = this.$wire.get('data.printer_connection_type') || 'browser';
                    this.printerName = this.$wire.get('data.printer_name') || '';
                    this.printLogo = this.$wire.get('data.printer_print_logo') ?? true;
                    this.headerText = this.$wire.get('data.printer_header_text') || '';
                    this.footerText = this.$wire.get('data.printer_footer_text') || '';
                    this.autoCut = this.$wire.get('data.printer_auto_cut') ?? true;
                    this.cashDrawer = this.$wire.get('data.printer_open_cash_drawer') ?? false;

                    this.$watch('$wire.data.printer_paper_size', (val) => { this.paperSize = val || '58mm'; });
                    this.$watch('$wire.data.printer_connection_type', (val) => { this.connectionType = val || 'browser'; });
                    this.$watch('$wire.data.printer_name', (val) => { this.printerName = val || ''; });
                    this.$watch('$wire.data.printer_print_logo', (val) => { this.printLogo = !!val; });
                    this.$watch('$wire.data.printer_header_text', (val) => { this.headerText = val || ''; });
                    this.$watch('$wire.data.printer_footer_text', (val) => { this.footerText = val || ''; });
                    this.$watch('$wire.data.printer_auto_cut', (val) => { this.autoCut = !!val; });
                    this.$watch('$wire.data.printer_open_cash_drawer', (val) => { this.cashDrawer = !!val; });
                }
            },

            async pairBluetooth() {
                if (!navigator.bluetooth) {
                    alert('Browser ini tidak mendukung Web Bluetooth API. Silakan gunakan Google Chrome / Microsoft Edge di Android, Windows, atau macOS. Anda tetap bisa mencetak menggunakan metode Sistem Driver / Browser!');
                    return;
                }
                try {
                    this.bluetoothStatus = 'connecting';
                    const device = await navigator.bluetooth.requestDevice({
                        acceptAllDevices: true,
                        optionalServices: [
                            '000018f0-0000-1000-8000-00805f9b34fb',
                            'e7810a71-73ae-499d-8c15-faa9aef0c3f2',
                            '49535343-fe7d-4ae5-8fa9-9fafd205e455'
                        ]
                    });
                    this.bluetoothDeviceName = device.name || 'Printer Bluetooth';
                    this.bluetoothStatus = 'connected';
                    if (this.$wire && device.name) {
                        this.$wire.set('data.printer_device_name', device.name);
                    }
                } catch (err) {
                    if (err.name !== 'NotFoundError') {
                        console.error('Bluetooth pair error:', err);
                        alert('Gagal menghubungkan Bluetooth: ' + err.message);
                    }
                    this.bluetoothStatus = 'idle';
                }
            },

            async pairUsb() {
                if (!navigator.usb) {
                    alert('Browser ini tidak mendukung WebUSB API. Pastikan menggunakan Chrome/Edge versi terbaru pada Laptop/PC.');
                    return;
                }
                try {
                    this.usbStatus = 'connecting';
                    const device = await navigator.usb.requestDevice({ filters: [] });
                    this.usbDeviceName = (device.productName || 'Printer Thermal USB') + (device.manufacturerName ? ' - ' + device.manufacturerName : '');
                    this.usbStatus = 'connected';
                    if (this.$wire && device.productName) {
                        this.$wire.set('data.printer_device_name', device.productName);
                    }
                } catch (err) {
                    if (err.name !== 'NotFoundError') {
                        console.error('USB pair error:', err);
                        alert('Gagal mendeteksi perangkat USB: ' + err.message);
                    }
                    this.usbStatus = 'idle';
                }
            },

            printThermalReceipt() {
                const is80 = (this.paperSize || '58mm') === '80mm';
                const width = is80 ? '80mm' : '58mm';
                const contentEl = document.getElementById('keehub-live-thermal-receipt-body');
                if (!contentEl) return;

                let iframe = document.getElementById('keehub-thermal-print-frame');
                if (!iframe) {
                    iframe = document.createElement('iframe');
                    iframe.id = 'keehub-thermal-print-frame';
                    iframe.style.position = 'fixed';
                    iframe.style.right = '0';
                    iframe.style.bottom = '0';
                    iframe.style.width = '0';
                    iframe.style.height = '0';
                    iframe.style.border = '0';
                    document.body.appendChild(iframe);
                }

                const doc = iframe.contentWindow.document;
                const html = [
                    '<!DOCTYPE html>',
                    '<html><head><meta charset="utf-8"><title>Uji Coba Struk Thermal - KeeHub<' + '/title>',
                    '<style>',
                    '@page { size: ' + width + ' auto; margin: 0; }',
                    '* { box-sizing: border-box; }',
                    'body { margin: 0; padding: ' + (is80 ? '5mm 4mm' : '3mm 2mm') + '; font-family: "Courier New", Courier, monospace; font-size: ' + (is80 ? '12px' : '10.5px') + '; line-height: 1.25; color: #000; background: #fff; width: ' + width + '; -webkit-print-color-adjust: exact; }',
                    '.text-center { text-align: center; } .text-right { text-align: right; } .text-left { text-align: left; } .font-bold { font-weight: bold; }',
                    '.dashed-line { border-top: 1px dashed #000; margin: 5px 0; }',
                    '.double-line { border-top: 2px solid #000; margin: 6px 0; }',
                    '.flex-row { display: flex; justify-content: space-between; }',
                    'img.receipt-logo { max-width: ' + (is80 ? '45mm' : '32mm') + '; max-height: 18mm; margin: 0 auto 4px auto; display: block; filter: grayscale(100%) contrast(150%); }',
                    '<' + '/style><' + '/head><body>',
                    contentEl.innerHTML,
                    '<' + '/body><' + '/html>'
                ].join('\n');
                doc.open();
                doc.write(html);
                doc.close();

                setTimeout(() => {
                    iframe.contentWindow.focus();
                    iframe.contentWindow.print();
                }, 300);
            }
        };
    };
</script>
