<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- jquery DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <!-- Font Awesome CSS -->
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css'>
    <!-- Custom Css -->
    <link rel="stylesheet" href="{{ asset('css/dashboard_style.css') }}">

    <title>Dashboard</title>
</head>
<body>

    <div class="main-container d-flex">
        <div class="sidebar fixed-start" id="side_nav">
            <div class="header-box px-2 pt-3 pb-4 d-flex justify-content-between">
                <div class="logo">
                <img src="{{ asset('images/cpc.png') }}" alt="Logo 1">
                </div>
                <h1 class="fs-4"><span class="text-white">Offense Monitoring System</span></h1>
                <button class="btn d-md-none d-block close-btn px-1 py-0 text-white">
                <i class='fa fa-ellipsis-h'></i></button>
            </div>

            <ul class="list-unstyled px-2">
                <li class="{{ request()->is('officer/dashboard') ? 'active' : '' }}">
                    <a href="{{ route('officer.dashboard') }}" class="text-decoration-none px-3 py-2 d-block">
                        <i class="fa fa-home"></i> Dashboard
                    </a>
                </li>
                <li class="{{ request()->is('officer/report') ? 'active' : '' }}">
                    <a href="{{ url('/officer/report') }}" class="text-decoration-none px-3 py-2 d-block">
                        <i class="fa fa-list-alt"></i> Report
                    </a>
                </li>
            </ul>


            <hr class="h-color mx-2">

            <ul class="list-unstyled px-2">
                <li class="{{ request()->is('officer/settings') ? 'active' : '' }}">
                    <a href="{{ route('officer.settings') }}" class="text-decoration-none px-3 py-2 d-block">
                        <i class="fa fa-gears"></i> Settings
                    </a>
                </li>
            </ul>
        </div>
        <div class="fix"></div>
        <div class="content">
            <nav class="navbar navbar-expand-md navbar-light bg-light">
                <div class="container-fluid">
                    <div class="d-flex justify-content-between d-md-none d-block">
                     <button class="btn px-1 py-0 open-btn me-2"><i class='fa fa-navicon'></i></button>
                        <div class="logo-toggle">
                        <img src="{{ asset('images/cpc.png') }}" alt="Logo 1">
                        </div>
                    </div>
                    <button class="navbar-toggler p-0 border-0" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <i class='fa fa-sort-down'></i>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                    <ul class="navbar-nav mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="https://www.pngall.com/wp-content/uploads/5/Profile-Avatar-PNG.png" alt="Clickable Image" style="cursor: pointer; width: 50px; height: 50px;">
                            </a>
                            <ul class="dropdown-menu custom-dropdown-menu" aria-labelledby="navbarDropdown">
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <x-dropdown-link :href="route('logout')"
                                                        onclick="event.preventDefault();
                                                                this.closest('form').submit();"
                                                        class="dropdown-item text-center">
                                            <i class="fal fa-"></i>{{ __('Log Out') }}
                                        </x-dropdown-link>
                                    </form>
                                </li>

                            </ul>
                        </li>
                    </ul>
                    </div>
                </div>
            </nav>

            @yield('content')

            </div>
            </div>
       </div>
</body>

    <!-- bootstrap script-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- jquery script -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Jquery DataTables -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <!-- DataTables bootstrap-->
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <!-- Custom script-->
    <script src="{{ asset('js/script.js') }}"></script>
</html>
