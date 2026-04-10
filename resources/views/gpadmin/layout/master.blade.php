<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — ग्रामपंचायत Admin</title>

    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            corePlugins: { preflight: false },
            theme: {
                extend: {
                    colors: {
                        primary:   '#0F5C7B',
                        accent:    '#00BFC5',
                        sidebar:   '#0D3D47',
                        'sidebar-active': '#1A4A52',
                        surface:   '#FFFFFF',
                        border:    '#E5E9F1',
                        'page-bg': '#F5F7FA',
                        'text-primary':   '#0D3D47',
                        'text-secondary': '#708090',
                    },
                    borderRadius: { xl: '12px', '2xl': '16px' },
                    fontFamily: {
                        sans:    ['Inter', 'system-ui', 'sans-serif'],
                        display: ['"Plus Jakarta Sans"', 'system-ui', 'sans-serif'],
                    },
                    boxShadow: {
                        card: '0 1px 2px 0 rgba(0,0,0,.05)',
                        md:   '0 4px 6px -1px rgba(0,0,0,.1), 0 2px 4px -2px rgba(0,0,0,.1)',
                    },
                }
            }
        }
    </script>

    {{-- Icons & Fonts --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@7.2.96/css/materialdesignicons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Legacy template assets --}}
    <link href="{{ asset('asset/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('asset/css/colors/blue.css') }}" rel="stylesheet">

    {{-- Custom theme overrides --}}
    <link href="{{ asset('asset/css/master.css') }}" rel="stylesheet">

    <script src="{{ asset('asset/plugins/jquery/jquery-3.6.0.min.js') }}"></script>

    <style>
        * { font-family: 'Inter', sans-serif; }

        /* ── Sidebar active item ──────────────── */
        .nav-item-active {
            background: #1A4A52 !important;
            color: #ffffff !important;
            border-left: 3px solid #00BFC5 !important;
        }
        .nav-item-active i { color: #00BFC5 !important; }

        /* ── Sidebar width shim for page offset ─ */
        @media (min-width: 768px) {
            #page-main { margin-left: 256px; }
        }

        /* ── Page content area background ──────── */
        body { background: #F5F7FA !important; }
        #page-main { background: #F5F7FA; }

        /* ── Topbar height & offset ─────────────── */
        #topbar { height: 56px; }
        #page-body { padding-top: 56px; }

        /* ── Sidebar overlay (mobile) ───────────── */
        #sidebar-overlay {
            display: none;
            position: fixed; inset: 0;
            background: rgba(0,0,0,.5);
            z-index: 29;
        }
        #sidebar-overlay.active { display: block; }

        /* ── Mobile: hide sidebar + full-width topbar/footer ── */
        @media (max-width: 767px) {
            #sidebar { transform: translateX(-256px) !important; }
            #topbar  { left: 0 !important; }
            #page-footer { left: 0 !important; }
        }

        /* ── Sidebar scroll ─────────────────────── */
        #sidebar-scroll::-webkit-scrollbar { width: 3px; }
        #sidebar-scroll::-webkit-scrollbar-thumb { background: rgba(255,255,255,.15); border-radius: 4px; }

        /* ── Force sidebar link colors ─────────── */
        #sidebar a,
        #sidebar button,
        #sidebar-scroll a,
        #sidebar-scroll button {
            color: #D1E4E8 !important;
            text-decoration: none !important;
            background: transparent;
        }
        #sidebar a:hover,
        #sidebar button:hover {
            color: #ffffff !important;
            background: #1A4A52 !important;
        }
        #sidebar .nav-item-active,
        #sidebar a.nav-item-active {
            color: #ffffff !important;
            background: #1A4A52 !important;
            border-left: 3px solid #00BFC5 !important;
        }
        #sidebar .nav-item-active i {
            color: #00BFC5 !important;
        }
        #sidebar .nav-cap-label {
            color: #5DABB5 !important;
            font-size: 10px !important;
            font-weight: 700 !important;
            letter-spacing: 0.12em !important;
            text-transform: uppercase !important;
            display: block;
            padding: 14px 12px 4px;
        }

        /* ── Profile dropdown ───────────────────── */
        #profile-menu { display: none; }
        #profile-menu.open { display: block; }

        /* ── Preloader ──────────────────────────── */
        #gp-preloader {
            position: fixed; inset: 0; z-index: 9999;
            background: #0D3D47;
            display: flex; align-items: center; justify-content: center;
        }
        .spin-ring {
            width: 44px; height: 44px;
            border: 3px solid rgba(255,255,255,.15);
            border-top-color: #00BFC5;
            border-radius: 50%;
            animation: spin .7s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }
    </style>
