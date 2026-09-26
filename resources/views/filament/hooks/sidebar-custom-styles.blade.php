<style>
    /* ==========================================================================
       Hahakar Admin Panel - Custom Theme Sidebar Styles
       ========================================================================== */

    /* 1. Remove & Hide Scroller/Scrollbar Across All Browsers */
    .fi-sidebar,
    .fi-sidebar-nav,
    aside.fi-sidebar,
    aside.fi-sidebar * {
        scrollbar-width: none !important; /* Firefox */
        -ms-overflow-style: none !important; /* IE & Edge */
    }

    .fi-sidebar::-webkit-scrollbar,
    .fi-sidebar-nav::-webkit-scrollbar,
    aside.fi-sidebar::-webkit-scrollbar,
    aside.fi-sidebar *::-webkit-scrollbar {
        display: none !important;
        width: 0px !important;
        height: 0px !important;
        background: transparent !important;
    }

    /* 2. Preserve Logo Header Intact (White Clean Background with Logo) */
    .fi-sidebar-header,
    header.fi-sidebar-header {
        background-color: #ffffff !important;
        border-bottom: 1px solid #e2e8f0 !important;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05) !important;
    }

    /* 3. Theme Background Color for Sidebar Body & Navigation (#070d1e) */
    aside.fi-sidebar {
        background-color: #070d1e !important;
        border-right: 1px solid #1e293b !important;
    }

    .fi-sidebar-nav,
    nav.fi-sidebar-nav {
        background: linear-gradient(180deg, #091024 0%, #070d1e 100%) !important;
        background-color: #070d1e !important;
        border-right: 1px solid #1e293b !important;
    }

    /* 4. Group Headings (Settings, Bookings & Operations, Support Desk, etc.) */
    .fi-sidebar-group-label,
    span.fi-sidebar-group-label {
        color: #94a3b8 !important; /* Slate-400 */
        font-size: 0.72rem !important;
        font-weight: 700 !important;
        letter-spacing: 0.06em !important;
        text-transform: uppercase !important;
    }

    .fi-sidebar-group-button:hover .fi-sidebar-group-label {
        color: #e2e8f0 !important;
    }

    .fi-sidebar-group-collapse-button,
    .fi-sidebar-group-collapse-button svg {
        color: #64748b !important;
    }

    .fi-sidebar-group-button:hover .fi-sidebar-group-collapse-button,
    .fi-sidebar-group-button:hover .fi-sidebar-group-collapse-button svg {
        color: #e2e8f0 !important;
    }

    /* 5. Regular Sidebar Item Links & Icons */
    .fi-sidebar-item-button {
        color: #94a3b8 !important;
        font-size: 0.85rem !important;
        font-weight: 500 !important;
        border-radius: 0.625rem !important;
        padding-top: 0.55rem !important;
        padding-bottom: 0.55rem !important;
        transition: all 0.15s ease-in-out !important;
    }

    .fi-sidebar-item-button .fi-sidebar-item-label,
    .fi-sidebar-item-button span {
        color: #94a3b8 !important;
        transition: color 0.15s ease-in-out !important;
    }

    .fi-sidebar-item-icon {
        color: #64748b !important;
        transition: color 0.15s ease-in-out !important;
    }

    /* 6. Item Hover State */
    .fi-sidebar-item-button:hover {
        background-color: rgba(255, 255, 255, 0.06) !important;
    }

    .fi-sidebar-item-button:hover .fi-sidebar-item-label,
    .fi-sidebar-item-button:hover span {
        color: #ffffff !important;
    }

    .fi-sidebar-item-button:hover .fi-sidebar-item-icon {
        color: #34d399 !important; /* Emerald-400 */
    }

    /* 7. Active Selected Item State (e.g. Website Settings) */
    .fi-sidebar-item.fi-active > .fi-sidebar-item-button,
    .fi-sidebar-item-active > .fi-sidebar-item-button {
        background: linear-gradient(90deg, rgba(16, 185, 129, 0.18) 0%, rgba(16, 185, 129, 0.08) 100%) !important;
        border: 1px solid rgba(16, 185, 129, 0.35) !important;
        box-shadow: 0 2px 10px rgba(16, 185, 129, 0.15) !important;
    }

    .fi-sidebar-item.fi-active > .fi-sidebar-item-button .fi-sidebar-item-label,
    .fi-sidebar-item.fi-active > .fi-sidebar-item-button span,
    .fi-sidebar-item-active > .fi-sidebar-item-button .fi-sidebar-item-label,
    .fi-sidebar-item-active > .fi-sidebar-item-button span {
        color: #34d399 !important; /* Emerald-400 */
        font-weight: 700 !important;
    }

    .fi-sidebar-item.fi-active > .fi-sidebar-item-button .fi-sidebar-item-icon,
    .fi-sidebar-item-active > .fi-sidebar-item-button .fi-sidebar-item-icon {
        color: #10b981 !important; /* Emerald-500 */
    }

    /* 8. Grouped Tree Borders & Nested Dots */
    .fi-sidebar-item-grouped-border div {
        background-color: #334155 !important;
    }

    .fi-sidebar-item.fi-active .fi-sidebar-item-grouped-border div.bg-primary-600,
    .fi-sidebar-item.fi-active .fi-sidebar-item-grouped-border div.dark\:bg-primary-400 {
        background-color: #10b981 !important;
    }

    /* 9. Sidebar Footer (if present) */
    .fi-sidebar-footer {
        background-color: #070d1e !important;
        border-top: 1px solid #1e293b !important;
    }
</style>
