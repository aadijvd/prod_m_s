@extends('layouts.app')

@section('content')

<!-- Hero section Full width slider -->
<section class="hero hero-slider text-center">
    <!-- <div class="container">
            <h1>Welcome to MyStore</h1>
            <p class="lead mt-3">Best products at unbeatable prices</p>
            <a href="{{ route('products.visitor') }}" class="btn btn-light mt-3 px-4">Shop Now</a>
        </div> -->


    <div class="owl-carousel owl-theme">

        <div class="item">
            <div class="slide" style="background-image: url('{{ asset('images/slide-3.jpg') }}')">
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
            <div class="slide" style="background-image: url('{{ asset('images/slide-1.jpg') }}')">
                <div class="content">
                    <h1>Easy to Customize</h1>
                    <p>Use your own images & text</p>
                    <a href="{{ route('products.visitor') }}" class="btn hero-btn mt-3 px-4">Shop Now</a>
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

<!-- FEATURED PRODUCTS -->
<section class="spacing corusel-sec-h">
    <div class="container text-center">
        <h2 class="mb-5">Exclusive Products</h2>

        <div class="row">
            <!-- CARD -->
            @foreach($products as $product)
            <div class="col-md-3" data-aos="fade-up"
                data-aos-duration="1000"
                data-aos-delay="{{ $loop->index * 200 }}">
                <a href="{{ route('product.details', $product->id) }}" class="text-decoration-none text-dark">
                    <div class="card product-card shadow-sm">
                        <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top product-img">
                        <div class="card-body-home">
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
    </div>
    <!-- btn -->
    <div class="container">
        <div class="row">
            <div class="view-all-wrapper">
                <a href="{{ route('products.visitor') }}" class="view-all-btn">
                    View All Products →
                </a>
            </div>
        </div>
    </div>
</section>


<!-- WHY CHOOSE US -->
<section class="sect-3 spacing bg-primary clr text-center">
    <div class="container">
        <h2 class="mb-5">Why Choose Us</h2>

        <div class="row g-4">

            <div class="col-md-4">
                <div class="choose-card"
                    data-aos="zoom-out-right"
                    data-aos-duration="1000"
                    data-aos-delay="0">

                    <i class="fa fa-truck fa-2x mb-3"></i>
                    <h5>Fast Delivery</h5>
                    <p>Quick and reliable delivery service.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="choose-card"
                    data-aos="zoom-out-up"
                    data-aos-duration="1000"
                    data-aos-delay="100">

                    <i class="fa fa-star fa-2x mb-3"></i>
                    <h5>Quality Products</h5>
                    <p>Only the best quality items available.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="choose-card"
                    data-aos="zoom-out-left"
                    data-aos-duration="1000"
                    data-aos-delay="400">

                    <i class="fa fa-headset fa-2x mb-3"></i>
                    <h5>24/7 Support</h5>
                    <p>We are here to help anytime.</p>
                </div>
            </div>

        </div>

    </div>
</section>


<!-- TESTIMONIAL -->

<section class="testimonial bg-light">
    <div class="container text-center">
        <h2 class="mb-5 fw-bold">What Our Customers Say</h2>

        <div class="row g-4">

            @foreach($reviews as $review)
            <div class="col-md-4">

                <div class="testimonial-card p-4">

                    <img src="{{ asset('images/guest.png') }}"
                         class="testi-img mb-3">

                    <!-- ⭐ STARS -->
                    <div class="mb-2 text-warning">

                        @php
                            $stars = $review->rating / 2;
                        @endphp

                        @for($i = 1; $i <= 5; $i++)
                            @if($stars >= $i)
                                <i class="fa fa-star"></i>
                            @elseif($stars >= $i - 0.5)
                                <i class="fa fa-star-half-alt"></i>
                            @else
                                <i class="fa-regular fa-star"></i>
                            @endif
                        @endfor

                    </div>

                    <!-- COMMENT -->
                    <p>"{{ $review->comment }}"</p>

                    <!-- NAME -->
                    <h6 class="fw-bold mb-0">{{ $review->name }}</h6>

                    <small class="text-muted">Customer</small>

                </div>

            </div>
            @endforeach

            <!-- <div class="col-md-4">
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
            </div> -->

        </div>
    </div>
</section>
@endsection