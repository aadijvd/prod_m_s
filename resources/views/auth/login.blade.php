<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Title condition -->
    <title>{{ config('app.name', 'AUTH + CRUD') }}</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        .input-group-text i {
            width: 20px;
        }
    </style>
</head>

<body class="d-flex justify-content-center align-items-center min-vh-100">

    <!-- Navbar conditions (kept from your template) -->
    <!-- <header class="w-full position-absolute top-0 p-3">
        @if (Route::has('login'))
            <nav class="d-flex justify-content-end gap-2">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-sm btn-outline-dark">
                        Dashboard
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-outline-danger btn-sm">
                            <i class="fa fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-sm btn-outline-dark">
                        Login
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-sm btn-dark">
                            Register
                        </a>
                    @endif
                @endauth
            </nav>
        @endif
    </header> -->
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <!-- Login Card -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow p-4">
                    <h3 class="mb-4 text-center">Login</h3>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email -->
                        <div class="mb-3">
                            <label>Email</label>
                            <div class="input-group">
                                <input type="email" name="email" class="form-control" placeholder="Enter email"
                                    required>
                                <span class="input-group-text">
                                    <i class="fa fa-envelope"></i>
                                </span>
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label>Password</label>
                            <div class="input-group">
                                <input type="password" name="password" class="form-control" placeholder="Enter password"
                                    required>
                                <span class="input-group-text">
                                    <i class="fa fa-lock"></i>
                                </span>
                            </div>
                        </div>

                        <!-- Button -->
                        <button type="submit" class="btn btn-primary w-100">
                            Login
                        </button>

                        <!-- Register Link with condition -->
                        @if (Route::has('register'))
                        <div class="text-center mt-3">
                            <small>
                                Don't have an account?
                                <a href="{{ route('register') }}">Register here</a>
                            </small>
                        </div>
                        @endif

                    </form>
                </div>
            </div>
            @if(session('error'))
            <div class="col-md-5"> {{-- match the same col width --}}
                <div class="alert alert-danger mt-2">
                    {{ session('error') }}
                </div>
            </div>
            @endif
        </div>
    </div>

</body>

</html>