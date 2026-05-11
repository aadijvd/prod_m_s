<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>My Store</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;

        }

        body,
        html {
            margin: 0;
            padding: 0;
        }

        /* Ensure navbar links are white */
        .navbar-nav .nav-link {
            color: white !important;
            transition: all 0.3s;
            /* Use !important to force this style */
        }

        .navbar-nav .nav-link.active {
            color: #fff !important;
            font-weight: bold;
            /* White for active link as well */
        }

        /* Optional: For hover state */
        .navbar-nav .nav-link:hover {
            color: #0b5ed7 !important;
        }

        #mainNavbar {
            background-color: rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        /* When scrolled */
        #mainNavbar.scrolled {
            background-color: rgba(0, 0, 128, 0.5);
            /* stronger navy */
            /* navy blue */
            backdrop-filter: blur(8px);
            /* optional nice effect */
        }

        /* HERO */
        .hero {
            /* background: linear-gradient(to right, #0d6efd, #0dcaf0); */
            color: white;
            position: relative;
            top: 0;
            height: 100vh;
        }

        .hero-btn {
            color: #fff;
            background: transparent;
            border: 2px solid #0d6efd;
            transition: all 0.3s ease;
        }

        .hero-btn:hover {
            background: #0d6efd;
            color: #fff;
        }

        .hero-slider .slide {
            height: 100vh;
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: flex-end;
            justify-content: center;
            position: relative;
            top: 0;
        }

        /* Overlay */
        .hero-slider .slide::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.3);
        }

        /* Content */
        .hero-slider .content {
            position: relative;
            color: #fff;
            text-align: center;
            z-index: 2;
            padding-bottom: 100px;
        }

        .hero-slider h1 {
            font-size: 60px;
            margin-bottom: 10px;
        }

        .hero-slider p {
            font-size: 20px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-slider .slide {
                height: 70vh;
            }

            .hero-slider h1 {
                font-size: 32px;
            }

            .hero-slider p {
                font-size: 16px;
            }
        }

        /* PRODUCT CARD */
        .product-card {
            transition: 0.3s;
        }

        .product-card:hover {
            transform: translateY(-8px);
        }

        /* TESTIMONIAL */
        .testimonial {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 125px 0;
        }

        /* Testimonial Card */
        .testimonial-card {
            background: #fff;
            border-radius: 15px;
            transition: all 0.3s ease;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            position: relative;
        }

        /* Hover effect */
        .testimonial-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }

        /* User Image */
        .testi-img {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #0d6efd;
        }

        /* Quote icon effect */
        .testimonial-card::before {
            content: "\f10d";
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            position: absolute;
            top: 15px;
            left: 15px;
            font-size: 20px;
            color: #0d6efd;
            opacity: 0.2;
        }

        footer {
            background-color: #0b5ed7;
            color: white;
            padding: 140px 0;
        }

        footer a {
            color: #adb5bd;
            text-decoration: none;
        }

        footer a:hover {
            color: white;
        }


        .product-img {
            height: 350px;
            /* fixed height */
            width: 100%;
            object-fit: contain;
            /* keeps full image visible */
            background-color: #f8f9fa;
            /* optional: nice background */
        }

        .spacing {
            padding: 70px 0;
        }

        .clr {
            color: #fff !important;
        }

        .clr i {
            color: white;
        }

        .sect-3 {
            padding: 200px;
        }
    </style>
</head>

