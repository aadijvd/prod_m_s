@extends('layouts.app')

@section('content')
<!-- ONLY PAGE CONTENT -->
<div class="nav-spacer"></div>
<!-- order success -->
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show cont-auto-hide-alert">
    {{ session('success') }}
</div>
@endif
<!-- main body -->
<div class="container py-5">
    <h2 class="mb-4 text-center">Our Products</h2>

    <!-- Search product -->
    <div class="search-wrapper">
        <input type="text"
            id="productSearch"
            placeholder="Search products..."
            autocomplete="off">
    </div>
    
    <!-- FILTER DROPDOWN -->
    <div class="filter-wrapper">
        <select id="productFilter">
            <option value="">Sort Products</option>
            <option value="az">A - Z</option>
            <option value="za">Z - A</option>
            <option value="low_high">Price Low → High</option>
            <option value="high_low">Price High → Low</option>
        </select>
    </div>

    <!-- SKELETON LOADER -->
    <div id="productSkeleton" class="row" style="display:none;">

        @for($i = 0; $i < 8; $i++)
            <div class="col-md-3 mb-4">
            <div class="skeleton-card">
                <div class="skeleton-img"></div>
                <div class="skeleton-line w-80"></div>
                <div class="skeleton-line w-50"></div>
            </div>
    </div>
    @endfor

</div>

<!-- PRODUCTS LOAD HERE -->
<div id="productContainer" class="row">
    @include('partials.product-grid', ['products' => $products])
</div>

{{ $products->links('pagination::bootstrap-5') }}

<!-- all products -->
<!-- <div class="row">

        @foreach($products as $product)
        <div class="col-md-3 mb-4">
            <div class="card h-100 shadow-sm product-card">

                <div class="img-wrapper">
                    <img src="{{ asset('storage/' . $product->image) }}"
                        class="product-img"
                        loading="lazy">
                </div>

                <div class="card-body pd-pg-sz text-center">
                    <h5>{{ $product->item_name }}</h5>
                    <p class="text-muted">Rs {{ $product->sale }}</p>

                    <a href="{{ route('product.details', $product->id) }}"
                        class="btn btn-outline-primary btn-sm">View</a>

                    <button class="btn btn-primary btn-sm add-to-cart"
                        data-id="{{ $product->id }}">
                        Add to Cart
                    </button>
                </div>

            </div>
        </div>
        @endforeach
    </div> -->

<!-- forces Laravel to use that exact view which we edited like mentioned in controller -->



</div>

@endsection