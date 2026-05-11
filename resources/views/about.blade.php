@extends('layouts.app')

@section('content')
<!-- ONLY PAGE CONTENT -->
<div class="nav-spacer"></div>
<!-- About Hero Section -->
<!-- About Hero Section -->
<section class="abt-hero-section py-5 bg-light position-relative overflow-hidden">
    <div class="container">
        <div class="row align-items-center abt-min-vh-50">

            <!-- Left Content -->
            <div class="col-lg-6 text-lg-start text-center"
                data-aos="fade-right"
                data-aos-duration="1200">

                <span class="badge bg-primary px-3 py-2 mb-3 shadow-sm">
                    Welcome To Our Store
                </span>

                <h1 class="display-4 fw-bold mb-4">
                    About <span class="text-primary">Us</span>
                </h1>

                <p class="lead text-muted mb-4">
                    We are a modern eCommerce brand focused on delivering
                    premium quality products with exceptional customer service.
                    Our goal is to create a smooth and trusted shopping experience
                    for every customer.
                </p>

                <a href="{{ route('products.visitor') }}" class="btn btn-primary btn-lg px-4 shadow abt-btn-primary">
                    Explore Products
                </a>
            </div>

            <!-- Right Image -->
            <div class="col-lg-6 text-center mt-5 mt-lg-0"
                data-aos="fade-left"
                data-aos-duration="1200">

                <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=1200&auto=format&fit=crop"
                    class="img-fluid rounded-4 shadow-lg"
                    alt="About Us">
            </div>
        </div>
    </div>
</section>

<!-- Mission Vision Values -->
<section class="abt-features-section py-5">
    <div class="container">

        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="fw-bold">Why Choose Us</h2>
            <p class="text-muted">
                We believe in quality, innovation, and customer satisfaction.
            </p>
        </div>

        <div class="row g-4">

            <!-- Mission -->
            <div class="col-md-4"
                data-aos="zoom-in"
                data-aos-delay="100">

                <div class="card border-0 shadow-lg h-100 rounded-4 abt-card">
                    <div class="card-body p-4 text-center">

                        <div class="mb-4">
                            <i class="bi bi-rocket-takeoff-fill text-primary display-4"></i>
                        </div>

                        <h4 class="fw-bold mb-3">Our Mission</h4>

                        <p class="text-muted">
                            Deliver high-quality products quickly and efficiently
                            while maintaining outstanding customer service.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Vision -->
            <div class="col-md-4"
                data-aos="zoom-in"
                data-aos-delay="300">

                <div class="card border-0 shadow-lg h-100 rounded-4 abt-card">
                    <div class="card-body p-4 text-center">

                        <div class="mb-4">
                            <i class="bi bi-eye-fill text-success display-4"></i>
                        </div>

                        <h4 class="fw-bold mb-3">Our Vision</h4>

                        <p class="text-muted">
                            Become a globally trusted eCommerce platform known
                            for innovation, reliability, and customer happiness.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Values -->
            <div class="col-md-4"
                data-aos="zoom-in"
                data-aos-delay="500">

                <div class="card border-0 shadow-lg h-100 rounded-4 abt-card">
                    <div class="card-body p-4 text-center">

                        <div class="mb-4">
                            <i class="bi bi-heart-fill text-danger display-4"></i>
                        </div>

                        <h4 class="fw-bold mb-3">Our Values</h4>

                        <p class="text-muted">
                            We stand on trust, quality, transparency,
                            and long-term relationships with our customers.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Stats Section -->

<section class="abt-stats-section py-5 text-white">
    <div class="container">

        <div class="row text-center g-4">

            <!-- Happy Customers -->
            <div class="col-md-3"
                data-aos="fade-up"
                data-aos-delay="100">

                <h2 class="fw-bold display-5">
                    <span class="abt-counter" data-count="10000">0</span>+
                </h2>

                <p class="mb-0">Happy Customers</p>
            </div>

            <!-- Premium Products -->
            <div class="col-md-3"
                data-aos="fade-up"
                data-aos-delay="200">

                <h2 class="fw-bold display-5">
                    <span class="abt-counter" data-count="500">0</span>+
                </h2>

                <p class="mb-0">Premium Products</p>
            </div>

            <!-- Support -->
            <div class="col-md-3"
                data-aos="fade-up"
                data-aos-delay="300">

                <h2 class="fw-bold display-5">
                    <span class="abt-counter" data-count="24">0</span>/7
                </h2>

                <p class="mb-0">Customer Support</p>
            </div>

            <!-- Reviews -->
            <div class="col-md-3"
                data-aos="fade-up"
                data-aos-delay="400">

                <h2 class="fw-bold display-5">
                    <span class="abt-counter" data-count="99">0</span>%
                </h2>

                <p class="mb-0">Positive Reviews</p>
            </div>

        </div>
    </div>
</section>

@endsection