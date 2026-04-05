<!doctype html>
<html lang="mr">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" type="image/png" href="{{ asset('storage/' . ($navbar->logo ?? 'default.jpg')) }}">

    <title>{{ $navbar->name ?? 'Website Name' }}</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- DataTables CSS & JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Devanagari:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #006699;
            --primary-dark: #004d73;
            --accent: #f0ad4e;
            --bg: #f0f4f8;
            --card: #fff;
            --text: #1a1a2e;
            --muted: #6c757d;
            --border: #e2e8f0;
            --radius: .75rem;
            --shadow: 0 4px 20px rgba(0,0,0,0.08);
            --container-max: 1140px;
        }

        /* ── Font scale ── */
        --fs-xs:   0.75rem;   /* 12px  — captions, badges       */
        --fs-sm:   0.85rem;   /* 13.6px — small labels, meta     */
        --fs-base: 0.9375rem; /* 15px  — body copy               */
        --fs-md:   1rem;      /* 16px  — slightly larger body    */
        --fs-lg:   1.125rem;  /* 18px  — card subtitles          */
        --fs-xl:   1.3rem;    /* 20.8px — section titles         */
        --fs-2xl:  1.55rem;   /* 24.8px — page headings          */
        --lh-body: 1.85;      /* generous for Devanagari         */
        --lh-head: 1.35;

        html { font-size: 16px; scroll-behavior: smooth; }

        body {
            background: var(--bg);
            color: var(--text);
            margin: 0;
            /* Devanagari first so Marathi glyphs use the right font */
            font-family: "Noto Sans Devanagari", "Poppins", sans-serif;
            font-size: var(--fs-base);
            line-height: var(--lh-body);
            font-weight: 400;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Headings — use Poppins for Latin, Noto for Devanagari */
        h1, h2, h3, h4, h5, h6 {
            font-family: "Noto Sans Devanagari", "Poppins", sans-serif;
            line-height: var(--lh-head);
            font-weight: 700;
            color: var(--text);
            margin-bottom: 0.5em;
        }

        h1 { font-size: var(--fs-2xl); }
        h2 { font-size: 1.4rem;        }
        h3 { font-size: var(--fs-xl);  }
        h4 { font-size: var(--fs-lg);  }
        h5 { font-size: var(--fs-md);  font-weight: 600; }
        h6 { font-size: var(--fs-base); font-weight: 600; }

        p  { font-size: var(--fs-base); line-height: var(--lh-body); margin-bottom: 0.75em; }
        li { font-size: var(--fs-base); line-height: var(--lh-body); }
        small, .text-sm { font-size: var(--fs-sm); }
        .text-xs        { font-size: var(--fs-xs); }

        strong, b { font-weight: 600; }

        a { text-decoration: none; color: inherit; }

        /* ── Utility Bar ── */
        .utility-bar {
            background: linear-gradient(90deg, var(--primary-dark), var(--primary));
            padding: 5px 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 8px;
        }

        .utility-bar span,
        .utility-bar button,
        .utility-bar .theme-toggle {
            color: rgba(255,255,255,0.9) !important;
            font-size: 0.8rem;
        }

        .utility-bar .btn-outline-secondary {
            border-color: rgba(255,255,255,0.4);
            color: #fff !important;
            padding: 1px 8px;
            font-size: 0.78rem;
        }

        .utility-bar .btn-outline-secondary:hover {
            background: rgba(255,255,255,0.15);
        }

        /* ── Header ── */
        header {
            background: #fff;
            border-bottom: 3px solid var(--primary);
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            padding: 12px 20px;
            margin: 0 !important;
        }

        .newheader {
            max-width: var(--container-max);
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
        }

        .header-icon {
            width: 48px;
            height: 76px;
            object-fit: contain;
        }

        .header-icon-gp {
            width: 64px;
            height: 64px;
            object-fit: cover;
            border: 3px solid var(--primary);
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }

        .site-title {
            font-size: var(--fs-xl);
            font-weight: 700;
            color: var(--primary);
            line-height: 1.3;
        }

        .site-subtitle {
            font-size: var(--fs-sm);
            color: var(--muted);
            font-weight: 400;
            margin-top: 2px;
        }

        /* ── Navbar ── */
        .navbar {
            background: linear-gradient(90deg, var(--primary-dark), var(--primary)) !important;
            box-shadow: 0 3px 10px rgba(0,0,0,0.2);
            padding: 0 20px;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar .nav-link {
            color: rgba(255,255,255,0.9) !important;
            font-weight: 500;
            font-size: var(--fs-sm);
            letter-spacing: 0.01em;
            padding: 14px 12px !important;
            position: relative;
            transition: color 0.2s;
        }

        .navbar .nav-link::after {
            content: ‘’;
            position: absolute;
            bottom: 0; left: 50%; right: 50%;
            height: 3px;
            background: var(--accent);
            transition: left 0.25s, right 0.25s;
            border-radius: 2px 2px 0 0;
        }

        .navbar .nav-link:hover { color: #fff !important; }
        .navbar .nav-link:hover::after { left: 8px; right: 8px; }

        /* ── Page container ── */
        .page-container {
            max-width: var(--container-max);
            margin: 24px auto;
            padding: 0 16px;
        }

        /* ── Carousel ── */
        .carousel {
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        .carousel-inner img {
            width: 100%;
            height: 400px;
            object-fit: cover;
            display: block;
        }

        .carousel-caption-custom {
            position: absolute;
            bottom: 0; left: 0; right: 0;
            background: linear-gradient(transparent, rgba(0,0,0,0.55));
            padding: 24px 20px 16px;
            color: #fff;
        }

        @media (max-width: 768px) {
            .carousel-inner img { height: 220px; }
        }

        /* ── Marquee ── */
        .marquee-wrap {
            background: linear-gradient(90deg, var(--primary-dark), var(--primary));
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: var(--shadow);
            color: #fff;
        }

        .marquee-wrap .fa-bullhorn { color: var(--accent); }
        .marquee-wrap .section-title { color: #fff; font-size: 0.9rem; }
        .marquee-wrap .btn-primary {
            background: rgba(255,255,255,0.2);
            border-color: rgba(255,255,255,0.3);
        }

        .marquee {
            display: inline-block;
            white-space: nowrap;
            padding: 8px 0;
            animation: marquee 20s linear infinite;
        }

        @keyframes marquee {
            0%   { transform: translateX(100%); }
            100% { transform: translateX(-100%); }
        }

        /* ── Card Sections ── */
        .card-section {
            background: var(--card);
            border-radius: var(--radius);
            padding: 24px 20px;
            margin-bottom: 24px;
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
            position: relative;
            overflow: hidden;
        }

        .card-section::before {
            content: ‘’;
            position: absolute;
            top: 0; left: 0;
            width: 4px;
            height: 100%;
            background: var(--primary);
            border-radius: var(--radius) 0 0 var(--radius);
        }

        /* ── Section Titles ── */
        .section-title {
            font-size: var(--fs-xl);
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 16px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--border);
            display: flex;
            align-items: center;
            gap: 8px;
            line-height: 1.4;
        }

        .section-title::before {
            content: ‘’;
            display: inline-block;
            width: 5px;
            height: 24px;
            background: var(--accent);
            border-radius: 3px;
            flex-shrink: 0;
        }

        /* ── Tables ── */
        .table-responsive {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            border-radius: calc(var(--radius) - 4px);
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 600px;
            font-size: var(--fs-base);
        }

        .data-table th, .data-table td {
            padding: 0.6rem 1rem;
            text-align: left;
            border: 1px solid var(--border);
            line-height: 1.6;
        }

        .data-table th {
            background: var(--primary);
            color: #fff;
            font-weight: 600;
            font-size: var(--fs-sm);
            letter-spacing: 0.02em;
        }

        .data-table tr:nth-child(even) { background: #f8fafc; }

        /* Bootstrap tables inside card-sections */
        .card-section .table th {
            font-size: var(--fs-sm);
            font-weight: 600;
            letter-spacing: 0.02em;
        }

        .card-section .table td {
            font-size: var(--fs-base);
            line-height: 1.65;
        }

        /* ── DataTables ── */
        .dataTables_wrapper { font-size: var(--fs-base); }

        .dataTables_wrapper .dataTables_filter input {
            border-radius: var(--radius);
            border: 1px solid var(--border);
            padding: 6px 12px;
            width: 240px;
            font-size: var(--fs-sm);
            font-family: inherit;
        }

        .dataTables_wrapper .dataTables_filter label,
        .dataTables_wrapper .dataTables_length label,
        .dataTables_wrapper .dataTables_info {
            font-size: var(--fs-sm);
            font-weight: 500;
            color: var(--muted);
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border-radius: .5rem;
            padding: 5px 10px;
            margin: 0 2px;
            background: transparent;
            border: 1px solid var(--border) !important;
            color: var(--text) !important;
            font-size: var(--fs-sm);
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: var(--primary) !important;
            color: #fff !important;
            border-color: var(--primary) !important;
        }

        table.dataTable thead th {
            background: var(--primary);
            color: #fff;
            font-weight: 600;
            font-size: var(--fs-sm);
            letter-spacing: 0.02em;
        }

        table.dataTable tbody td {
            font-size: var(--fs-base);
            line-height: 1.7;
        }

        /* ── Accordion ── */
        .accordion-button {
            background-color: transparent;
            color: var(--text);
            padding: 0.6rem 1rem;
            font-weight: 500;
        }

        .accordion-button:focus { box-shadow: none; }

        .accordion-button:not(.collapsed) {
            background: var(--primary);
            color: #fff;
            box-shadow: none;
        }

        .accordion-button:not(.collapsed)::after { filter: invert(1); }

        /* ── Places ── */
        .places img {
            border-radius: var(--radius);
            transition: transform .3s ease, box-shadow .3s ease;
            height: 188px;
            width: 318px;
        }

        .places img:hover {
            transform: scale(1.04);
            box-shadow: 0 10px 28px rgba(0,0,0,0.14);
        }

        .place-card {
            border: 1px solid var(--border);
            padding: 20px;
            border-radius: var(--radius);
            transition: transform 0.3s, box-shadow 0.3s;
            margin-bottom: 16px;
            background: var(--card);
        }

        .place-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.10);
        }

        .place-card p { text-align: justify; }

        /* ── Gallery ── */
        .galarysetting {
            height: 150px;
            width: 237px;
            object-fit: cover;
            border-radius: 8px;
            transition: transform 0.3s;
        }

        .galarysetting:hover { transform: scale(1.04); }

        /* ── Back to top ── */
        #backToTop {
            display: none;
            position: fixed;
            bottom: 24px; right: 24px;
            z-index: 9999;
            background: var(--primary);
            color: #fff;
            border: none;
            width: 44px; height: 44px;
            border-radius: 50%;
            box-shadow: 0 6px 20px rgba(0,0,0,0.22);
            font-size: 1.1rem;
            cursor: pointer;
            transition: background 0.25s, transform 0.25s;
        }

        #backToTop:hover {
            transform: translateY(-3px);
            filter: brightness(1.1);
        }

        /* ── Dark mode ── */
        body.dark {
            --bg: #0f172a;
            --card: #1e293b;
            --text: #e2e8f0;
            --muted: #94a3b8;
            --border: #334155;
        }

        body.dark table.dataTable thead th { background: var(--primary-dark); }

        /* ── Footer ── */
        footer {
            background: linear-gradient(135deg, var(--primary-dark), var(--primary));
            color: #fff;
            padding: 2.5rem 1rem 1.5rem;
            border-top: 4px solid var(--accent);
            margin-top: 32px;
        }

        footer h5 {
            font-weight: 700;
            border-bottom: 2px solid rgba(255,255,255,0.2);
            padding-bottom: 8px;
            margin-bottom: 12px;
        }

        footer a { color: rgba(255,255,255,0.8); transition: color 0.2s; }
        footer a:hover { color: #fff; }
        footer p { font-size: 0.88rem; line-height: 1.8; }

        /* ── Responsive font scaling ── */
        @media (max-width: 768px) {
            html { font-size: 15px; }
            .site-title   { font-size: var(--fs-lg); }
            .section-title { font-size: var(--fs-lg); }
            .header-icon  { width: 36px; height: 56px; }
            .header-icon-gp { width: 52px; height: 52px; }
        }

        @media (max-width: 576px) {
            html { font-size: 14px; }
            .newheader    { flex-direction: column; align-items: center; text-align: center; }
            .page-container { padding: 0 10px; }
            .card-section { padding: 16px 14px; }
            .section-title { font-size: var(--fs-md); }
            .dataTables_wrapper .dataTables_filter input { width: 100%; margin-top: 6px; }
        }

        .one_rem { font-size: var(--fs-md); }
        .color-picker { display: none; position: fixed; top: 50px; right: 20px; z-index: 9999; }
    </style>
</head>

{{-- Utility Bar --}}
<div class="utility-bar">
    <div class="utility-bar-left d-flex align-items-center gap-2">
        <span style="font-size:0.8rem; font-weight:600;">Government of Maharashtra</span>
        <span style="opacity:0.4;">|</span>
        <span style="font-size:0.8rem; font-weight:600; text-transform:capitalize;">Maharashtra State</span>
    </div>
    <div class="utility-bar-right d-flex align-items-center gap-1">
        <button id="increaseFont" class="btn btn-sm btn-outline-secondary">A+</button>
        <button id="resetFont"    class="btn btn-sm btn-outline-secondary">A</button>
        <button id="decreaseFont" class="btn btn-sm btn-outline-secondary">A-</button>
        <button id="lang-toggle" class="btn btn-sm ms-1" style="background:var(--accent);color:#000;font-weight:700;font-size:0.78rem;">मराठी</button>
        <span class="theme-toggle ms-2" role="button" title="Dark / Light" onclick="toggleDark()" style="cursor:pointer; font-size:1rem;">🌙</span>
    </div>
</div>

{{-- Header --}}
<header>
    <div class="newheader">
        {{-- Left: Emblem + Name --}}
        <div class="d-flex align-items-center gap-3">
            <div class="d-flex flex-column align-items-center">
                <img src="{{ asset('asset/dummy_images/gov.svg') }}" alt="Maharashtra emblem" class="header-icon">
                <p class="mb-0 mt-1" style="font-size:0.72rem; font-weight:700; color:var(--muted);">सत्यमेव जयते</p>
            </div>
            <div class="border-start ps-3" style="border-color: var(--border) !important;">
                <div class="site-title">{{ $navbar->name ?? 'ग्रामपंचायत' }}</div>
                <div class="site-subtitle">ग्रामपंचायत, महाराष्ट्र शासन</div>
            </div>
        </div>

        {{-- Right: GP Logo --}}
        <div class="d-flex align-items-center">
            @if(!empty($navbar->logo) && file_exists(storage_path('app/public/' . $navbar->logo)))
                <img src="{{ asset('storage/' . $navbar->logo) }}"
                     alt="{{ $navbar->name ?? 'GP Logo' }}"
                     class="header-icon-gp rounded-circle" />
            @else
                <img src="{{ asset('asset/dummy_images/person.jpg') }}"
                     alt="ग्रामपंचायत"
                     class="header-icon-gp rounded-circle" />
            @endif
        </div>
    </div>
</header>


<body>
    <!-- Utility bar
    <div class="utility-bar">
        <button id="increaseFont" class="btn btn-sm btn-outline-secondary">A+</button>
        <button id="resetFont" class="btn btn-sm btn-outline-secondary">A</button>
        <button id="decreaseFont" class="btn btn-sm btn-outline-secondary">A-</button>
        
    <span class="theme-toggle ms-2" role="button" title="Dark / Light" onclick="toggleDark()">🌙</span>
    </div>
    -->
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid justify-content-center" style="max-width:var(--container-max);">
           
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navmenu"
                aria-controls="navmenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navmenu">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#welcome">स्वागत</a></li>
                    <li class="nav-item"><a class="nav-link" href="#news">मुख्यमंत्री समृद्ध पंचायतराज अभियान</a></li>
                    <li class="nav-item"><a class="nav-link" href="#dakhala">दाखला</a></li>
                    <li class="nav-item"><a class="nav-link" href="#mahiti">माहिती</a></li>
                    <li class="nav-item"><a class="nav-link" href="#schemes">शासकीय योजना</a></li>
                    <li class="nav-item"><a class="nav-link" href="#places">प्रसिद्ध स्थळे</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">संपर्क</a></li>
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')
    @include('website.layout.footer')
