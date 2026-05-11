<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add Purchase</title>

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

            <h3 class="mb-4">Add Purchase</h3>
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <form action="/admin/add-purchase-store" method="POST">
                @csrf

                <!-- Supplier -->
                <div class="mb-3">
                    <label>Supplier</label>
                    <div class="input-group">
                        <select name="supplier_id" class="form-select">
                            <option selected disabled>Select Supplier</option>
                            @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">
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
                        <input name="total_amount" type="number" class="form-control"
                            placeholder="Enter total amount" step="0.01" readonly>
                        <span class="input-group-text">
                            <i class="fa fa-money-bill"></i>
                        </span>
                    </div>
                </div>

                <!-- Purchase Date -->
                <div class="mb-3">
                    <label>Purchase Date</label>
                    <div class="input-group">
                        <input name="purchase_date" type="date" class="form-control">
                        <span class="input-group-text">
                            <i class="fa fa-calendar"></i>
                        </span>
                    </div>
                </div>

                <!-- Notes -->
                <div class="mb-3">
                    <label>Notes</label>
                    <div class="input-group">
                        <input name="notes" type="text" class="form-control" placeholder="Optional notes">
                        <span class="input-group-text">
                            <i class="fa fa-note-sticky"></i>
                        </span>
                    </div>
                </div>

                <!-- Purchase Item -->
                <h5 class="mt-4">Select Products</h5>

                @foreach($products as $index => $product)

                <div class="row product-row mb-2 align-items-center border p-2">

                    <!-- Checkbox -->
                    <div class="col-md-3">
                        <label>
                            <input type="checkbox" name="items[{{ $index }}][product_id]" value="{{ $product->id }}">
                            {{ $product->item_name }}
                        </label>
                    </div>

                    <!-- Qty -->
                    <div class="col-md-3">
                        <input type="number" name="items[{{ $index }}][qty]" class="form-control qty" placeholder="Qty" min="0" step="1">
                    </div>

                    <!-- Price -->
                    <div class="col-md-3">
                        <input type="number" name="items[{{ $index }}][price]" class="form-control price" placeholder="Price" min="0" step="0.01" value="{{ $product->cost }}">
                    </div>

                    <!-- Subtotal -->
                    <div class="col-md-3">
                        <input type="number" name="items[{{ $index }}][subtotal]" class="form-control"
                            placeholder="Subtotal" step="0.01" readonly>
                    </div>

                </div>

                @endforeach

                <!-- Submit -->
                <button type="submit" class="btn btn-primary w-100">
                    Save Purchase
                </button>

            </form>

        </div>
    </div>
    <script>
        // total_amount and subtotal calculation
        document.addEventListener('DOMContentLoaded', function() {

            function calculate() {

                let total = 0;

                // ✅ only targets product rows, not all Bootstrap .row divs
                document.querySelectorAll('.product-row').forEach(row => {

                    let checkbox = row.querySelector('input[type="checkbox"]');
                    let qty = row.querySelector('.qty');
                    let price = row.querySelector('.price');
                    let subtotalInput = row.querySelector('input[name*="[subtotal]"]');

                    // skip if any essential element is missing
                    if (!checkbox || !qty || !price || !subtotalInput) return;

                    let q = parseFloat(qty.value) || 0;
                    let p = parseFloat(price.value) || 0;

                    let subtotal = q * p;

                    // update subtotal field
                    subtotalInput.value = subtotal.toFixed(2);

                    // only add to total if row is checked
                    if (checkbox.checked) {
                        total += subtotal;
                    }
                });

                let totalInput = document.querySelector('input[name="total_amount"]');
                if (totalInput) {
                    totalInput.value = total.toFixed(2);
                }
            }

            // ✅ listen on document for dynamic input/change events
            document.addEventListener('input', calculate);
            document.addEventListener('change', calculate);

        });

        // disabling unchecked box so it wont submit
        document.addEventListener('change', function(e) {
            if (e.target.type === 'checkbox') {
                let row = e.target.closest('.product-row');
                let inputs = row.querySelectorAll('input.qty, input.price');

                inputs.forEach(input => {
                    input.disabled = !e.target.checked;
                });

                calculate();
            }
        });
    </script>
</body>

</html>