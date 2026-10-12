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

    .fi-sidebar.fi-sidebar-open .fi-sidebar-header > div:first-child {
        display: flex !important;
    }

    aside.fi-sidebar:not(.fi-sidebar-open) .fi-sidebar-header > div:first-child {
        display: none !important;
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
       COLLAPSED (MINIMIZED) SIDEBAR MODE - SLEEK DOCK STYLE
       ======================================================== */
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
</style>
