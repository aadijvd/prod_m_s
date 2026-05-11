<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel - Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    
</head>

<body>
<div class="container mt-5">

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif


<h2 class="mb-4 text-center">
    Product Panel - Welcome {{ auth()->user()->name }}
</h2>

<!-- Product Table -->
<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>Product Name</th>
            <th>Qty</th>
            <th>Description</th>
            <th>Unit Cost</th>
            <th>Sale</th>
            <th>Unit</th>
            <th>Barcode</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        @foreach($products as $index => $product)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $product->item_name }}</td>
                <td>{{ $product->qty }}</td>
                <td>{{ $product->item_descr }}</td>
                <td>{{ $product->cost }}</td>
                <td>{{ $product->sale }}</td>
                <td>{{ $product->unit }}</td>
                <td>{{ $product->barcode }}</td>

                <td>
                    <!-- Edit Button -->
                    <a href="{{ url('/admin/update-product/'.$product->id) }}" 
                       class="btn btn-sm btn-primary" title="Edit">
                       <i class="bi bi-pencil"></i>
                    </a>

                    <!-- Delete Button -->
                    <form action="{{ url('/admin/delete-product/'.$product->id) }}" 
                          method="POST" 
                          style="display:inline;">
                        @csrf
                        @method('DELETE')

                        <button class="btn btn-sm btn-danger"
                                onclick="return confirm('Are you sure?')" title="Delete">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </td>

            </tr>
        @endforeach
    </tbody>
</table>

<!-- Navigation Buttons -->
<a href="/admin/dashboard" class="btn btn-dark mt-3">Go Home</a>
<a href="/admin/add-product" class="btn btn-dark mt-3">Add Product</a>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
