<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add Sale</title>

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

            <h3 class="mb-4">Add Sale</h3>

            <!-- Errors -->
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="/admin/sales/store" method="POST">
                @csrf

                <!-- Invoice -->
                <div class="mb-3">
                    <label>Invoice No</label>
                    <div class="input-group">
                        <input name="invoice_no" type="text" class="form-control" placeholder="Enter invoice number">
                        <span class="input-group-text"><i class="fa fa-file-invoice"></i></span>
                    </div>
                </div>

                <!-- Customer -->
                <div class="mb-3">
                    <label>Customer</label>
                    <div class="input-group">
                        <select name="customer_id" class="form-select">
                            <option value="">Select Customer</option>
                            @foreach($customers as $customer)
                            <option value="{{ $customer->id }}">
                                {{ $customer->name }}
                            </option>
                            @endforeach
                        </select>
                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                    </div>
                </div>

                <!-- Sale Date -->
                <div class="mb-3">
                    <label>Sale Date</label>
                    <div class="input-group">
                        <input name="sale_date" type="date" class="form-control">
                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                    </div>
                </div>

                <!-- Payment Status -->
                <div class="mb-3">
                    <label>Payment Status</label>
                    <div class="input-group">
                        <select name="payment_status" class="form-select">
                            <option value="pending">Pending</option>
                            <option value="partial">Partial</option>
                            <option value="paid">Paid</option>
                        </select>
                        <span class="input-group-text"><i class="fa fa-check"></i></span>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="mb-3">
                    <label>Payment Method</label>
                    <div class="input-group">
                        <select name="payment_method" class="form-select">
                            <option value="cash">Cash</option>
                            <option value="card">Card</option>
                            <option value="bank">Bank</option>
                        </select>
                        <span class="input-group-text"><i class="fa fa-credit-card"></i></span>
                    </div>
                </div>

                <!-- Notes -->
                <div class="mb-3">
                    <label>Notes</label>
                    <div class="input-group">
                        <input name="notes" type="text" class="form-control">
                        <span class="input-group-text"><i class="fa fa-note-sticky"></i></span>
                    </div>
                </div>

                <!-- Products -->
                <h5 class="mt-4">Select Products</h5>

                @foreach($products as $index => $product)
                <div class="row product-row mb-2 border p-2">

                    <div class="col-md-3">
                        <label>
                            <input type="checkbox" name="items[{{ $index }}][product_id]" value="{{ $product->id }}">
                            {{ $product->item_name }}
                        </label>
                    </div>

                    <div class="col-md-3">
                        <input type="number" name="items[{{ $index }}][qty]" class="form-control qty" placeholder="Qty">
                    </div>

                    <div class="col-md-3">
                        <input type="number" name="items[{{ $index }}][price]" class="form-control price" value="{{ $product->sale }}">
                    </div>

                    <div class="col-md-3">
                        <input type="number" name="items[{{ $index }}][subtotal]" class="form-control" readonly>
                    </div>

                </div>
                @endforeach

                <!-- Total -->
                <div class="mb-3">
                    <label>Total Amount</label>
                    <div class="input-group">
                        <input name="total_amount" type="number" class="form-control" readonly>
                        <span class="input-group-text"><i class="fa fa-money-bill"></i></span>
                    </div>
                </div>

                <!-- Paid -->
                <div class="mb-3">
                    <label>Paid Amount</label>
                    <div class="input-group">
                        <input name="paid_amount" type="number" class="form-control" step="0.01">
                        <span class="input-group-text"><i class="fa fa-wallet"></i></span>
                    </div>
                </div>

                <!-- Due -->
                <div class="mb-3">
                    <label>Due Amount</label>
                    <div class="input-group">
                        <input name="due_amount" type="number" class="form-control" readonly>
                        <span class="input-group-text"><i class="fa fa-money-bill-wave"></i></span>
                    </div>
                </div>

                <!-- Discount -->
                <div class="mb-3">
                    <label>Discount</label>
                    <div class="input-group">
                        <input name="discount_amount" type="number" class="form-control" step="0.01" value="0">
                        <span class="input-group-text"><i class="fa fa-percent"></i></span>
                    </div>
                </div>

                <!-- Tax -->
                <div class="mb-3">
                    <label>Tax</label>
                    <div class="input-group">
                        <input name="tax_amount" type="number" class="form-control" step="0.01" value="0">
                        <span class="input-group-text"><i class="fa fa-receipt"></i></span>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    Save Sale
                </button>

            </form>
        </div>
    </div>

    <!-- JS -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            function calculate() {
                let total = 0;

                document.querySelectorAll('.product-row').forEach(row => {

                    let checkbox = row.querySelector('input[type="checkbox"]');
                    let qty = row.querySelector('.qty');
                    let price = row.querySelector('.price');
                    let subtotalInput = row.querySelector('input[name*="[subtotal]"]');

                    let q = parseFloat(qty.value) || 0;
                    let p = parseFloat(price.value) || 0;

                    let subtotal = q * p;
                    subtotalInput.value = subtotal.toFixed(2);

                    if (checkbox.checked) {
                        total += subtotal;
                    }
                });

                document.querySelector('input[name="total_amount"]').value = total.toFixed(2);

                let paid = parseFloat(document.querySelector('input[name="paid_amount"]').value) || 0;
                document.querySelector('input[name="due_amount"]').value = (total - paid).toFixed(2);
            }

            document.addEventListener('input', calculate);
            document.addEventListener('change', calculate);
        });
    </script>

</body>

</html>