<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title') | Admin Panel</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">


    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Vue -->
    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>


    <style>
        body {
            background: #f5f7fb;
            font-family: system-ui;
        }

        .sidebar {
            width: 240px;
            height: 100vh;
            position: fixed;
            background: #111827;
            color: #fff;
        }

        .sidebar a {
            color: #cbd5e1;
            text-decoration: none;
            display: block;
            padding: 12px 20px;
            font-size: 14px;
        }

        .sidebar a:hover {
            background: #1f2937;
            color: #fff;
        }

        .sidebar .logo {
            font-size: 18px;
            font-weight: 600;
            padding: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, .1);
        }

        .main-content {
            margin-left: 240px;
        }

        .navbar {
            background: #fff;
            border-bottom: 1px solid #e5e7eb;
        }

        .page-header {
            padding: 20px 25px;
        }

        .page-title {
            font-size: 20px;
            font-weight: 600;
        }

        .content-area {
            padding: 20px;
        }

        .stat-card {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .stat-value {
            font-size: 20px;
            font-weight: 600;
        }

        .stat-label {
            font-size: 13px;
            color: #6b7280;
        }

        .table-card {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .05);
        }

        .table-card-header {
            margin-bottom: 15px;
        }

        .table-card-title {
            font-weight: 600;
            font-size: 15px;
        }
    </style>

</head>


<body>

    <!-- SIDEBAR -->
    <div class="sidebar">

        <div class="logo">
            <i class="bi bi-kanban"></i> Project Portal
        </div>

        <a href="{{ route('admin.dashboard') }}">
            <i class="bi bi-speedometer2 me-2"></i>
            Dashboard
        </a>

        <a href="{{ route('admin.users.index') }}">
            <i class="bi bi-people me-2"></i>
            Users
        </a>

        <a href="{{ route('admin.projects.index') }}">
            <i class="bi bi-kanban me-2"></i>
            Projects
        </a>

        <a href="{{ route('admin.clients.index') }}" class="nav-link">
            <i class="bi bi-person-workspace me-2"></i>
            Clients
        </a>
    </div>


    <!-- MAIN CONTENT -->
    <div class="main-content">


        <!-- NAVBAR -->
        <nav class="navbar px-4 d-flex justify-content-between">

            <div>
                <strong>@yield('page-title')</strong>
            </div>

            <div>

                <span class="me-3">
                    <i class="bi bi-person-circle"></i>
                    {{ Auth::user()->name }}
                </span>

                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button class="btn btn-sm btn-outline-danger">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>

            </div>

        </nav>



        <!-- PAGE HEADER -->
        <div class="page-header">

            <h4 class="page-title">
                @yield('page-title')
            </h4>

        </div>



        <!-- PAGE CONTENT -->
        <div class="content-area">

            @yield('content')

        </div>


    </div>



    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')

</body>

</html>