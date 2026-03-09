<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title') | Client Portal</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            display: block;
            padding: 12px 20px;
            text-decoration: none;
        }

        .sidebar a:hover {
            background: #1f2937;
            color: #fff;
        }

        .logo {
            padding: 20px;
            font-weight: 600;
            border-bottom: 1px solid rgba(255, 255, 255, .1);
        }

        .main-content {
            margin-left: 240px;
        }

        .navbar {
            background: #fff;
            border-bottom: 1px solid #e5e7eb;
        }

        .stat-card {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .05);
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

        .table-card {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .05);
        }
    </style>

</head>


<body>

    <div class="sidebar">

        <div class="logo">
            <i class="bi bi-briefcase"></i> Client Portal
        </div>

        <a href="{{ route('client.dashboard') }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <a href="{{ route('client.projects.index') }}">
            <i class="bi bi-kanban"></i> My Projects
        </a>

    </div>


    <div class="main-content">

        <nav class="navbar px-4 d-flex justify-content-between">

            <div>
                <strong>@yield('page-title')</strong>
            </div>

            <div>

                <span class="me-3">
                    <i class="bi bi-person"></i>
                    {{ Auth::user()->name }}
                </span>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-sm btn-outline-danger">
                        Logout
                    </button>
                </form>

            </div>

        </nav>


        <div class="p-4">

            @yield('content')

        </div>

    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')

</body>

</html>