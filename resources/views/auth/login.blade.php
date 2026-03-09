<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login - {{ config('app.name', 'Task Collaboration Portal') }}</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        :root {
            --primary-color: #1b1b18;
            --secondary-color: #f53003;
            --bg-light: #FDFDFC;
            --bg-dark: #0a0a0a;
            --text-primary: #1b1b18;
            --text-secondary: #706f6c;
            --border-color: #e3e3e0;
        }

        [data-bs-theme="dark"] {
            --primary-color: #eeeeec;
            --secondary-color: #FF4433;
            --bg-light: #161615;
            --bg-dark: #0a0a0a;
            --text-primary: #EDEDEC;
            --text-secondary: #A1A09A;
            --border-color: #3E3E3A;
        }

        body {
            background-color: var(--bg-light);
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        [data-bs-theme="dark"] body {
            background-color: var(--bg-dark);
        }

        .login-container {
            width: 100%;
            max-width: 420px;
        }

        .login-card {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 2rem;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }

        [data-bs-theme="dark"] .login-card {
            background: var(--bg-light);
        }

        .brand-title {
            font-weight: 600;
            margin-bottom: 4px;
        }

        .brand-subtitle {
            font-size: 14px;
            color: var(--text-secondary);
        }

        .form-label {
            font-size: 14px;
            font-weight: 500;
        }

        .form-control {
            background: var(--bg-light);
            border: 1px solid var(--border-color);
        }

        [data-bs-theme="dark"] .form-control {
            background: var(--bg-dark);
        }

        .form-control:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 .2rem rgba(245, 48, 3, .25);
        }

        .btn-primary {
            background: var(--primary-color);
            border: none;
        }

        .btn-primary:hover {
            background: black;
        }

        [data-bs-theme="dark"] .btn-primary:hover {
            background: white;
            color: black;
        }

        .invalid-feedback {
            font-size: 13px;
        }

        .link {
            color: var(--secondary-color);
            text-decoration: none;
            font-weight: 500;
        }

        .link:hover {
            text-decoration: underline;
        }

        .back-link {
            font-size: 13px;
            color: var(--text-secondary);
        }
    </style>

</head>


<body>

    <div class="login-container">

        <!-- BRAND -->

        <div class="text-center mb-4">

            <h1 class="brand-title">
                <i class="bi bi-kanban-fill me-2"></i>
                Task Collaboration Portal
            </h1>

            <p class="brand-subtitle">
                Sign in to your account
            </p>

        </div>


        <!-- LOGIN CARD -->

        <div class="login-card">

            <form method="POST" action="{{ route('login') }}">
                @csrf


                <!-- EMAIL -->

                <div class="mb-3">

                    <label class="form-label">
                        <i class="bi bi-envelope me-1"></i>Email Address
                    </label>

                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        class="form-control @error('email') is-invalid @enderror"
                        placeholder="you@example.com"
                        required
                        autofocus>

                    @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror

                </div>


                <!-- PASSWORD -->

                <div class="mb-3">

                    <div class="d-flex justify-content-between">

                        <label class="form-label">
                            <i class="bi bi-lock me-1"></i>Password
                        </label>

                        @if(Route::has('password.request'))

                        <a class="link"
                            href="{{ route('password.request') }}">

                            Forgot password?

                        </a>

                        @endif

                    </div>

                    <input
                        type="password"
                        name="password"
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="Enter password"
                        required>

                    @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror

                </div>


                <!-- REMEMBER -->

                <div class="mb-3">

                    <div class="form-check">

                        <input
                            type="checkbox"
                            name="remember"
                            class="form-check-input"
                            id="remember">

                        <label class="form-check-label" for="remember">

                            Remember me

                        </label>

                    </div>

                </div>


                <!-- GLOBAL ERROR -->

                @if ($errors->any() && !$errors->has('email') && !$errors->has('password'))

                <div class="alert alert-danger">

                    <i class="bi bi-exclamation-triangle me-1"></i>
                    {{ $errors->first() }}

                </div>

                @endif


                <!-- LOGIN BUTTON -->

                <button type="submit"
                    class="btn btn-primary w-100 mb-3">

                    <i class="bi bi-box-arrow-in-right me-1"></i>
                    Sign In

                </button>

            </form>


            <!-- REGISTER -->

            @if(Route::has('register'))

            <div class="text-center">

                <p style="font-size:14px">

                    Don't have an account?

                    <a href="{{ route('register') }}"
                        class="link">

                        Register

                    </a>

                </p>

            </div>

            @endif

        </div>


        <!-- BACK -->

        <div class="text-center mt-4">

            <a href="{{ route('welcome') }}"
                class="back-link">

                <i class="bi bi-arrow-left"></i>
                Back to home

            </a>

        </div>

    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


    <script>
        /* Auto Dark Mode */

        const prefersDark =
            window.matchMedia('(prefers-color-scheme: dark)').matches;

        document.documentElement.setAttribute(
            'data-bs-theme',
            prefersDark ? 'dark' : 'light'
        );

        window.matchMedia('(prefers-color-scheme: dark)')
            .addEventListener('change', e => {
                document.documentElement.setAttribute(
                    'data-bs-theme',
                    e.matches ? 'dark' : 'light'
                );
            });
    </script>

</body>

</html>