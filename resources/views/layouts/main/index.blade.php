<!DOCTYPE html>
<html lang="id" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>{{ $title }}</title>

    <meta name="description" content="{{ $app[0]->description_app }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="/medilab/assets/img/Logo_BNN.png" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/assets/vendor/fonts/boxicons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/assets/vendor/css/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/assets/vendor/css/theme.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/assets/css/demos.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('assets/vendors/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/assets/vendor/libs/apex-charts/apex-charts.css') }}" />
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <link rel="stylesheet" href="{{ asset('assets/vendors/assets/vendor/css/pages/page-misc.css') }}">
    <script src="{{ asset('assets/vendors/assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('assets/vendors/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/toast.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/libs/sweetalert2/sweetalert.css') }}">
    <script src="{{ asset('assets/vendors/libs/sweetalert2/sweetalert.js') }}"></script>
    <script src="{{ asset('assets/vendors/assets/js/config.js') }}"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        #map {
            height: 600px;
        }

        .info {
            padding: 6px 8px;
            font: 14px/16px Arial, Helvetica, sans-serif;
            background: white;
            background: rgba(255, 255, 255, 0.8);
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            border-radius: 5px;
        }

        .info h4 {
            margin: 0 0 5px;
            color: #777;
        }

        .legend {
            line-height: 18px;
            color: #555;
        }

        .legend i {
            width: 18px;
            height: 18px;
            float: left;
            margin-right: 8px;
            opacity: 0.7;
        }

        #floating-info {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
            padding: 15px;
            width: 320px;
            text-align: center;
        }

        .my-labels {
    font-size: 9px; /* Atur ukuran font sesuai keinginan */
    font-weight: normal;
    padding: 2px 4px;
    background: rgba(255, 255, 255, 0.8); /* Opsional: latar belakang */
    border-radius: 4px; /* Opsional: sudut melengkung */
    color: #333; /* Opsional: warna teks */
}
    </style>
</head>

<body>
    <style>
        @font-face {
            font-family: 'Boxicons';
            src: url('{{ asset('assets/vendors/assets/vendor/fonts/boxicons/boxicons.woff2') }}') format('woff2');
            font-display: swap;
        }

        ::-webkit-scrollbar {
            width: 5px;
            cursor: pointer;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #696cff !important;
            border-radius: 6px;
        }

        .card-body h2 {
            color: #040404;
        }
    </style>

    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container ">
            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    <a href="/" class="app-brand-link">
                        <span class="app-brand-logo demo">
                            <img src="/medilab/assets/img/bnn.png" alt="Logo" width="250" height="auto">

                        </span>

                    </a>
                    <a href="javascript:void(0);"
                        class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                        <i class="bx bx-chevron-left bx-sm align-middle"></i>
                    </a>
                </div>
                <div class="menu-inner-shadow"></div>
                <ul class="menu-inner py-1">
                    @include('partials.sidebar.index')
                </ul>
            </aside>

            <div class="layout-page">
                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                    id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="bx bx-menu bx-sm"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        <div class="navbar-nav">
                            <div class="nav-item d-flex d-none d-lg-block" style="margin-top: 1rem;">
                                @php
                                    $currentTime = now();
                                    $hour = $currentTime->hour;
                                    if ($hour >= 5 && $hour < 11) {
                                        $greeting = 'Selamat Pagi';
                                    } elseif ($hour >= 11 && $hour < 15) {
                                        $greeting = 'Selamat Siang';
                                    } elseif ($hour >= 15 && $hour < 18) {
                                        $greeting = 'Selamat Sore';
                                    } else {
                                        $greeting = 'Selamat Malam';
                                } @endphp<h5>{{ $greeting }},&nbsp;<strong>{{ auth()->user()->name }}
                                        @if (auth()->user()->is_admin)
                                            &nbsp;<i class='bx bxs-badge-check text-primary'
                                                style="font-size: 1rem; margin-bottom:2px;" data-bs-toggle="tooltip"
                                                data-popup="tooltip-custom" data-bs-placement="auto"
                                                title="Administrator"></i>
                                        @endif
                                    </strong>
                                </h5>
                            </div>
                        </div>
                        <ul class="navbar-nav flex-row ms-auto">
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <div class="avatar avatar-online">
                                        <img src="@if (Storage::disk('public')->exists('profil-images')) {{ asset('storage/' . auth()->user()->image) }} @else {{ asset('assets/img/profil-images-default/1.jpeg') }} @endif"
                                            alt="foto profil" class="w-px-40 h-auto rounded-circle" />
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <button class="dropdown-item">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar avatar-online">
                                                        <img src="@if (Storage::disk('public')->exists('profil-images')) {{ asset('storage/' . auth()->user()->image) }} @else {{ asset('assets/img/profil-images-default/man.jpeg') }} @endif"
                                                            alt="foto profil" class="w-px-40 h-auto rounded-circle" />
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <span class="fw-semibold d-block">{{ auth()->user()->name }}
                                                        @if (auth()->user()->is_admin)
                                                            &nbsp;<i class='bx bxs-badge-check fs-6 text-primary'
                                                                data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                                data-bs-placement="auto" title="Administrator"></i>
                                                        @endif
                                                    </span>
                                                    <small class="text-muted">
                                                        @if (auth()->user()->is_admin === 1)
                                                            {{ 'Admin' }}
                                                        @elseif(auth()->user()->is_admin === 2)
                                                            {{ 'Kepala BNN' }}
                                                        @else
                                                            {{ 'Masyarakat' }}
                                                        @endif
                                                    </small>
                                                </div>
                                            </div>
                                        </button>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <button type="button" class="dropdown-item"
                                            onclick="window.location.href='@if (auth()->user()->is_admin) /admin/pengaturan @else /pengaturan @endif'">
                                            <i class="bx bx-cog me-2"></i>
                                            <span class="align-middle">Pengaturan</span>
                                        </button>
                                    </li>
                                    <li>
                                        <form action="/logout" method="post">
                                            @csrf
                                            <button type="submit" class="dropdown-item">
                                                <i class="bx bx-power-off me-2"></i>
                                                <span class="align-middle">Logout</span>
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>

                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        @yield('container')
                    </div>

                    <footer class="content-footer footer bg-footer-theme ">
                        <div
                            class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                            <div class="mb-2 mb-md-0">Copyright&nbsp;
                                <script>
                                    document.write(new Date().getFullYear());
                                </script>&nbsp;All rights reserved.
                            </div>
                        </div>
                    </footer>

                    <div class="content-backdrop fade"></div>
                </div>
            </div>
        </div>
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>

    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="{{ asset('assets/vendors/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendors/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendors/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/vendors/assets/vendor/js/menu.js') }}"></script>
    <script src="{{ asset('assets/vendors/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="{{ asset('assets/vendors/assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/vendors/assets/js/dashboards-analytics.js') }}"></script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    @yield('script')
</body>

</html>
