<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Sales</title>

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
            Sales Panel - Welcome {{ auth()->user()->name }}
        </h2>

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Invoice</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Paid</th>
                    <th>Due</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach($sales as $index => $sale)
                <tr>
                    <td>{{ $index + 1 }}</td>

                    <td>{{ $sale->invoice_no }}</td>

                    <td>{{ $sale->customer->name ?? 'Walk-in' }}</td>

                    <td>{{ $sale->sale_date }}</td>

                    <td>{{ number_format($sale->total_amount, 2) }}</td>
                    <td>{{ number_format($sale->paid_amount, 2) }}</td>
                    <td>{{ number_format($sale->due_amount, 2) }}</td>

                    <td>
                        <span class="badge bg-{{ $sale->payment_status == 'paid' ? 'success' : ($sale->payment_status == 'partial' ? 'warning' : 'danger') }}">
                            {{ ucfirst($sale->payment_status) }}
                        </span>
                    </td>

                    <td>
                        <a href="{{ route('sale.show', $sale->id) }}" class="btn btn-sm btn-info text-white" title="View">
                            <i class="bi bi-eye"></i>
                        </a>

                        <a href="{{ route('sale.edit', $sale->id) }}" class="btn btn-sm btn-primary" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>

                        <form action="{{ route('sale.delete', $sale->id) }}" method="POST" style="display:inline;">
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

        <a href="/admin/dashboard" class="btn btn-dark mt-3">Go Home</a>
        <a href="/admin/add-sale" class="btn btn-dark mt-3">Add Sale</a>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>