<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Sale</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-5">
    <div class="card shadow p-4">

        <h3 class="mb-4">Edit Sale</h3>

        <form action="{{ route('sale.update', $sale->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Customer -->
            <div class="mb-3">
                <label>Customer</label>
                <select name="customer_id" class="form-control">
                    <option value="">Walk-in</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}"
                            {{ $sale->customer_id == $customer->id ? 'selected' : '' }}>
                            {{ $customer->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Date -->
            <div class="mb-3">
                <label>Sale Date</label>
                <input type="date" name="sale_date" class="form-control"
                       value="{{ $sale->sale_date }}">
            </div>

            <!-- Paid -->
            <div class="mb-3">
                <label>Paid Amount</label>
                <input type="number" name="paid_amount" class="form-control"
                       value="{{ $sale->paid_amount }}">
            </div>

            <!-- Status -->
            <div class="mb-3">
                <label>Status</label>
                <select name="payment_status" class="form-control">
                    <option value="pending" {{ $sale->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="partial" {{ $sale->payment_status == 'partial' ? 'selected' : '' }}>Partial</option>
                    <option value="paid" {{ $sale->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                </select>
            </div>

            <!-- Method -->
            <div class="mb-3">
                <label>Payment Method</label>
                <select name="payment_method" class="form-control">
                    <option value="cash" {{ $sale->payment_method == 'cash' ? 'selected' : '' }}>Cash</option>
                    <option value="card" {{ $sale->payment_method == 'card' ? 'selected' : '' }}>Card</option>
                    <option value="bank" {{ $sale->payment_method == 'bank' ? 'selected' : '' }}>Bank</option>
                </select>
            </div>

            <!-- Notes -->
            <div class="mb-3">
                <label>Notes</label>
                <input type="text" name="notes" class="form-control"
                       value="{{ $sale->notes }}">
            </div>

            <hr>

            <!-- SALE ITEMS -->
            <h5>Sale Items</h5>

            @foreach($sale->items as $index => $item)
                <div class="row mb-2 border p-2">

                    <!-- Hidden item id -->
                    <input type="hidden" name="items[{{ $index }}][id]" value="{{ $item->id }}">

                    <!-- Product -->
                    <div class="col-md-3">
                        {{ $item->product->item_name }}
                        <input type="hidden" name="items[{{ $index }}][product_id]" value="{{ $item->product_id }}">
                    </div>

                    <!-- Qty -->
                    <div class="col-md-3">
                        <input type="number" name="items[{{ $index }}][qty]"
                               class="form-control qty"
                               value="{{ $item->qty }}">
                    </div>

                    <!-- Price -->
                    <div class="col-md-3">
                        <input type="number" name="items[{{ $index }}][price]"
                               class="form-control price"
                               value="{{ $item->price }}">
                    </div>

                    <!-- Subtotal -->
                    <div class="col-md-3">
                        <input type="number" name="items[{{ $index }}][subtotal]"
                               class="form-control subtotal"
                               value="{{ $item->subtotal }}" readonly>
                    </div>

                </div>
            @endforeach

            <button class="btn btn-success w-100 mt-3">
                Update Sale
            </button>

        </form>
    </div>
</div>

<script>
document.addEventListener('input', function () {

    document.querySelectorAll('.row').forEach(row => {
        let qty = row.querySelector('.qty');
        let price = row.querySelector('.price');
        let subtotal = row.querySelector('.subtotal');

        if (qty && price && subtotal) {
            let q = parseFloat(qty.value) || 0;
            let p = parseFloat(price.value) || 0;
            subtotal.value = (q * p).toFixed(2);
        }
    });

});
</script>

</body>
</html>