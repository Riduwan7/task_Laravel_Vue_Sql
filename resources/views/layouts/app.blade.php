<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Task Collaboration Portal') }}</title>


    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Vue -->
    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>


    <style>
        body {
            background: #f5f7fb;
            font-family: system-ui;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* navbar */

        .navbar {
            background: #ffffff;
            border-bottom: 1px solid #e5e7eb;
        }

        /* main auth container */

        .auth-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* auth card */

        .auth-card {
            background: #ffffff;
            padding: 35px;
            border-radius: 10px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);
            width: 420px;
            max-width: 95%;
        }

        .auth-title {
            font-weight: 600;
            font-size: 20px;
            margin-bottom: 20px;
            text-align: center;
        }

        /* footer */

        .footer {
            text-align: center;
            font-size: 13px;
            padding: 15px;
            color: #6b7280;
        }
    </style>

</head>


<body>


    <!-- NAVBAR -->

    <nav class="navbar navbar-expand-md navbar-light shadow-sm">

        <div class="container">

            <a class="navbar-brand" href="{{ url('/') }}">

                <i class="bi bi-kanban"></i>
                Task Collaboration Portal

            </a>

            <button class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent">

                <span class="navbar-toggler-icon"></span>

            </button>


            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <ul class="navbar-nav ms-auto">

                    @guest

                    @if (Route::has('login'))

                    <li class="nav-item">

                        <a class="nav-link" href="{{ route('login') }}">

                            <i class="bi bi-box-arrow-in-right"></i>
                            Login

                        </a>

                    </li>

                    @endif


                    @if (Route::has('register'))

                    <li class="nav-item">

                        <a class="nav-link" href="{{ route('register') }}">

                            <i class="bi bi-person-plus"></i>
                            Register

                        </a>

                    </li>

                    @endif


                    @else

                    <li class="nav-item dropdown">

                        <a id="navbarDropdown"
                            class="nav-link dropdown-toggle"
                            href="#"
                            role="button"
                            data-bs-toggle="dropdown">

                            <i class="bi bi-person-circle"></i>
                            {{ Auth::user()->name }}

                        </a>

                        <div class="dropdown-menu dropdown-menu-end">

                            <a class="dropdown-item"
                                href="{{ route('logout') }}"
                                onclick="event.preventDefault();
document.getElementById('logout-form').submit();">

                                <i class="bi bi-box-arrow-right"></i>
                                Logout

                            </a>

                            <form id="logout-form"
                                action="{{ route('logout') }}"
                                method="POST"
                                class="d-none">

                                @csrf

                            </form>

                        </div>

                    </li>

                    @endguest

                </ul>

            </div>

        </div>

    </nav>



    <!-- MAIN CONTENT -->

    <div class="auth-container">

        <div class="auth-card">

            @yield('content')

        </div>

    </div>



    <!-- FOOTER -->

    <div class="footer">

        © {{ date('Y') }} Task Collaboration Portal

    </div>



    <!-- Bootstrap -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')

</body>

</html>