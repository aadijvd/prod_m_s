<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel - Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <style>
        .dashboard-card {
            transition: all 0.3s ease;
            border: none;
            border-radius: 15px;
        }

        .dashboard-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .dashboard-icon {
            font-size: 40px;
            margin-bottom: 15px;
            color: #212529;
        }

        .dashboard-card {
            cursor: pointer;
        }

        .dashboard-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            background-color: #f8f9fa;
        }
    </style>
    <div class="container mt-3">
        <h2 class="mb-4 text-center">Admin Panel - Welcome {{ auth()->user()->name }}</h2>
        <div class="d-flex justify-content-end mb-3">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-outline-danger btn-sm">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </div>

        <!-- <a href="/" class="btn btn-dark mt-3">Go Home</a>
        <a href="/admin/products" class="btn btn-dark mt-3">Manage Products</a>
        <a href="/admin/manage-user" class="btn btn-dark mt-3">Manage Users</a> -->

        <!-- DASHBOARD CARDS -->
        <div class="row g-4">

            <!-- Home -->
            <div class="col-md-4">
                <a href="/admin/dashboard" class="text-decoration-none text-dark">
                    <div class="card dashboard-card text-center p-4 shadow-sm">
                        <div class="card-body">
                            <i class="bi bi-house-door dashboard-icon"></i>
                            <h5 class="card-title">Home</h5>
                            <p class="card-text">Go back to homepage</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Products -->
            <div class="col-md-4">
                <a href="/admin/products" class="text-decoration-none text-dark">
                    <div class="card dashboard-card text-center p-4 shadow-sm">
                        <div class="card-body">
                            <i class="bi bi-box-seam dashboard-icon"></i>
                            <h5 class="card-title">Products</h5>
                            <p class="card-text">Manage your products</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Users -->
            <div class="col-md-4">
                <a href="/admin/manage-user" class="text-decoration-none text-dark">
                    <div class="card dashboard-card text-center p-4 shadow-sm">
                        <div class="card-body">
                            <i class="bi bi-people dashboard-icon"></i>
                            <h5 class="card-title">Users</h5>
                            <p class="card-text">Manage user accounts</p>
                        </div>
                    </div>
                </a>
            </div>
            <!-- Suppliers -->
            <div class="col-md-4">
                <a href="/admin/suppliers" class="text-decoration-none text-dark">
                    <div class="card dashboard-card text-center p-4 shadow-sm">
                        <div class="card-body">
                            <i class="bi bi-truck dashboard-icon"></i>
                            <h5 class="card-title">Suppliers</h5>
                            <p class="card-text">Manage your suppliers</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Purchases -->
            <div class="col-md-4">
                <a href="/admin/purchases" class="text-decoration-none text-dark">
                    <div class="card dashboard-card text-center p-4 shadow-sm">
                        <div class="card-body">
                            <i class="bi bi-cart-check dashboard-icon"></i>
                            <h5 class="card-title">Purchases</h5>
                            <p class="card-text">Track and manage purchases</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Customers -->
            <div class="col-md-4">
                <a href="/admin/customers" class="text-decoration-none text-dark">
                    <div class="card dashboard-card text-center p-4 shadow-sm">
                        <div class="card-body">
                            <i class="bi bi-people dashboard-icon"></i>
                            <h5 class="card-title">Customers</h5>
                            <p class="card-text">Manage your customers</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Sales -->
            <div class="col-md-4">
                <a href="/admin/sales" class="text-decoration-none text-dark">
                    <div class="card dashboard-card text-center p-4 shadow-sm">
                        <div class="card-body">
                            <i class="bi bi-receipt dashboard-icon"></i>
                            <h5 class="card-title">Sales</h5>
                            <p class="card-text">View and manage sales</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Orders -->
            <div class="col-md-4">
                <a href="/admin/orders" class="text-decoration-none text-dark">
                    <div class="card dashboard-card text-center p-4 shadow-sm">
                        <div class="card-body">
                            <i class="bi bi-bag-check dashboard-icon"></i>
                            <h5 class="card-title">Orders</h5>
                            <p class="card-text">Manage your orders</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>