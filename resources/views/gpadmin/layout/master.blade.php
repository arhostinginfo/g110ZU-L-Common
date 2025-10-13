<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="">
    <meta name="author" content="">
   
    <title>Admin Login</title>
    <link href="{{ asset('asset/css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@7.2.96/css/materialdesignicons.min.css">



    <link href="{{ asset('asset/css/colors/blue.css') }}" id="theme" rel="stylesheet">
    <link href="{{ asset('asset/css/master.css') }}" id="theme" rel="stylesheet">
    <script src="{{ asset('asset/plugins/jquery/jquery-3.6.0.min.js') }}"></script>
</head>

<body class="fix-header fix-sidebar card-no-border">
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2"
                stroke-miterlimit="10" />
        </svg>
    </div>
    <div id="main-wrapper">
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <div class="navbar-header">
                    <a class="navbar-brand" href="">

                        <span>
                            <img src="{{ asset('asset/default.jpg') }}" class="light-logo" alt="homepage"
                                style="    height: 50px;" /></span>
                    </a>
                </div>
                <div class="navbar-collapse">
                    <ul class="navbar-nav mr-auto mt-md-0">
                        <li class="nav-item"> <a
                                class="nav-link nav-toggler d-block d-md-none text-muted waves-effect waves-dark"
                                href="javascript:void(0)"><i class="mdi mdi-menu"></i></a> </li>
                        <li class="nav-item"> <a
                                class="nav-link sidebartoggler d-none d-md-block text-muted waves-effect waves-dark"
                                href="javascript:void(0)"><i class="ti-menu"></i></a> </li>


                    </ul>
                    <ul class="navbar-nav my-lg-0 d-flex justify-content-center align-items-center">
                        <li class="fnt-size">{{ session('email_id') }}</li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="#"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img
                                    src="{{ asset('asset/default.jpg') }}"" alt="user" class="profile-pic" /></a>
                            <div class="dropdown-menu dropdown-menu-right scale-up">
                                <ul class="dropdown-user">
                                    <li><a href="{{ route('gpadmin.change-password') }}"><i class="fa fa-key"></i> Change
                                            password</a></li>
                                    <li><a href="{{ route('gpadmin.logout') }}"><i class="fa fa-power-off"></i> Logout</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="#"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i></i></a>
                            <div class="dropdown-menu dropdown-menu-right scale-up"> <a class="dropdown-item"
                                    href="#"><i class="flag-icon flag-icon-in"></i> India</a> <a
                                    class="dropdown-item" href="#"><i class="flag-icon flag-icon-fr"></i>
                                    French</a> <a class="dropdown-item" href="#"><i
                                        class="flag-icon flag-icon-cn"></i> China</a> <a class="dropdown-item"
                                    href="#"><i class="flag-icon flag-icon-de"></i> Dutch</a> </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <aside class="left-sidebar">
            <div class="scroll-sidebar">
                <div class="user-profile" style="margin-top: 28px;"></div>
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">

                        <li> <a href="{{ route('gpadmin.dashboard-gp') }}"> <i class="mdi mdi-view-dashboard"></i><span>Dashboard
                                </span></a>
                        </li>

                        <li> <a href="{{ route('gpadmin.welcome-note.list') }}"> <i
                                    class="mdi mdi-view-dashboard"></i><span>Welcome Note
                                </span></a>
                        </li>

                        <li> <a href="{{ route('gpadmin.navbar.list') }}"> <i class="mdi mdi-view-dashboard"></i><span>Navbar
                                </span></a>
                        </li>

                        <li> <a href="{{ route('gpadmin.slider.list') }}"> <i class="mdi mdi-view-dashboard"></i><span>Slider
                                </span></a>
                        </li>

                        <li> <a href="{{ route('gpadmin.gallary.list') }}"> <i
                                    class="mdi mdi-view-dashboard"></i><span>Gallary
                                </span></a>
                        </li>

                        <li> <a href="{{ route('gpadmin.officers.list') }}"> <i
                                    class="mdi mdi-view-dashboard"></i><span>officers
                                </span></a>
                        </li>

                        <li> <a href="{{ route('gpadmin.famous-locations.list') }}"> <i
                                    class="mdi mdi-view-dashboard"></i><span>Famous Locations
                                </span></a>
                        </li>

                        <li> <a href="{{ route('gpadmin.marquee.list') }}"><i class="mdi mdi-account-key"></i><span>
                                    Marquee</span></a>
                        </li>


                        <li> <a href="{{ route('gpadmin.yojna.list') }}"> <i class="mdi mdi-view-dashboard"></i><span>Yojana
                                </span></a>
                        </li>


                        <li> <a href="{{ route('gpadmin.abhiyan.list') }}"> <i
                                    class="mdi mdi-view-dashboard"></i><span>Abhiyan
                                </span></a>
                        </li>




                        <li> <a href="{{ route('gpadmin.logout') }}"> <i class="mdi mdi-account-group"></i><span>Logout
                                </span></a>
                        </li>

                    </ul>
                </nav>






            </div>

        </aside>
        <div class="page-wrapper">
            <div class="container-fluid">
                <div class="row page-titles">
                    <div class="col-md-5 col-12 align-self-right ">
                        <?php
                        // <ol class="breadcrumb">
                        //   <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        //   <li class="breadcrumb-item active">Icon</li>
                        // </ol>
                        ?>
                    </div>

                </div>

                @yield('content')
                @include('toast')
                @include('gpadmin.layout.footer')
