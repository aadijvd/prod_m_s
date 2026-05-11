@foreach($products as $product)
<div class="col-md-3 mb-4">

    <div class="card h-100 shadow-sm product-card">

        <!-- CLICKABLE AREA ONLY -->
        <a href="{{ route('product.details', $product->id) }}" class="product-link">

            <div class="img-wrapper">
                <img src="{{ asset('storage/' . $product->image) }}"
                    class="product-img"
                    loading="lazy">
            </div>

            <div class="card-body text-center">
                <h5>{{ $product->item_name }}</h5>
                <p class="text-muted">Rs {{ $product->sale }}</p>
            </div>

        </a>

        <!-- ACTION BUTTONS (NOT INSIDE LINK) -->
        <div class="p-2 text-center">

            <button class="btn btn-outline-primary btn-sm">
                View
            </button>

            <button class="btn btn-primary btn-sm add-to-cart"
                data-id="{{ $product->id }}">
                Add to Cart
            </button>

        </div>

    </div>

</div>
@endforeach