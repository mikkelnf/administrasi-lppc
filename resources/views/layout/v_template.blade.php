<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title-window') | Administrasi LPPC</title>

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">    
    <!-- Custom CSS -->
    @yield('css')
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
    
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
    rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined"
    rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round"
    rel="stylesheet">

    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
    
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">

    <link href = “https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css” rel = “stylesheet”>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="apple-touch-icon" sizes="180x180" href="{{ url('favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ url('favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ url('favicon/favicon-16x16.png') }}">
</head>

<body>

    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar" class="bg-light" style="border-right: 1px solid rgba(0, 0, 0, 0.22);">
            <div class="sidebar-heading">
                <a href="/">
                    <img src="{{ asset('img') }}/logolppc.png" style="width:129px; height:35px;">
                </a>
            </div>
            @include('layout.v_sidebarmenu')
        </nav>

        <!-- Page Content  -->
        <div id="content">
            <nav class="navbar navbar-expand-lg navbar-light bg-light navbar-custom sticky-top">
                <div class="container-fluid">
                    <a role="button" id="sidebarCollapse" class="toggleicon">
                        <img  src="{{ asset('img') }}/round_menu_white_48dp.png"  width="30" height= "30">
                    </a>
                    <a id="nav-header" class="nav-header">
                        @yield('title')
                    </a>
                    <a class="username align-items-end" id="username">
                        {{ Auth::user()->nama_user }}
                        <span class="vertical-line"></span>
                    </a>
                    <div class="nav-item dropdown">
                        <a class="nav-link" href="#" style="padding-right: 0px;" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="img-custom"  src="{{ asset('img') }}/round_account_circle_white_36dp.png"  width="40" height= "40">
                            <img src="{{ asset('img') }}/arrow.png" style="margin-left:17px; -webkit-filter: grayscale(1) invert(1)" width="26" height= "26">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="/akun/profil">
                                <span class="material-icons-outlined">
                                person
                                </span>
                                Akun
                            </a>
                            @if(auth()->user()->id_role == 0 | auth()->user()->id_role == 1)
                                <a class="dropdown-item" href="/pengaturan">
                                    <span class="material-icons-outlined">
                                    settings
                                    </span>
                                    Pengaturan
                                </a>
                            @endif
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('logout') }}">
                                <span class="material-icons-outlined">
                                logout
                                </span>
                                Keluar
                            </a>
                        </div>
                    </div>
                </div>
            </nav>

            <div class="page-content">
                @yield('content')
            </div>

        </div>
        <div class="overlay"></div>
    </div>

    <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    <!-- jQuery Custom Scroller CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>

    @yield('js')

</body>
</html>
