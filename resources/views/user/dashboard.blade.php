<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel - Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">
        <div class="row">
            <h1 class="text-center mb-4">Our Products</h1>
            <div class="d-flex justify-content-end mb-3">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-outline-danger btn-sm">
                        <i class="fa fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
            <div class="row"> @foreach($products as $product) <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body"> <!-- Product Name -->
                        <h5 class="card-title fw-bold"> {{ $product->item_name }} </h5> <!-- Price -->
                        <h6 class="text-success mb-2"> Rs {{ $product->sale }} </h6> <!-- Description -->
                        <p class="card-text text-muted"> {{ $product->item_descr }} </p> <!-- Unit -->
                        <p class="mb-0"> <strong>Unit:</strong> {{ $product->unit }} </p>
                    </div>
                </div>
            </div> @endforeach </div>
            <div class="text-center mt-4"> <a href="/" class="btn btn-dark">Go Home</a> </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>