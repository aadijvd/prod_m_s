<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Customer</title>

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
            <h3 class="mb-4">Edit Customer</h3>

            <form action="{{ route('customer.update', $customer->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Name -->
                <div class="mb-3">
                    <label>Customer Name</label>
                    <div class="input-group">
                        <input name="name" type="text" class="form-control"
                            value="{{ old('name', $customer->name) }}" placeholder="Enter customer name">
                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                    </div>
                </div>

                <!-- Phone -->
                <div class="mb-3">
                    <label>Phone Number</label>
                    <div class="input-group">
                        <input name="phone" type="text" class="form-control"
                            value="{{ old('phone', $customer->phone) }}" placeholder="Enter phone number">
                        <span class="input-group-text"><i class="fa fa-phone"></i></span>
                    </div>
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label>Email</label>
                    <div class="input-group">
                        <input name="email" type="email" class="form-control"
                            value="{{ old('email', $customer->email) }}" placeholder="Enter email">
                        <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                    </div>
                </div>

                <!-- Address -->
                <div class="mb-3">
                    <label>Address</label>
                    <div class="input-group">
                        <input name="address" type="text" class="form-control"
                            value="{{ old('address', $customer->address) }}" placeholder="Enter address">
                        <span class="input-group-text"><i class="fa fa-location-dot"></i></span>
                    </div>
                </div>

                <!-- Type -->
                <div class="mb-3">
                    <label>Customer Type</label>
                    <div class="input-group">
                        <select name="type" class="form-control">
                            <option value="walk_in" {{ old('type', $customer->type) == 'walk_in' ? 'selected' : '' }}>Walk In</option>
                            <option value="regular" {{ old('type', $customer->type) == 'regular' ? 'selected' : '' }}>Regular</option>
                            <option value="online" {{ old('type', $customer->type) == 'online' ? 'selected' : '' }}>Online</option>
                        </select>
                        <span class="input-group-text"><i class="fa fa-list"></i></span>
                    </div>
                </div>

                <!-- Submit -->
                <button type="submit" class="btn btn-success w-100">
                    Update Customer
                </button>

                <a href="{{ route('customer.index') }}" class="btn btn-dark w-100 mt-2">
                    Back
                </a>

            </form>
        </div>
    </div>

</body>

</html>