<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Sale Details</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-5">

    <h2 class="mb-4 text-center">
        Sale Details - Invoice: {{ $sale->invoice_no }}
    </h2>

    <!-- SALE INFO CARD -->
    <div class="card mb-4 p-3 shadow-sm">

        <div class="row">

            <div class="col-md-4">
                <strong>Customer:</strong>
                {{ $sale->customer->name ?? 'Walk-in' }}
            </div>

            <div class="col-md-4">
                <strong>Date:</strong>
                {{ $sale->sale_date }}
            </div>

            <div class="col-md-4">
                <strong>Created By:</strong>
                {{ $sale->user->name ?? 'N/A' }}
                ({{ $sale->user->role == 0 ? 'Admin' : ($sale->user->role == 1 ? 'User' : 'Cashier') }})
            </div>

        </div>

        <hr>

        <div class="row">

            <div class="col-md-3">
                <strong>Total:</strong> {{ $sale->total_amount }}
            </div>

            <div class="col-md-3">
                <strong>Discount:</strong> {{ $sale->discount_amount }}
            </div>

            <div class="col-md-3">
                <strong>Tax:</strong> {{ $sale->tax_amount }}
            </div>

            <div class="col-md-3">
                <strong>Paid:</strong> {{ $sale->paid_amount }}
            </div>

        </div>

        <div class="row mt-2">

            <div class="col-md-4">
                <strong>Due:</strong> {{ $sale->due_amount }}
            </div>

            <div class="col-md-4">
                <strong>Method:</strong> {{ ucfirst($sale->payment_method) }}
            </div>

        </div>

        <div class="mt-3">
            <strong>Notes:</strong> {{ $sale->notes ?? 'N/A' }}
        </div>

    </div>

    <!-- SALE ITEMS TABLE -->
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

            @foreach($sale->items as $index => $item)
                <tr>

                    <td>{{ $index + 1 }}</td>

                    <td>{{ $item->product->item_name ?? 'N/A' }}</td>

                    <td>{{ $item->qty }}</td>

                    <td>{{ $item->price }}</td>

                    <td>{{ $item->subtotal }}</td>

                </tr>
            @endforeach

        </tbody>

    </table>

    <!-- BUTTONS -->
    <a href="{{ route('sales.index') }}" class="btn btn-dark mt-3">
        Back to Sales
    </a>

</div>

</body>
</html>