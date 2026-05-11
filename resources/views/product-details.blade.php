@extends('layouts.app')

@section('content')
<!-- ONLY PAGE CONTENT -->
<!-- main image -->
<!-- <div class="container">
        <div class="row">
            <div class="col-md-12">
                <img src="{{ asset('storage/' . $product->image) }}" alt="" class="product-img">
            </div>
        </div>
    </div> -->

<!-- main + gallary images -->
<div class="nav-spacer"></div>
<div class="container py-5">
    <div class="row">

        <!-- IMAGE CAROUSEL -->
        <div class="col-md-6">

            <div id="productCarousel" class="carousel slide">

                <div class="carousel-inner">

                    {{-- MAIN IMAGE (first slide) --}}
                    <div class="carousel-item active">
                        <div class="zoom-container">
                            <img src="{{ asset('storage/' . $product->image) }}" class="zoom-img w-100">
                        </div>
                    </div>

                    {{-- GALLERY IMAGES --}}
                    @foreach($product->images as $img)
                    <div class="carousel-item">
                        <div class="zoom-container">
                            <img src="{{ asset('storage/' . $img->image) }}" class="zoom-img w-100">
                        </div>
                    </div>
                    @endforeach

                </div>

                <button class="carousel-control-prev" data-bs-target="#productCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>

                <button class="carousel-control-next" data-bs-target="#productCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>

            </div>

        </div>

        <!-- DETAILS -->
        <div class="col-md-6">
            <h2>{{ $product->item_name }}</h2>
            <h4 class="text-primary">Rs {{ $product->sale }}</h4>

            <p>{{ $product->item_descr }}</p>

            <!-- QTY -->
            <div class="d-flex mb-3">
                <button class="btn btn-outline-secondary qty-minus">-</button>
                <input type="number" value="1" class="form-control text-center qty-input" style="width:80px;">
                <button class="btn btn-outline-secondary qty-plus">+</button>
            </div>

            <button class="btn btn-primary w-100 add-to-cart"
                data-id="{{ $product->id }}">
                Add to Cart
            </button>

            <!-- reviews -->
            <div id="reviewSection">

                <hr>
                @auth
                <h5 class="mt-4">Write a Review</h5>

                <form id="reviewForm" action="{{ route('product.review', $product->id) }}" method="POST">
                    @csrf

                    <!-- STAR RATING -->
                    <div class="mb-2">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fa-regular fa-star star" data-value="{{ $i }}"></i>
                            @endfor
                    </div>

                    <input type="hidden" name="rating" id="ratingValue">

                    <textarea name="comment" class="form-control mb-2"
                        placeholder="Write your review..."></textarea>

                    <button class="btn btn-success btn-sm">Submit Review</button>
                </form>
                @else
                <div class="alert alert-info">
                    Please <a href="{{ route('login') }}">login</a> to write a review.
                </div>
                @endauth
                <hr>

                <!-- REVIEWS LIST -->
                @foreach($product->reviews as $review)

                <div class="border p-2 mb-2 rounded">

                    <strong>{{ $review->name }}</strong>

                    @php
                    $stars = $review->rating / 2;
                    @endphp

                    <div class="text-warning">
                        @for($i = 1; $i <= 5; $i++)
                            @if($stars>= $i)
                            <i class="fa-solid fa-star"></i>
                            @elseif($stars >= $i - 0.5)
                            <i class="fa-solid fa-star-half-stroke"></i>
                            @else
                            <i class="fa-regular fa-star"></i>
                            @endif
                            @endfor
                    </div>

                    <small>{{ $review->comment }}</small>

                </div>

                @endforeach

            </div>

            <!-- TOAST -->
            <div id="reviewToast" class="review-toast">
                Review submitted successfully ⭐
            </div>
        </div>

    </div>
</div>

@endsection