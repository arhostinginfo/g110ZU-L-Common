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
    <style>
        :root {
            --primary: #006699;
            --accent: #f0ad4e;
            --bg: #f6f8fb;
            --card: #fff;
            --text: #222;
            --muted: #6c757d;
            --radius: .6rem;
            --container-max: 1100px;
            font-family: "Poppins", "Noto Sans Devanagari", sans-serif;
        }

        html {
            font-size: 16px;
        }

        body {
            background: var(--bg);
            color: var(--text);
            margin: 0;
            transition: background .25s, color .25s;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        /* Utility bar */




        .utility-bar {

            padding: 6px 12px;
            z-index: 10;


            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            /* helps on small screens */
            gap: 10px;
            background: #eee;
        }

        header {
            margin: 20px !important;
            margin-bottom: 0px !important;
            margin-top: 0px !important;
        }

        .newheader {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            /* helps on small screens */
            gap: 10px;

        }

        /* Equal image sizing */
        .header-icon {
            width: 45px;
            height: 75px;
            object-fit: cover;
        }

        .header-icon-gp {
            width: 55px;
            height: 55px;
            object-fit: cover;
        }

        /* Text styles */
        .site-title {
            font-size: 1.1rem;
            line-height: 1.2;
        }

        /* RESPONSIVE BREAKPOINTS */

        /* Medium devices (tablets, <= 768px) */
        @media (max-width: 768px) {
            .header-icon {
                width: 25px;
                height: 45px;
            }

            .site-title {
                font-size: 1rem;
            }

            .newheader {
                padding: 0.5rem 0;
            }
        }

        /* Small devices (mobiles, <= 576px) */
        @media (max-width: 576px) {
            .newheader {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .utility-bar-left,
            .utility-bar-right {
                margin: 5px 0;
            }

            .header-icon {
                width: 25px;
                height: 40px;
            }

            .site-title {
                font-size: 0.95rem;
            }
        }


        .color-picker {
            display: none;
            position: fixed;
            top: 50px;
            right: 20px;
            z-index: 9999;
        }

        /* Navbar */
        .navbar {
            background: linear-gradient(90deg, #004466, var(--primary));
            z-index: 5;
        }

        .navbar .navbar-brand {
            color: #fff;
            font-weight: 600;
        }

        .navbar-brand span {
            white-space: normal;
            text-align: center;
            font-size: 0.95rem;
        }

        .navbar .nav-link {
            color: #fff;
            font-weight: 600;
            margin-left: 8px;
        }

        .navbar .nav-link:hover {
            text-decoration: underline;
            color: #fff;
        }

        /* Page container */
        .page-container {
            max-width: var(--container-max);
            margin: 20px auto;
            padding: 0 16px;
        }

        /* Carousel */
        .carousel {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.15);
        }

        .carousel-inner img {
            width: 100%;
            height: 360px;
            object-fit: cover;
            display: block;
        }

        @media (max-width: 768px) {
            .carousel-inner img {
                height: 220px;
            }



        }

        /* Marquee */
        .marquee-wrap {
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.06);
        }

        .marquee {
            display: inline-block;
            white-space: nowrap;
            padding: 10px 0;
            animation: marquee 15s linear infinite;
        }

        @keyframes marquee {
            0% {
                transform: translateX(100%);
            }

            100% {
                transform: translateX(-100%);
            }
        }

        /* Main cards */
        .card-section {
            background: var(--card);
            border-radius: 10px;
            padding: 16px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .section-title {
            font-size: 1.125rem;
            color: var(--primary);
            margin-bottom: 12px;
            font-weight: 600;
        }

        /* Video wrapper */
        .video-wrapper {
            position: relative;
            padding-bottom: 56.25%;
            height: 0;
            overflow: hidden;
            border-radius: 8px;
            background: #000;
        }

        .video-wrapper video,
        .video-wrapper iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        /* Places hover */
        .places img {
            border-radius: 8px;
            transition: transform .35s ease, box-shadow .35s ease;
            height: 188px;
            width: 318px;
        }

        .places img:hover {
            transform: scale(1.03);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
        }

        .place-card {
            border: 1px solid #e0e0e0;
            padding: 20px;
            border-radius: 10px;
            transition: transform 0.3s, box-shadow 0.3s;
            margin-bottom: 16px;
        }

        .place-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .place-card p {
            text-align: justify;
        }

        /* DataTables styling */
        .dataTables_wrapper .dataTables_filter input {
            border-radius: .6rem;
            border: 1px solid #ddd;
            padding: 6px 10px;
            width: 260px;
        }

        .dataTables_wrapper .dataTables_filter label {
            font-weight: 600;
            color: var(--muted);
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border-radius: .5rem;
            padding: 6px 10px;
            margin: 0 3px;
            background: transparent;
            border: 1px solid transparent;
            color: var(--text);
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: var(--primary);
            color: #fff !important;
            border-color: rgba(0, 0, 0, 0.05);
            box-shadow: 0 4px 10px rgba(2, 6, 23, 0.12);
        }

        table.dataTable thead th {
            background: var(--primary);
            color: #fff;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        }


        .accordion-button:not(.collapsed) {
            color: var(--bs-accordion-active-color);
            background-color: var(--primary);
            box-shadow: inset 0 calc(-1 * var(--bs-accordion-border-width)) 0 var(--bs-accordion-border-color);
        }


        /* Back to top */
        #backToTop {
            display: none;
            position: fixed;
            bottom: 5%;
            right: 5%;
            z-index: 9999;
            background: var(--primary);
            color: #fff;
            border: none;
            padding: 0.7rem;
            border-radius: 50%;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.18);
            font-size: 1.2rem;
            cursor: pointer;
            transition: background 0.3s, transform 0.3s;
        }

        #backToTop:hover {
            background: color-mix(in srgb, var(--primary) 80%, black);
            transform: scale(1.1);
        }

        /* Smaller screens adjustments */
        @media (max-width: 576px) {
            #backToTop {
                bottom: 5%;
                right: 5%;
                padding: 0.6rem;
                font-size: 1rem;
            }
        }

        /* Dark mode tweaks */
        body.dark {
            --bg: #121212;
            --card: #1e1e1e;
            --text: #e6e6e6;
            --muted: #9aa0a6;
        }

        body.dark table.dataTable thead th {
            background: linear-gradient(90deg, #0b3e52, #00475f);
        }

        @media (max-width: 576px) {
            .dataTables_wrapper .dataTables_filter input {
                width: 100%;
                margin-top: 6px;
            }

            .page-container {
                padding: 0 10px;
            }
        }

        /* Footer */
        footer {
            background: linear-gradient(90deg, #004466, var(--primary));
            color: #fff;
            padding: 2rem 1rem;
            border-top: 4px solid #00334d;
        }

        footer a {
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: none;
        }
    </style>
    <style>
        /* Remove default blue background for expanded accordion */
        .accordion-button {
            background-color: transparent;
            /* keep original background */
            color: #000;
            /* text color */
            /*font-weight: bold;*/
            /*font-size: 1.1rem;*/
            padding: 0.5rem 1rem;
        }

        /* Remove the default blue focus outline */
        .accordion-button:focus {
            box-shadow: none;
        }

        /* Keep plus/minus icons optional */
        .accordion-button::after {
            filter: invert(0);
            /* optional: keep default arrow color black */
        }
    </style>
    <style>
        .table-responsive {
            width: 100%;
            overflow-x: auto;
            /* enables horizontal scroll on small screens */
            -webkit-overflow-scrolling: touch;
            /* smooth scrolling on iOS */
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 600px;
            /* optional, ensures table doesn’t shrink too much */
        }

        .data-table th,
        .data-table td {
            padding: 0.5rem 1rem;
            text-align: left;
            border: 1px solid #ddd;
        }

        .data-table th {
            background-color: #f2f2f2;
        }

        /* Optional: zebra stripes for readability */
        .data-table tr:nth-child(even) {
            background-color: #fafafa;
        }

        .galarysetting {
            height: 150px;
            width: 237px;
        }
    </style>
    <style>
        .one_rem {
            font-size: 1rem;
        }
    </style>
</head>

<div class="utility-bar">
    <div class="utility-bar-left">
        <div class="d-flex align-items-center">
            <div class="flex space-x-2 items-center mb-1 sm:mb-0">
                <span id="gov-label" data-key="govLabel" class="font-semibold text-[0.85rem] mr-marathi">Government of
                    Maharashtra</span>
                <span class="text-xs text-[#647064] hidden sm:inline">|</span>
                <span id="gov-label-en" data-key="govLabelEn" class="font-semibold  text-[0.85rem]">MAHARASHTRA
                    STATE</span>
            </div>
        </div>
    </div>


    <div class="utility-bar-right">
        <div class="d-flex align-items-center">
            <div class="utility-bar">
                <button id="increaseFont" class="btn btn-sm btn-outline-secondary">A+</button>
                <button id="resetFont" class="btn btn-sm btn-outline-secondary">A</button>
                <button id="decreaseFont" class="btn btn-sm btn-outline-secondary">A-</button>
                <!-- Language Toggle -->
                <button id="lang-toggle"
                    class="px-2 py-0.5 rounded-md font-bold bg-yellow-400 text-black hover:bg-yellow-500">मराठी</button>
                <span class="theme-toggle ms-2" role="button" title="Dark / Light" onclick="toggleDark()">🌙</span>
            </div>
        </div>
    </div>
</div>

<header class="bg-white shadow py-2 px-3">
    <div class="newheader">
        <!-- Left Side -->
        <div class="utility-bar-left">
            <div class="d-flex align-items-center">
                <div class="d-flex flex-column align-items-center me-3">
                    <img src="{{ asset('asset/dummy_images/gov.svg') }}" alt="Maharashtra emblem" class="header-icon">
                    <p class="text-xs mt-1 font-bold mr-marathi select-none mb-0" style="font-size: 0.8rem;"
                        data-key="motto">सत्यमेव जयते</p>
                </div>
                <div>
                    <h1 class="mb-0 font-bold mr-marathi site-title" data-key="siteTitle">
                        {{ $navbar->name ?? 'ग्रामपंचायत' }}
                    </h1>
                </div>
            </div>
        </div>

        <!-- Right Side -->
        <div class="utility-bar-right d-flex align-items-center">
            <div class="d-flex flex-column align-items-center">
                @if(!empty($navbar->logo) && file_exists(storage_path('app/public/' . $navbar->logo)))
                    <img src="{{ asset('storage/' . ($navbar->logo ?? 'default.jpg')) }}"
                        alt="{{ $navbar->name ?? 'Default_Logo' }}" class="header-icon-gp rounded-circle" />
                @else
                    <img src="{{ asset('asset/dummy_images/person.jpg') }}" alt="ग्रामपंचायत"
                        class="header-icon-gp rounded-circle" />
                @endif
            </div>
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
                    <li class="nav-item"><a class="nav-link" href="#news">अभियान</a></li>
                    <li class="nav-item"><a class="nav-link" href="#schemes">शासकीय योजना</a></li>
                    <li class="nav-item"><a class="nav-link" href="#places">प्रसिद्ध स्थळे</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">संपर्क</a></li>
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')
    @include('website.layout.footer')
