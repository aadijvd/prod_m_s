<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Purchase</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        .input-group-text i {
            width: 20px;
        }
    </style>
</head>

<body>

    <div class="container mt-5">
        <div class="card shadow p-4">

            <h3 class="mb-4">Edit Purchase</h3>

            <form action="{{ route('purchase.update', $purchase->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Supplier -->
                <div class="mb-3">
                    <label>Supplier</label>
                    <div class="input-group">
                        <select name="supplier_id" class="form-select">
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" {{ $purchase->supplier_id == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->name }}
                                </option>
                            @endforeach
                        </select>
                        <span class="input-group-text">
                            <i class="fa fa-truck"></i>
                        </span>
                    </div>
                </div>

                <!-- Total Amount -->
                <div class="mb-3">
                    <label>Total Amount</label>
                    <div class="input-group">
                        <input name="total_amount" type="number" step="0.01" class="form-control total"
                            value="{{ $purchase->total_amount }}" placeholder="Enter total amount" readonly>

                        <span class="input-group-text">
                            <i class="fa fa-money-bill"></i>
                        </span>
                    </div>
                </div>

                <!-- Purchase Date -->
                <div class="mb-3">
                    <label>Purchase Date</label>
                    <div class="input-group">
                        <input name="purchase_date" type="date" class="form-control"
                            value="{{ $purchase->purchase_date }}">

                        <span class="input-group-text">
                            <i class="fa fa-calendar"></i>
                        </span>
                    </div>
                </div>

                <!-- Notes -->
                <div class="mb-3">
                    <label>Notes</label>
                    <div class="input-group">
                        <input name="notes" type="text" class="form-control" value="{{ $purchase->notes }}"
                            placeholder="Enter notes">

                        <span class="input-group-text">
                            <i class="fa fa-note-sticky"></i>
                        </span>
                    </div>
                </div>
                <h5 class="mt-4">Edit Items</h5>

                @foreach($purchase->items as $index => $item)
                    <div class="row product-row mb-2 border p-2">

                        <!-- Product Name -->
                        <div class="col-md-3">
                            {{ $item->product->item_name }}

                            <input type="hidden" name="items[{{ $index }}][product_id]" value="{{ $item->product_id }}">
                        </div>

                        <!-- Qty -->
                        <div class="col-md-3">
                            <input type="number" name="items[{{ $index }}][qty]" value="{{ $item->qty }}"
                                class="form-control qty">
                        </div>

                        <!-- Price -->
                        <div class="col-md-3">
                            <input type="number" name="items[{{ $index }}][price]" value="{{ $item->price }}"
                                class="form-control price">
                        </div>

                        <!-- Subtotal -->
                        <div class="col-md-3">
                            <input type="number" name="items[{{ $index }}][subtotal]" value="{{ $item->subtotal }}"
                                class="form-control subtotal" readonly>
                        </div>

                    </div>
                @endforeach

                <!-- Submit -->
                <button type="submit" class="btn btn-success w-100">
                    Update Purchase
                </button>

                <a href="{{ route('purchase.index') }}" class="btn btn-dark w-100 mt-2">
                    Back
                </a>

            </form>

        </div>
    </div>

    <!-- total amount and subtotal calculation -->
     <script>
    document.addEventListener('DOMContentLoaded', function () {

        function calculate() {
            let total = 0;

            document.querySelectorAll('.product-row').forEach(row => {

                let qty = row.querySelector('.qty');
                let price = row.querySelector('.price');
                let subtotalInput = row.querySelector('.subtotal');

                let q = parseFloat(qty?.value) || 0;
                let p = parseFloat(price?.value) || 0;

                let subtotal = q * p;

                // update subtotal
                if (subtotalInput) {
                    subtotalInput.value = subtotal.toFixed(2);
                }

                total += subtotal;
            });

            let totalInput = document.querySelector('.total');
            if (totalInput) {
                totalInput.value = total.toFixed(2);
            }
        }

        // live calculation
        document.addEventListener('input', calculate);

        // run once on page load (VERY IMPORTANT for edit page)
        calculate();
    });
    </script>
</body>

</html>