<body>

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
                    <span id="cart-count" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        0
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

    <!-- HERO -->
    <section class="hero hero-slider text-center">
        <!-- <div class="container">
            <h1>Welcome to MyStore</h1>
            <p class="lead mt-3">Best products at unbeatable prices</p>
            <a href="{{ route('products.visitor') }}" class="btn btn-light mt-3 px-4">Shop Now</a>
        </div> -->


        <div class="owl-carousel owl-theme">

            <div class="item">
                <div class="slide" style="background-image: url('{{ asset('images/slide-1.jpg') }}')">
                    <div class="content">
                        <h1>Welcome to My Website</h1>
                        <p>Beautiful responsive hero slider</p>
                        <a href="{{ route('products.visitor') }}" class="btn hero-btn mt-3 px-4">Shop Now</a>
                    </div>
                </div>
            </div>

            <div class="item">
                <div class="slide" style="background-image: url('{{ asset('images/slide-2.jpg') }}')">
                    <div class="content">
                        <h1>Modern Design</h1>
                        <p>Fully responsive & smooth</p>
                        <a href="{{ route('products.visitor') }}" class="btn hero-btn mt-3 px-4">Shop Now</a>
                    </div>
                </div>
            </div>

            <div class="item">
                <div class="slide" style="background-image: url('{{ asset('images/slide-3.jpg') }}')">
                    <div class="content">
                        <h1>Easy to Customize</h1>
                        <p>Use your own images & text</p>
                        <a href="{{ route('products.visitor') }}" class="btn hero-btn mt-3 px-4">Shop Now</a>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- FEATURED PRODUCTS -->
    <section class="spacing">
        <div class="container text-center">
            <h2 class="mb-5">Exclusive Products</h2>

            <div class="row">
                <!-- CARD -->
                @foreach($products as $product)
                <div class="col-md-3">
                    <a href="{{ route('product.details', $product->id) }}" class="text-decoration-none text-dark">
                        <div class="card product-card shadow-sm">
                            <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top product-img">
                            <div class="card-body">
                                <h5>{{ $product->item_name }}</h5>
                                <p class="text-muted">$ {{ $product->sale }}</p>
                            </div>
                        </div>
                    </a>
                    <div class="p-2">
                        <button class="add-to-cart btn btn-primary w-100" data-id="{{ $product->id }}">Add to Cart</button>
                    </div>
                </div>
                @endforeach
            </div>
    </section>

    <!-- WHY CHOOSE US -->
    <section class="sect-3 spacing bg-primary clr text-center">
        <div class="container">
            <h2 class="mb-5">Why Choose Us</h2>

            <div class="row">
                <div class="col-md-4">
                    <i class="fa fa-truck fa-2x  mb-3"></i>
                    <h5>Fast Delivery</h5>
                    <p>Quick and reliable delivery service.</p>
                </div>

                <div class="col-md-4">
                    <i class="fa fa-star fa-2x mb-3"></i>
                    <h5>Quality Products</h5>
                    <p>Only the best quality items available.</p>
                </div>

                <div class="col-md-4">
                    <i class="fa fa-headset fa-2x mb-3"></i>
                    <h5>24/7 Support</h5>
                    <p>We are here to help anytime.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- TESTIMONIAL -->

    <section class="testimonial bg-light">
        <div class="container text-center">
            <h2 class="mb-5 fw-bold">What Our Customers Say</h2>

            <div class="row g-4">

                <div class="col-md-4">
                    <div class="testimonial-card p-4">
                        <img src="{{ asset('images/image1.jpg') }}" class="testi-img mb-3">

                        <div class="mb-2 text-warning">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                        </div>

                        <p>"Amazing products and fast delivery!"</p>
                        <h6 class="fw-bold mb-0">Ali</h6>
                        <small class="text-muted">Customer</small>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="testimonial-card p-4">
                        <img src="{{ asset('images/image1.jpg') }}" class="testi-img mb-3">

                        <div class="mb-2 text-warning">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star-half-alt"></i>
                        </div>

                        <p>"Great customer support and quality."</p>
                        <h6 class="fw-bold mb-0">Ahmed</h6>
                        <small class="text-muted">Customer</small>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="testimonial-card p-4">
                        <img src="{{ asset('images/image2.jpg') }}" class="testi-img mb-3">

                        <div class="mb-2 text-warning">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                        </div>

                        <p>"Highly recommended store!"</p>
                        <h6 class="fw-bold mb-0">Sara</h6>
                        <small class="text-muted">Customer</small>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- FOOTER -->
    <footer>
        <div class="container">
            <div class="row">

                <div class="col-md-4">
                    <h5>MyStore</h5>
                    <p>Your trusted online shop.</p>
                </div>

                <div class="col-md-4">
                    <h5>Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('products.visitor') }}">Products</a></li>
                        <li><a href="{{ route('about') }}">About</a></li>
                        <li><a href="{{ route('contact') }}">Contact</a></li>
                    </ul>
                </div>

                <div class="col-md-4">
                    <h5>Contact</h5>
                    <p>Email: support@mystore.com</p>
                    <p>Phone: +92 300 0000000</p>
                </div>

            </div>

            <hr class="bg-secondary">

            <!-- <div class="text-center">
                <p class="mb-0">© 2026 Adix. All rights reserved.</p>
            </div> -->
        </div>
    </footer>
    <div class="bg-primary clr p-2">
        <div class="container bg-primary">
            <div class="row text-end ">
                <p class="mb-0">© 2026 Adix. All rights reserved.</p>
            </div>
        </div>
    </div>











    <!-- bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- full width slider -->
    <script>
        $(document).ready(function() {
            $(".hero-slider .owl-carousel").owlCarousel({
                items: 1,
                loop: true,
                autoplay: true,
                autoplayTimeout: 4000,
                autoplayHoverPause: true,
                nav: true,
                dots: false,
                navText: ["‹", "›"],
                responsive: {
                    0: {
                        items: 1
                    },
                    768: {
                        items: 1
                    },
                    1000: {
                        items: 1
                    }
                }
            });
        });
    </script>
    <!-- scroll event -->
    <script>
        window.addEventListener('scroll', function() {
            let navbar = document.getElementById('mainNavbar');

            if (window.scrollY > 100) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    </script>

    <!-- add to cart -->
    <script>
            document.querySelectorAll('.add-to-cart').forEach(btn => {

                btn.addEventListener('click', function(e) {

                    e.preventDefault();

                    let id = this.dataset.id;

                    fetch('/add-to-cart', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                id
                            })
                        })
                        .then(res => res.json())
                        .then(data => {

                            // update cart count
                            document.getElementById('cart-count').innerText = data.count;

                            alert('Added to cart');
                        });

                });

            });
    </script>
</body>

</html>