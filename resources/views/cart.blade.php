@extends('layouts.app')

@section('content')
<!-- ONLY PAGE CONTENT -->
<div class="nav-spacer"></div>
<!-- errors -->
@if ($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<!-- main body -->
<div class="container py-5">
    <h2>Your Cart</h2>

    <table class="table">
        <thead>
            <tr>
                <th>Product</th>
                <th width="150">Qty</th>
                <th>Price</th>
                <th>Total</th>
                <th></th>
            </tr>
        </thead>

        <!-- <tbody>
            @foreach(session('cart', []) as $id => $item)
            <tr>

                <td>{{ $item['name'] }}</td>

                <td>
                    <button class="minus" data-id="{{ $id }}">-</button>
                    <input value="{{ $item['qty'] }}" class="qty" data-id="{{ $id }}">
                    <button class="plus" data-id="{{ $id }}">+</button>
                </td>

                <td>{{ $item['price'] }}</td>
                <td>{{ $item['price'] * $item['qty'] }}</td>

                <td>
                    <button class="remove btn btn-danger" data-id="{{ $id }}">X</button>
                </td>

            </tr>
            @endforeach
        </tbody> -->
        <tbody>
            @foreach(session('cart', []) as $id => $item)
            <tr class="align-middle">

                <td class="fw-semibold">
                    {{ $item['name'] }}
                </td>

                <td style="width: 160px;">
                    <div class="d-flex align-items-center gap-2">

                        <button class="btn btn-sm btn-outline-secondary minus"
                            data-id="{{ $id }}">-</button>

                        <input type="text"
                            value="{{ $item['qty'] }}"
                            class="form-control form-control-sm text-center qty"
                            data-id="{{ $id }}"
                            style="width: 50px;">

                        <button class="btn btn-sm btn-outline-secondary plus"
                            data-id="{{ $id }}">+</button>

                    </div>
                </td>

                <td class="text-primary fw-semibold">
                    ${{ $item['price'] }}
                </td>

                <td class="fw-bold">
                    ${{ $item['price'] * $item['qty'] }}
                </td>

                <td>
                    <button class="btn btn-sm btn-danger remove"
                        data-id="{{ $id }}">
                        Remove
                    </button>
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="text-end">
        <h4>Total: Rs {{ $total }}</h4>
        <!-- because it does not have required fields so wont work like this -->
        <!-- <form action="/place-order" method="POST">
            @csrf
            <button class="btn btn-success">
                Checkout
            </button>
        </form> -->
        <a href="#checkout" class="btn btn-success">
            Checkout
        </a>
    </div>
</div>
<!-- 💳 4. CHECKOUT PAGE -->
<!-- <div class="container py-5">
    <h2>Checkout</h2>

    <form action="/place-order" method="POST">
        @csrf

        <div class="row">

            <div class="col-md-6">
                <label>Name</label>
                <input type="text" name="name" class="form-control">

                <label class="mt-3">Phone</label>
                <input type="text" name="phone" class="form-control">

                <label class="mt-3">Address</label>
                <textarea name="address" class="form-control"></textarea>
            </div>

            <div class="col-md-6">
                <h5>Order Summary</h5>

                @foreach($cart as $item)
                <p>
                    {{ $item['name'] }} x {{ $item['qty'] }}
                    <span class="float-end">
                        Rs {{ $item['price'] * $item['qty'] }}
                    </span>
                </p>
                @endforeach

                <hr>
                <h4>Total: Rs {{ $total }}</h4>

                <button class="btn btn-primary w-100 mt-3">
                    Place Order
                </button>
            </div>

        </div>
    </form>
</div> -->
<div id="checkout" class="container py-5">
    <h2 class="mb-4">Checkout</h2>

    <form action="/place-order" method="POST">
        @csrf

        <div class="row g-4">

            <!-- LEFT FORM -->
            <div class="col-md-6">
                <div class="card shadow-sm p-4">

                    <h5 class="mb-3">Billing Details</h5>

                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control mb-3">

                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control mb-3">

                    <label class="form-label">Address</label>
                    <textarea name="address" class="form-control" rows="4"></textarea>

                </div>
            </div>

            <!-- RIGHT SUMMARY -->
            <div class="col-md-6">
                <div class="card shadow-sm p-4">

                    <h5 class="mb-3">Order Summary</h5>

                    @foreach($cart as $item)
                    <div class="d-flex justify-content-between mb-2">
                        <span>{{ $item['name'] }} x {{ $item['qty'] }}</span>
                        <span>Rs {{ $item['price'] * $item['qty'] }}</span>
                    </div>
                    @endforeach

                    <hr>

                    <div class="d-flex justify-content-between fw-bold mb-3">
                        <span>Total</span>
                        <span>Rs {{ $total }}</span>
                    </div>

                    <button class="btn btn-primary w-100">
                        Place Order
                    </button>

                </div>
            </div>

        </div>
    </form>
</div>
@endsection


<!-- php artisan cache:clear
php artisan view:clear -->