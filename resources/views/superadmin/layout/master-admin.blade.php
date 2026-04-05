<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel')</title>

    {{-- Base template assets --}}
    <link href="{{ asset('asset/css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@7.2.96/css/materialdesignicons.min.css">
    <link href="{{ asset('asset/css/colors/blue.css') }}" id="theme" rel="stylesheet">

    <script src="{{ asset('asset/plugins/jquery/jquery-3.6.0.min.js') }}"></script>

    <style>
    /* ═══════════════════════════════════════════════════════
       ADMIN SHELL  — all classes prefixed sa- to avoid
       conflicts with the base template's style.css
    ═══════════════════════════════════════════════════════ */

    *, *::before, *::after { box-sizing: border-box; }

    html, body {
        margin: 0; padding: 0;
        font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        background: #f0f3f8;
        min-height: 100vh;
    }

    /* ─── Preloader ─── */
    #sa-preloader {
        position: fixed; inset: 0; background: #fff;
        z-index: 99999; display: flex; align-items: center; justify-content: center;
        transition: opacity 0.35s ease;
    }
    #sa-preloader .spin {
        width: 40px; height: 40px;
        border: 3px solid #e8f0fe;
        border-top-color: #1a73e8;
        border-radius: 50%;
        animation: saSpin 0.75s linear infinite;
    }
    @keyframes saSpin { to { transform: rotate(360deg); } }

    /* ─── Sidebar overlay (mobile) ─── */
    #sa-overlay {
        display: none;
        position: fixed; inset: 0;
        background: rgba(15, 23, 42, 0.5);
        z-index: 1040;
        backdrop-filter: blur(2px);
        transition: opacity 0.25s ease;
        opacity: 0;
    }
    #sa-overlay.active { opacity: 1; }

    /* ─── Top navbar ─── */
    #sa-topbar {
        position: fixed; top: 0; left: 0; right: 0;
        height: 62px; z-index: 1050;
        background: #fff;
        border-bottom: 1px solid #e8ecf3;
        box-shadow: 0 1px 8px rgba(0,0,0,0.06);
        display: flex; align-items: center;
        padding: 0 20px; gap: 12px;
    }
    #sa-topbar .sa-brand {
        display: flex; align-items: center; gap: 10px;
        text-decoration: none; flex-shrink: 0;
    }
    #sa-topbar .sa-brand img {
        height: 38px; width: 38px; border-radius: 8px; object-fit: cover;
    }
    #sa-topbar .sa-brand-name {
        font-size: 1rem; font-weight: 700; color: #1e293b;
        white-space: nowrap;
    }
    /* Hamburger button — always visible */
    #sa-menu-btn {
        background: none; border: none; cursor: pointer;
        width: 38px; height: 38px; border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        color: #475569; transition: background 0.18s, color 0.18s;
        flex-shrink: 0; padding: 0;
    }
    #sa-menu-btn:hover { background: #f1f5f9; color: #1a73e8; }
    #sa-menu-btn i { font-size: 1.45rem; line-height: 1; }

    /* Spacer pushes right section to end */
    #sa-topbar .sa-spacer { flex: 1; }

    /* Right section */
    #sa-topbar .sa-topbar-right {
        display: flex; align-items: center; gap: 6px; flex-shrink: 0;
    }
    .sa-user-email {
        font-size: 0.82rem; color: #475569; font-weight: 500;
        max-width: 160px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
        padding: 0 4px;
    }
    .sa-avatar-btn {
        background: none; border: none; cursor: pointer; padding: 2px;
        border-radius: 50%; position: relative;
    }
    .sa-avatar-btn img {
        width: 36px; height: 36px; border-radius: 50%;
        border: 2px solid #e8ecf0; object-fit: cover;
        display: block;
    }
    /* Dropdown */
    .sa-dropdown {
        position: absolute; top: calc(100% + 10px); right: 0;
        background: #fff; border: 1px solid #e8ecf3;
        border-radius: 12px; min-width: 190px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.12);
        padding: 6px 0; z-index: 2000;
        display: none;
    }
    .sa-dropdown.open { display: block; }
    .sa-dropdown a {
        display: flex; align-items: center; gap: 10px;
        padding: 10px 16px; font-size: 0.85rem; font-weight: 500;
        color: #374151; text-decoration: none;
        transition: background 0.15s;
    }
    .sa-dropdown a:hover { background: #f8faff; }
    .sa-dropdown a i { font-size: 1rem; width: 18px; text-align: center; }
    .sa-dropdown .sa-divider { height: 1px; background: #f1f4f8; margin: 4px 0; }
    .sa-dropdown .sa-logout { color: #ef4444; }
    .sa-dropdown .sa-logout:hover { background: #fff1f2; }

    /* ─── Sidebar ─── */
    #sa-sidebar {
        position: fixed; top: 62px; left: 0; bottom: 0;
        width: 235px; z-index: 1045;
        background: #fff;
        border-right: 1px solid #e8ecf3;
        display: flex; flex-direction: column;
        transition: transform 0.28s cubic-bezier(0.4, 0, 0.2, 1);
        overflow-y: auto; overflow-x: hidden;
    }

    /* Desktop collapsed (mini) */
    body.sa-mini #sa-sidebar { width: 64px; }
    body.sa-mini #sa-sidebar .sa-nav-label,
    body.sa-mini #sa-sidebar .sa-section-label { display: none; }
    body.sa-mini #sa-sidebar .sa-nav-link { justify-content: center; padding: 13px 0; }
    body.sa-mini #sa-sidebar .sa-nav-link i { margin: 0; }
    body.sa-mini #sa-topbar .sa-brand-name { display: none; }

    /* Mobile: hidden by default, slides in when open */
    @media (max-width: 991px) {
        #sa-sidebar { transform: translateX(-100%); }
        #sa-sidebar.open { transform: translateX(0); }
        #sa-overlay { display: block; }
        body.sa-mini #sa-sidebar { width: 235px; }
    }

    /* Sidebar scrollbar */
    #sa-sidebar::-webkit-scrollbar { width: 4px; }
    #sa-sidebar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }

    /* Nav section labels */
    .sa-section-label {
        font-size: 0.65rem; font-weight: 800; color: #94a3b8;
        text-transform: uppercase; letter-spacing: 0.09em;
        padding: 18px 20px 6px; line-height: 1;
    }

    /* Nav links */
    .sa-nav-link {
        display: flex; align-items: center; gap: 11px;
        padding: 11px 20px; font-size: 0.875rem; font-weight: 500;
        color: #64748b; text-decoration: none;
        transition: background 0.16s, color 0.16s;
        border-left: 3px solid transparent;
        white-space: nowrap;
    }
    .sa-nav-link i { font-size: 1.15rem; width: 20px; text-align: center; flex-shrink: 0; }
    .sa-nav-link:hover { background: #f8faff; color: #1a73e8; text-decoration: none; }
    .sa-nav-link.active {
        background: #eef3ff; color: #1a73e8; font-weight: 600;
        border-left-color: #1a73e8;
    }

    /* Sidebar bottom padding */
    #sa-sidebar .sa-sidebar-footer { padding: 12px 0; margin-top: auto; border-top: 1px solid #f1f4f8; }

    /* ─── Page content ─── */
    #sa-content {
        margin-left: 235px;
        padding-top: 62px;
        min-height: 100vh;
        transition: margin-left 0.28s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex; flex-direction: column;
    }
    body.sa-mini #sa-content { margin-left: 64px; }

    #sa-content .sa-body { flex: 1; padding: 24px 26px; }

    /* Mobile: full width */
    @media (max-width: 991px) {
        #sa-content { margin-left: 0 !important; }
        #sa-content .sa-body { padding: 16px 14px; }
    }
    @media (max-width: 575px) {
        #sa-topbar { padding: 0 12px; }
        #sa-topbar .sa-brand-name { display: none; }
        .sa-user-email { display: none; }
        #sa-content .sa-body { padding: 12px 10px; }
    }

    /* ─── Footer ─── */
    #sa-footer {
        padding: 14px 26px; font-size: 0.8rem; color: #94a3b8;
        border-top: 1px solid #eef0f5; background: #fff;
        text-align: center;
    }

    /* ─── Global card overrides ─── */
    .card {
        border-radius: 12px !important;
        border: 1px solid #e8ecf0 !important;
        box-shadow: 0 2px 12px rgba(0,0,0,0.05) !important;
    }
    .card .card-body { padding: 20px !important; }

    @media (max-width: 575px) {
        .card { border-radius: 10px !important; }
        .card .card-body { padding: 14px !important; }
    }

    /* Compatibility: keep old page-wrapper & container-fluid for page styles */
    .page-wrapper { background: transparent !important; box-shadow: none !important; padding: 0 !important; margin: 0 !important; }
    .page-titles  { display: none !important; }
    .container-fluid { padding: 0 !important; }
    .fix-header .topbar, .left-sidebar { all: unset; }
    </style>
</head>

<body>

    {{-- Preloader --}}
    <div id="sa-preloader"><div class="spin"></div></div>

    {{-- Mobile overlay --}}
    <div id="sa-overlay"></div>

    {{-- ═══ TOP NAVBAR ═══ --}}
    <header id="sa-topbar">

        {{-- Hamburger — always visible, works on all screen sizes --}}
        <button id="sa-menu-btn" title="Toggle menu">
            <i class="mdi mdi-menu"></i>
        </button>

        {{-- Brand --}}
        <a class="sa-brand" href="{{ route('superadmin.dashboard-admin') }}">
            <img src="{{ asset('asset/default.jpg') }}" alt="logo">
            <span class="sa-brand-name">Admin Panel</span>
        </a>

        <div class="sa-spacer"></div>

        {{-- Right section --}}
        <div class="sa-topbar-right">
            <span class="sa-user-email">
                <i class="mdi mdi-account-circle" style="color:#1a73e8; margin-right:4px;"></i>
                {{ session('email_id') }}
            </span>

            {{-- Avatar + dropdown --}}
            <div style="position:relative;">
                <button class="sa-avatar-btn" id="sa-avatar-btn">
                    <img src="{{ asset('asset/default.jpg') }}" alt="user">
                </button>
                <div class="sa-dropdown" id="sa-user-dropdown">
                    <div style="padding:10px 16px 8px; border-bottom:1px solid #f1f4f8;">
                        <div style="font-size:0.8rem; color:#94a3b8;">Signed in as</div>
                        <div style="font-size:0.85rem; font-weight:600; color:#1e293b; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; max-width:155px;">{{ session('email_id') }}</div>
                    </div>
                    <a href="{{ route('superadmin.change-password') }}">
                        <i class="mdi mdi-key" style="color:#1a73e8;"></i> Change Password
                    </a>
                    <div class="sa-divider"></div>
                    <a href="{{ route('superadmin.logout') }}" class="sa-logout">
                        <i class="mdi mdi-logout-variant"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </header>

    {{-- ═══ SIDEBAR ═══ --}}
    <aside id="sa-sidebar">
        <div style="padding-top: 8px; flex:1;">

            <div class="sa-section-label">Main</div>

            <a href="{{ route('superadmin.dashboard-admin') }}"
               class="sa-nav-link {{ request()->routeIs('superadmin.dashboard-admin') ? 'active' : '' }}">
                <i class="mdi mdi-view-dashboard-outline"></i>
                <span class="sa-nav-label">Dashboard</span>
            </a>

            <div class="sa-section-label">Management</div>

            <a href="{{ route('superadmin.admin-gp.list') }}"
               class="sa-nav-link {{ request()->routeIs('superadmin.admin-gp.*') ? 'active' : '' }}">
                <i class="mdi mdi-domain"></i>
                <span class="sa-nav-label">GP List</span>
            </a>

        </div>

        <div class="sa-sidebar-footer">
            <div class="sa-section-label">Account</div>
            <a href="{{ route('superadmin.logout') }}" class="sa-nav-link">
                <i class="mdi mdi-logout-variant"></i>
                <span class="sa-nav-label">Logout</span>
            </a>
        </div>
    </aside>

    {{-- ═══ MAIN CONTENT ═══ --}}
    <div id="sa-content">
        <div class="sa-body">
            {{-- Compatibility wrapper so existing page styles still work --}}
            <div class="page-wrapper">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <footer id="sa-footer">
            &copy; {{ date('Y') }} Admin Panel &nbsp;&mdash;&nbsp; All rights reserved.
        </footer>
    </div>

    {{-- Scripts --}}
    <script src="{{ asset('asset/plugins/popper/popper.min.js') }}"></script>
    <script src="{{ asset('asset/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('asset/js/waves.js') }}"></script>
    <script src="{{ asset('asset/plugins/sweetalert/sweetalert2@11.js') }}"></script>

    <script>
    (function () {
        var overlay  = document.getElementById('sa-overlay');
        var sidebar  = document.getElementById('sa-sidebar');
        var menuBtn  = document.getElementById('sa-menu-btn');
        var avatarBtn = document.getElementById('sa-avatar-btn');
        var dropdown  = document.getElementById('sa-user-dropdown');
        var isMobile  = function () { return window.innerWidth <= 991; };

        /* ── Sidebar toggle ── */
        function openSidebar() {
            sidebar.classList.add('open');
            overlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
        function closeSidebar() {
            sidebar.classList.remove('open');
            overlay.classList.remove('active');
            document.body.style.overflow = '';
        }

        menuBtn.addEventListener('click', function () {
            if (isMobile()) {
                sidebar.classList.contains('open') ? closeSidebar() : openSidebar();
            } else {
                document.body.classList.toggle('sa-mini');
            }
        });

        overlay.addEventListener('click', closeSidebar);

        window.addEventListener('resize', function () {
            if (!isMobile()) closeSidebar();
        });

        /* ── Avatar dropdown ── */
        avatarBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            dropdown.classList.toggle('open');
        });
        document.addEventListener('click', function () {
            dropdown.classList.remove('open');
        });

        /* ── Preloader ── */
        window.addEventListener('load', function () {
            var p = document.getElementById('sa-preloader');
            if (!p) return;
            p.style.opacity = '0';
            setTimeout(function () { p.style.display = 'none'; }, 400);
        });
    })();
    </script>

</body>
</html>
