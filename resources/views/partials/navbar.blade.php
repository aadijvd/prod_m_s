<!-- NAVBAR -->
<nav id="mainNavbar" class="navbar navbar-expand-lg fixed-top shadow-lg">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">
            <img src="{{ asset('images/main-logo.png') }}" alt="Logo" style="height: 60px;">
        </a>

        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item"><a class="nav-link active" href="{{ route('home') }}">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('products.visitor') }}">Products</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">About</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">Contact</a></li>
            </ul>

            <!-- CART ICON (everyone sees it) -->
            <a href="/cart" class="btn position-relative me-3 text-white">
                <i class="fa fa-shopping-cart fa-lg"></i>
                <span id="cart-count" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-info">
                    {{ array_sum(array_column(session('cart', []), 'qty')) }}
                </span>
            </a>

            <!-- RIGHT SIDE BUTTONS -->
            <div class="d-flex">
                @guest
                <a href="/login" class="btn btn-outline-primary me-2 clr">Login</a>
                <a href="/register" class="btn btn-primary">Register</a>
                @endguest

                @auth
                <span style="color: #fff;font-weight: 600" class="me-3 ">Hi, {{ auth()->user()->name }}</span>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-primary btn-sm">
                        Logout
                    </button>
                </form>
                @endauth
            </div>
        </div>
    </div>
</nav>