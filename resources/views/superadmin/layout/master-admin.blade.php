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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="{{ asset('asset/css/colors/blue.css') }}" id="theme" rel="stylesheet">
    <link href="{{ asset('asset/css/master.css') }}" rel="stylesheet">

    <script src="{{ asset('asset/plugins/jquery/jquery-3.6.0.min.js') }}"></script>

    <style>
    /* ═══════════════════════════════════════════════════════
       SUPER ADMIN SHELL — Teal + Cyan Theme
       Primary: #0F5C7B  |  Accent: #00BFC5  |  Sidebar: #0D3D47
    ═══════════════════════════════════════════════════════ */

    *, *::before, *::after { box-sizing: border-box; }

    html, body {
        margin: 0; padding: 0;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        background: #F5F7FA;
        min-height: 100vh;
    }

    /* ─── Preloader ─── */
    #sa-preloader {
        position: fixed; inset: 0; background: #0D3D47;
        z-index: 99999; display: flex; align-items: center; justify-content: center;
        transition: opacity 0.35s ease;
    }
    #sa-preloader .spin {
        width: 40px; height: 40px;
        border: 3px solid rgba(255,255,255,.15);
        border-top-color: #00BFC5;
        border-radius: 50%;
        animation: saSpin 0.75s linear infinite;
    }
    @keyframes saSpin { to { transform: rotate(360deg); } }

    /* ─── Sidebar overlay (mobile) ─── */
    #sa-overlay {
        display: none;
        position: fixed; inset: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1040;
        backdrop-filter: blur(2px);
        transition: opacity 0.25s ease;
        opacity: 0;
    }
    #sa-overlay.active { opacity: 1; }

    /* ─── Top navbar ─── */
    #sa-topbar {
        position: fixed; top: 0; left: 0; right: 0;
        height: 56px; z-index: 1050;
        background: #fff;
        border-bottom: 1px solid #E5E9F1;
        box-shadow: 0 1px 4px rgba(0,0,0,0.04);
        display: flex; align-items: center;
        padding: 0 20px; gap: 12px;
    }
    #sa-topbar .sa-brand {
        display: flex; align-items: center; gap: 10px;
        text-decoration: none; flex-shrink: 0;
    }
    #sa-topbar .sa-brand img {
        height: 36px; width: 36px; border-radius: 8px; object-fit: cover;
    }
    #sa-topbar .sa-brand-name {
        font-size: 0.95rem; font-weight: 700; color: #0D3D47;
        white-space: nowrap;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    /* Hamburger button */
    #sa-menu-btn {
        background: none; border: none; cursor: pointer;
        width: 38px; height: 38px; border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        color: #708090; transition: background 0.18s, color 0.18s;
        flex-shrink: 0; padding: 0;
    }
    #sa-menu-btn:hover { background: rgba(0,191,197,.08); color: #0F5C7B; }
    #sa-menu-btn i { font-size: 1.45rem; line-height: 1; }

    #sa-topbar .sa-spacer { flex: 1; }

    #sa-topbar .sa-topbar-right {
        display: flex; align-items: center; gap: 6px; flex-shrink: 0;
    }
    .sa-user-email {
        font-size: 0.8rem; color: #0D3D47; font-weight: 500;
        max-width: 160px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
        padding: 6px 12px; border-radius: 9999px;
        background: rgba(0,191,197,.08); border: 1px solid rgba(0,191,197,.25);
    }
    .sa-avatar-btn {
        background: none; border: none; cursor: pointer; padding: 2px;
        border-radius: 50%; position: relative;
    }
    .sa-avatar-btn img {
        width: 34px; height: 34px; border-radius: 50%;
        border: 2px solid rgba(0,191,197,.3); object-fit: cover;
        display: block;
    }
    /* Dropdown */
    .sa-dropdown {
        position: absolute; top: calc(100% + 10px); right: 0;
        background: #fff; border: 1px solid #E5E9F1;
        border-radius: 14px; min-width: 200px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.10);
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
    .sa-dropdown a:hover { background: rgba(0,191,197,.06); color: #0F5C7B; }
    .sa-dropdown a i { font-size: 1rem; width: 18px; text-align: center; color: #0F5C7B; }
    .sa-dropdown .sa-divider { height: 1px; background: #E5E9F1; margin: 4px 0; }
    .sa-dropdown .sa-logout { color: #E54545 !important; }
    .sa-dropdown .sa-logout:hover { background: rgba(229,69,69,.06) !important; }
    .sa-dropdown .sa-logout i { color: #E54545 !important; }

    /* ─── Sidebar ─── */
    #sa-sidebar {
        position: fixed; top: 56px; left: 0; bottom: 0;
        width: 235px; z-index: 1045;
        background: #0D3D47;
        border-right: none;
        display: flex; flex-direction: column;
        transition: transform 0.28s cubic-bezier(0.4, 0, 0.2, 1);
        overflow-y: auto; overflow-x: hidden;
    }

    body.sa-mini #sa-sidebar { width: 64px; }
    body.sa-mini #sa-sidebar .sa-nav-label,
    body.sa-mini #sa-sidebar .sa-section-label { display: none; }
    body.sa-mini #sa-sidebar .sa-nav-link { justify-content: center; padding: 13px 0; }
    body.sa-mini #sa-sidebar .sa-nav-link i { margin: 0; }
    body.sa-mini #sa-topbar .sa-brand-name { display: none; }

    @media (max-width: 991px) {
        #sa-sidebar { transform: translateX(-100%); }
        #sa-sidebar.open { transform: translateX(0); }
        #sa-overlay { display: block; }
        body.sa-mini #sa-sidebar { width: 235px; }
    }

    #sa-sidebar::-webkit-scrollbar { width: 3px; }
    #sa-sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,.15); border-radius: 4px; }

    /* Nav section labels */
    .sa-section-label {
        font-size: 0.62rem; font-weight: 800; color: rgba(0,191,197,.65);
        text-transform: uppercase; letter-spacing: 0.10em;
        padding: 16px 20px 5px; line-height: 1;
    }

    /* Nav links */
    .sa-nav-link {
        display: flex; align-items: center; gap: 11px;
        padding: 10px 20px; font-size: 0.875rem; font-weight: 500;
        color: #D1E4E8 !important; text-decoration: none !important;
        transition: background 0.16s, color 0.16s;
        border-left: 3px solid transparent;
        white-space: nowrap;
    }
    .sa-nav-link i { font-size: 1.1rem; width: 20px; text-align: center; flex-shrink: 0; color: #94B8C0; }
    .sa-nav-label { color: inherit !important; }
    .sa-nav-link:hover {
        background: #1A4A52 !important;
        color: #ffffff !important;
        text-decoration: none !important;
    }
    .sa-nav-link:hover i { color: #00BFC5 !important; }
    .sa-nav-link.active {
        background: #1A4A52 !important;
        color: #ffffff !important;
        font-weight: 600;
        border-left-color: #00BFC5;
    }
    .sa-nav-link.active i { color: #00BFC5 !important; }

    #sa-sidebar .sa-sidebar-footer { padding: 12px 0; margin-top: auto; border-top: 1px solid rgba(255,255,255,.07); }

    /* ─── Page content ─── */
    #sa-content {
        margin-left: 235px;
        padding-top: 56px;
        min-height: 100vh;
        background: #F5F7FA;
        transition: margin-left 0.28s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex; flex-direction: column;
    }
    body.sa-mini #sa-content { margin-left: 64px; }

    #sa-content .sa-body { flex: 1; padding: 24px 26px; }

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
        padding: 14px 26px; font-size: 0.75rem; color: #708090;
        border-top: 1px solid #E5E9F1; background: #fff;
        text-align: center;
    }

    /* ─── Global card overrides ─── */
    .card {
        border-radius: 12px !important;
        border: 1px solid #E5E9F1 !important;
        box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 4px 16px rgba(0,0,0,.04) !important;
    }
    .card .card-body { padding: 20px 22px !important; }

    @media (max-width: 575px) {
        .card { border-radius: 10px !important; }
        .card .card-body { padding: 14px !important; }
    }

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
                <i class="mdi mdi-account-circle" style="color:#00BFC5; margin-right:4px;"></i>
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
                        <i class="mdi mdi-key" style="color:#0F5C7B;"></i> Change Password
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

            <a href="{{ route('superadmin.dashboard-admin') }}"
               class="sa-nav-link {{ request()->routeIs('superadmin.dashboard-admin') ? 'active' : '' }}">
                <i class="mdi mdi-view-dashboard-outline"></i>
                <span class="sa-nav-label">Dashboard</span>
            </a>

            <a href="{{ route('superadmin.admin-gp.list') }}"
               class="sa-nav-link {{ request()->routeIs('superadmin.admin-gp.*') ? 'active' : '' }}">
                <i class="mdi mdi-domain"></i>
                <span class="sa-nav-label">GP List</span>
            </a>

            <a href="{{ route('superadmin.talukas.index') }}"
               class="sa-nav-link {{ request()->routeIs('superadmin.talukas.*') ? 'active' : '' }}">
                <i class="mdi mdi-map-marker-multiple-outline"></i>
                <span class="sa-nav-label">Talukas</span>
            </a>

        </div>

        <div class="sa-sidebar-footer">
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
