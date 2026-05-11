<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel - Orders</title>

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
            Orders Panel - Welcome {{ auth()->user()->name }}
        </h2>

        <!-- Orders Table -->
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Customer Name</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Placed At</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach($orders as $index => $order)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $order->name }}</td>
                    <td>{{ $order->phone }}</td>
                    <td>{{ $order->address }}</td>

                    <!-- Items -->
                    <td>
                        <ul class="mb-0">
                            @foreach(json_decode($order->items, true) as $item)
                            <li>
                                {{ $item['name'] }}
                                ({{ $item['qty'] }} x {{ $item['price'] }})
                            </li>
                            @endforeach
                        </ul>
                    </td>

                    <td>{{ $order->total }}</td>

                    <!-- Status -->
                    <td>

                        @if($order->status == 'pending')

                        <span class="badge bg-warning text-dark">
                            Pending
                        </span>

                        @elseif($order->status == 'delivered')

                        <span class="badge bg-success">
                            Delivered
                        </span>

                        @elseif($order->status == 'cancelled')

                        <span class="badge bg-danger">
                            Cancelled
                        </span>

                        @endif

                    </td>

                    <td>{{ $order->created_at->format('d M Y, h:i A') }}</td>

                    <!-- Actions -->
                    <td>
                        <!-- Update Status Example -->
                        <form action="{{ url('/admin/orders/update-status/'.$order->id) }}" method="POST">
                            @csrf

                            <select name="status" class="form-select form-select-sm mb-2">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>
                                    Pending
                                </option>

                                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>
                                    Delivered
                                </option>

                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>
                                    Cancelled
                                </option>
                            </select>

                            <button class="btn btn-sm btn-primary w-100">
                                Update
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Navigation -->
        <a href="/admin/dashboard" class="btn btn-dark mt-3">Go Home</a>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>