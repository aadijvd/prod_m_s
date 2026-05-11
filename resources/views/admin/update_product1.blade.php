<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Product Form</title>

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
            <h3 class="mb-4">Update Product</h3>

            <form action="/admin/update_product/{{ $product->id }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Item Name -->
                <div class="mb-3">
                    <label>Item Name</label>
                    <div class="input-group">
                        <input name="item_name" type="text" class="form-control" value="{{ $product->item_name }}"
                            placeholder="Enter item name">
                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                    </div>
                </div>
                <!-- Item Quantity -->
                <div class="mb-3">
                    <label>Qty</label>
                    <div class="input-group">
                        <input name="qty" type="text" class="form-control" value="{{ $product->qty }}"
                            placeholder="Enter item name">
                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-3">
                    <label>Description</label>
                    <div class="input-group">
                        <input name="item_descr" type="text" class="form-control" value="{{ $product->item_descr }}"
                            placeholder="Enter description">
                        <span class="input-group-text"><i class="fa fa-file-text"></i></span>
                    </div>
                </div>

                <!-- Cost -->
                <div class="mb-3">
                    <label>Cost</label>
                    <div class="input-group">
                        <input name="cost" type="number" class="form-control" value="{{ $product->cost }}"
                            placeholder="Cost price">
                        <span class="input-group-text">
                            <i class="fa fa-dollar-sign"></i>
                        </span>
                    </div>
                </div>

                <!-- Sale -->
                <div class="mb-3">
                    <label>Sale Price</label>
                    <div class="input-group">
                        <input name="sale" type="number" class="form-control" value="{{ $product->sale }}"
                            placeholder="Sale price">
                        <span class="input-group-text">
                            <i class="fa fa-tags"></i>
                        </span>
                    </div>
                </div>

                <!-- Unit -->
                <div class="mb-3">
                    <label>Unit</label>
                    <div class="input-group">
                        <select name="unit" class="form-select">
                            <option disabled>Select unit</option>
                            <option value="kg" {{ $product->unit == 'kg' ? 'selected' : '' }}>Kilogram (kg)</option>
                            <option value="piece" {{ $product->unit == 'piece' ? 'selected' : '' }}>Piece</option>
                            <option value="packet" {{ $product->unit == 'packet' ? 'selected' : '' }}>Packet</option>
                        </select>
                        <span class="input-group-text">
                            <i class="fa fa-box"></i>
                        </span>
                    </div>
                </div>

                <!-- Barcode -->
                <div class="mb-3">
                    <label>Barcode</label>
                    <div class="input-group">
                        <input name="barcode" type="text" class="form-control" value="{{ $product->barcode }}"
                            placeholder="Enter barcode">
                        <span class="input-group-text"><i class="fa fa-barcode"></i></span>
                    </div>
                </div>

                <!-- Submit -->
                <button type="submit" class="btn btn-success w-100">
                    Update Product
                </button>
            </form>
        </div>
    </div>

</body>

</html>