</head>

<body>

{{-- Preloader --}}
<div id="gp-preloader">
    <div class="spin-ring"></div>
</div>

{{-- Sidebar overlay (mobile) --}}
<div id="sidebar-overlay" onclick="closeSidebar()"></div>

{{-- ══════════════════════════════════════════════
     SIDEBAR
     ══════════════════════════════════════════════ --}}
<aside id="sidebar"
    class="fixed inset-y-0 left-0 z-30 flex flex-col"
    style="width:256px; background:#0D3D47; transform:translateX(0); transition:transform .25s;">

    {{-- Brand --}}
    <div class="flex items-center gap-3 px-4 py-4" style="border-bottom:1px solid rgba(255,255,255,.08);">
        <img src="{{ asset('asset/default.jpg') }}" alt="logo"
             style="width:36px;height:36px;border-radius:8px;object-fit:cover;">
        <div>
            <div style="font-size:0.875rem;font-weight:700;color:#fff;" class="brand-text">GP Admin</div>
            <div style="font-size:0.7rem;color:rgba(0,191,197,.7);">{{ session('gp_name') }}</div>
        </div>
    </div>

    {{-- Nav --}}
    <nav id="sidebar-scroll" class="flex-1 overflow-y-auto py-3 px-3 space-y-0.5">

        @php
        $navLink = 'nav-link flex items-center gap-3 px-3 py-2 rounded-lg text-xs font-medium transition-all duration-150 cursor-pointer';
        @endphp

        {{-- DASHBOARD --}}
        <a href="{{ route('gpadmin.dashboard-gp') }}"
           class="{{ $navLink }} nav-g-dash {{ request()->routeIs('gpadmin.dashboard-gp') ? 'nav-item-active' : '' }}">
            <i class="mdi mdi-view-dashboard-outline text-sm w-4 text-center"></i>
            <span class="nav-label">Dashboard</span>
        </a>

        <div class="nav-divider"></div>

        {{-- WEBSITE --}}
        <span class="nav-cap-label">Website</span>

        <a href="{{ route('gpadmin.welcome-note.list') }}"
           class="{{ $navLink }} nav-g-web {{ request()->routeIs('gpadmin.welcome-note.*') ? 'nav-item-active' : '' }}">
            <i class="mdi mdi-hand-wave-outline text-sm w-4 text-center"></i>
            <span class="nav-label">Welcome Note</span>
        </a>

        <a href="{{ route('gpadmin.navbar.list') }}"
           class="{{ $navLink }} nav-g-web {{ request()->routeIs('gpadmin.navbar.*') ? 'nav-item-active' : '' }}">
            <i class="mdi mdi-navigation-outline text-sm w-4 text-center"></i>
            <span class="nav-label">Navbar</span>
        </a>

        <a href="{{ route('gpadmin.slider.list') }}"
           class="{{ $navLink }} nav-g-web {{ request()->routeIs('gpadmin.slider.*') ? 'nav-item-active' : '' }}">
            <i class="mdi mdi-view-carousel-outline text-sm w-4 text-center"></i>
            <span class="nav-label">Slider</span>
        </a>

        <a href="{{ route('gpadmin.marquee.list') }}"
           class="{{ $navLink }} nav-g-web {{ request()->routeIs('gpadmin.marquee.*') ? 'nav-item-active' : '' }}">
            <i class="mdi mdi-bullhorn-outline text-sm w-4 text-center"></i>
            <span class="nav-label">Marquee</span>
        </a>

        <div class="nav-divider"></div>

        {{-- GALLERY --}}
        <span class="nav-cap-label">Gallery</span>

        <a href="{{ route('gpadmin.gallary.list') }}"
           class="{{ $navLink }} nav-g-gal {{ request()->routeIs('gpadmin.gallary.*') ? 'nav-item-active' : '' }}">
            <i class="mdi mdi-image-multiple-outline text-sm w-4 text-center"></i>
            <span class="nav-label">Gallery</span>
        </a>

        <a href="{{ route('gpadmin.pdfupload.list') }}"
           class="{{ $navLink }} nav-g-gal {{ request()->routeIs('gpadmin.pdfupload.*') ? 'nav-item-active' : '' }}">
            <i class="mdi mdi-file-pdf-box text-sm w-4 text-center"></i>
            <span class="nav-label">PDF Upload</span>
        </a>

        <div class="nav-divider"></div>

        {{-- PEOPLE --}}
        <span class="nav-cap-label">People</span>

        <a href="{{ route('gpadmin.officers.list') }}"
           class="{{ $navLink }} nav-g-ppl {{ request()->routeIs('gpadmin.officers.*') ? 'nav-item-active' : '' }}">
            <i class="mdi mdi-account-group-outline text-sm w-4 text-center"></i>
            <span class="nav-label">Officers</span>
        </a>

        <a href="{{ route('gpadmin.famous-locations.list') }}"
           class="{{ $navLink }} nav-g-ppl {{ request()->routeIs('gpadmin.famous-locations.*') ? 'nav-item-active' : '' }}">
            <i class="mdi mdi-map-marker-outline text-sm w-4 text-center"></i>
            <span class="nav-label">Famous Locations</span>
        </a>

        <div class="nav-divider"></div>

        {{-- SCHEMES --}}
        <span class="nav-cap-label">Schemes</span>

        <a href="{{ route('gpadmin.yojna.list') }}"
           class="{{ $navLink }} nav-g-sch {{ request()->routeIs('gpadmin.yojna.*') ? 'nav-item-active' : '' }}">
            <i class="mdi mdi-clipboard-list-outline text-sm w-4 text-center"></i>
            <span class="nav-label">Yojana</span>
        </a>

        <a href="{{ route('gpadmin.abhiyan.list') }}"
           class="{{ $navLink }} nav-g-sch {{ request()->routeIs('gpadmin.abhiyan.*') ? 'nav-item-active' : '' }}">
            <i class="mdi mdi-flag-outline text-sm w-4 text-center"></i>
            <span class="nav-label">Abhiyan</span>
        </a>

        <div class="nav-divider"></div>

        {{-- TAX --}}
        <span class="nav-cap-label">कर व्यवस्थापन</span>

        <a href="{{ route('gpadmin.gp-tax.demands.index') }}"
           class="{{ $navLink }} nav-g-tax {{ request()->routeIs('gpadmin.gp-tax.demands.*') ? 'nav-item-active' : '' }}">
            <i class="mdi mdi-currency-inr text-sm w-4 text-center"></i>
            <span class="nav-label">कर मागणी</span>
        </a>

        <a href="{{ route('gpadmin.gp-tax.documents.index') }}"
           class="{{ $navLink }} nav-g-tax {{ request()->routeIs('gpadmin.gp-tax.documents.*') ? 'nav-item-active' : '' }}">
            <i class="mdi mdi-file-document-outline text-sm w-4 text-center"></i>
            <span class="nav-label">कर कागदपत्रे</span>
        </a>

        <a href="{{ route('gpadmin.gp-tax.tips.index') }}"
           class="{{ $navLink }} nav-g-tax {{ request()->routeIs('gpadmin.gp-tax.tips.*') ? 'nav-item-active' : '' }}">
            <i class="mdi mdi-lightbulb-outline text-sm w-4 text-center"></i>
            <span class="nav-label">कर टीप</span>
        </a>

        <div class="nav-divider"></div>

        {{-- REQUESTS --}}
        <span class="nav-cap-label">Requests</span>

        <a href="{{ route('gpadmin.dakhala.list') }}"
           class="{{ $navLink }} nav-g-req {{ request()->routeIs('gpadmin.dakhala.*') ? 'nav-item-active' : '' }}">
            <i class="mdi mdi-file-document-edit-outline text-sm w-4 text-center"></i>
            <span class="nav-label">Dakhala</span>
        </a>

        <a href="{{ route('gpadmin.contact.list') }}"
           class="{{ $navLink }} nav-g-req {{ request()->routeIs('gpadmin.contact.*') ? 'nav-item-active' : '' }}">
            <i class="mdi mdi-email-outline text-sm w-4 text-center"></i>
            <span class="nav-label">Contact Us</span>
        </a>

        <div class="nav-divider"></div>

        {{-- ACCOUNT --}}
        <span class="nav-cap-label">Account</span>

        <a href="{{ route('gpadmin.change-password') }}"
           class="{{ $navLink }} nav-g-acc {{ request()->routeIs('gpadmin.change-password') ? 'nav-item-active' : '' }}">
            <i class="mdi mdi-lock-reset text-sm w-4 text-center"></i>
            <span class="nav-label">Change Password</span>
        </a>

        <a href="{{ route('gpadmin.logout') }}"
           class="{{ $navLink }} nav-g-acc">
            <i class="mdi mdi-logout text-sm w-4 text-center"></i>
            <span class="nav-label">Logout</span>
        </a>

        <div class="h-6"></div>
    </nav>
