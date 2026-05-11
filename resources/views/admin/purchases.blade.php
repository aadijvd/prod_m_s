<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel - Purchases</title>
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
            Purchase Panel - Welcome {{ auth()->user()->name }}
        </h2>

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Sr. #</th>
                    <th>Supplier</th>
                    <th>Total Amount</th>
                    <th>Purchase Date</th>
                    <th>Notes</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach($purchases as $index => $purchase)
                <tr>
                    <td>{{ $index + 1 }}</td>

                    <!-- Supplier Name via relationship -->
                    <td>{{ $purchase->supplier->name ?? 'N/A' }}</td>

                    <td>{{ $purchase->total_amount }}</td>
                    <td>{{ $purchase->purchase_date }}</td>
                    <td>{{ $purchase->notes }}</td>

                    <td>
                        <!-- View Details -->
                        <a href="{{ route('purchase.show', $purchase->id) }}" class="btn btn-sm btn-info text-white" title="View">
                            <i class="bi bi-eye"></i>
                        </a>
                        <!-- Edit -->
                        <a href="{{ route('purchase.edit', $purchase->id) }}" class="btn btn-sm btn-primary" title="edit">
                            <i class="bi bi-pencil"></i>
                        </a>

                        <!-- Delete -->
                        <form action="{{ route('purchase.delete', $purchase->id) }}" method="POST"
                            style="display:inline;">
                            @csrf
                            @method('DELETE')

                            <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')" title="Delete">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>

        <a href="/admin/dashboard" class="btn btn-dark mt-3">Go Home</a>
        <a href="/admin/add-purchase" class="btn btn-dark mt-3">Add Purchase</a>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>