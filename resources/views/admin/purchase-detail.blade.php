<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Purchase Details</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-5">

    <h2 class="mb-4 text-center">
        Purchase Details - Supplier: {{ $purchase->supplier->name ?? 'N/A' }}
    </h2>

    <!-- Purchase Info -->
    <div class="card mb-4 p-3 shadow-sm">
        <div class="row">
            <div class="col-md-4">
                <strong>Purchase ID:</strong> {{ $purchase->id }}
            </div>
            <div class="col-md-4">
                <strong>Total Amount:</strong> {{ $purchase->total_amount }}
            </div>
            <div class="col-md-4">
                <strong>Date:</strong> {{ $purchase->purchase_date }}
            </div>
        </div>

        <div class="mt-2">
            <strong>Notes:</strong> {{ $purchase->notes ?? 'N/A' }}
        </div>
    </div>

    <!-- Purchase Items Table -->
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Sr. #</th>
                <th>Product</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Subtotal</th>
            </tr>
        </thead>

        <tbody>
            @foreach($purchase->items as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>

                    <!-- Product Name -->
                    <td>{{ $item->product->item_name ?? 'N/A' }}</td>

                    <td>{{ $item->qty }}</td>
                    <td>{{ $item->price }}</td>
                    <td>{{ $item->subtotal }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Back Buttons -->
    <a href="{{ route('purchase.index') }}" class="btn btn-dark mt-3">
        Back to Purchases
    </a>

    <a href="/admin/add-purchase" class="btn btn-primary mt-3">
        Add New Purchase
    </a>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>