</aside>

{{-- ══════════════════════════════════════════════
     MAIN AREA (topbar + content)
     ══════════════════════════════════════════════ --}}
<div id="page-main" class="flex flex-col min-h-screen">

    {{-- TOPBAR --}}
    <header id="topbar"
        class="fixed top-0 right-0 z-20 flex items-center justify-between px-6 bg-white"
        style="left:256px; height:56px; border-bottom:1px solid #E5E9F1; transition:left .25s; box-shadow:0 1px 2px rgba(0,0,0,.04);">

        {{-- Left: hamburger + title --}}
        <div class="flex items-center gap-4">
            <button onclick="toggleSidebar()"
                class="p-2 rounded-xl text-gray-500 hover:bg-gray-100 transition-colors md:hidden">
                <i class="mdi mdi-menu text-xl"></i>
            </button>
            <button onclick="toggleSidebarDesktop()" id="desktop-toggle"
                class="hidden md:flex p-2 rounded-xl text-gray-500 hover:bg-gray-100 transition-colors">
                <i class="mdi mdi-menu text-xl"></i>
            </button>
            <div>
                <h1 class="text-base font-semibold" style="color:#111827;">
                    @yield('title', 'Dashboard')
                </h1>
            </div>
        </div>

        {{-- Right: email + avatar dropdown --}}
        <div class="flex items-center gap-3">

            {{-- Email badge --}}
            <div class="hidden md:flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-medium border"
                 style="background:rgba(0,191,197,.08); color:#0D3D47; border-color:rgba(0,191,197,.25);">
                <i class="mdi mdi-account-circle-outline text-sm" style="color:#00BFC5;"></i>
                <span>{{ session('email_id') }} {{ session('gp_name') }}</span>
            </div>

            {{-- Profile dropdown --}}
            <div class="relative">
                <button onclick="toggleProfile()"
                    class="flex items-center gap-2 p-1.5 rounded-xl hover:bg-gray-100 transition-colors">
                    <div class="w-8 h-8 rounded-xl overflow-hidden"
                         style="background:linear-gradient(135deg,#0F5C7B,#00BFC5);">
                        <img src="{{ asset('asset/default.jpg') }}" alt="Profile"
                             class="w-full h-full object-cover">
                    </div>
                    <i class="mdi mdi-chevron-down text-gray-400 text-sm hidden md:block"></i>
                </button>

                {{-- Dropdown --}}
                <div id="profile-menu"
                     class="absolute right-0 mt-2 w-52 bg-white rounded-2xl border py-1.5 z-50"
                     style="border-color:#E5E7EB; box-shadow:0 8px 30px rgba(0,0,0,.10); top:100%;">

                    <div class="px-4 py-2.5 border-b" style="border-color:#F3F4F6;">
                        <p class="text-xs font-semibold" style="color:#111827;">GP Admin</p>
                        <p class="text-xs truncate" style="color:#6B7280;">{{ session('email_id') }}</p>
                    </div>

                    <a href="{{ route('gpadmin.change-password') }}"
                       class="flex items-center gap-2.5 px-4 py-2 text-sm transition-colors"
                       style="color:#374151;"
                       onmouseover="this.style.background='rgba(0,191,197,.08)'"
                       onmouseout="this.style.background=''">
                        <i class="mdi mdi-lock-reset text-base" style="color:#0F5C7B;"></i>
                        Change Password
                    </a>

                    <div class="my-1 border-t" style="border-color:#F3F4F6;"></div>

                    <a href="{{ route('gpadmin.logout') }}"
                       class="flex items-center gap-2.5 px-4 py-2 text-sm transition-colors hover:bg-red-50"
                       style="color:#374151;">
                        <i class="mdi mdi-logout text-base" style="color:#EF4444;"></i>
                        Logout
                    </a>
                </div>
            </div>
        </div>
    </header>

    {{-- PAGE BODY --}}
    <div id="page-body" class="flex-1 p-6">

        @yield('content')
        @include('toast')
        @include('gpadmin.layout.footer')

