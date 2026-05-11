<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>User Registration</title>

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
        <h3 class="mb-4">User Registration</h3>

        <!-- ERROR DISPLAY -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="mb-3">
                <label>Name</label>
                <div class="input-group">
                    <input name="name" type="text" value="{{ old('name') }}" class="form-control" required>
                    <span class="input-group-text">
                        <i class="fa fa-user"></i>
                    </span>
                </div>
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label>Email</label>
                <div class="input-group">
                    <input name="email" type="email" value="{{ old('email') }}" class="form-control" required>
                    <span class="input-group-text">
                        <i class="fa fa-envelope"></i>
                    </span>
                </div>
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label>Password</label>
                <div class="input-group">
                    <input name="password" type="password" class="form-control" required>
                    <span class="input-group-text">
                        <i class="fa fa-lock"></i>
                    </span>
                </div>
            </div>

            <!-- Confirm Password -->
            <div class="mb-3">
                <label>Confirm Password</label>
                <div class="input-group">
                    <input name="password_confirmation" type="password" class="form-control" required>
                    <span class="input-group-text">
                        <i class="fa fa-key"></i>
                    </span>
                </div>
            </div>

            <!-- Role -->
            <!-- <div class="mb-3">
                <label>Role</label>
                <div class="input-group">
                    <select name="role" class="form-select" required>
                        <option disabled selected>Select role</option>
                        <option value="1">Manager</option>
                        <option value="2">User</option>
                    </select>
                    <span class="input-group-text">
                        <i class="fa fa-user-tag"></i>
                    </span>
                </div>
            </div> -->

            <!-- Submit -->
            <button type="submit" class="btn btn-success w-100">
                Register
            </button>

            <div class="text-center mt-3">
                <small>
                    Already registered?
                    <a href="{{ route('login') }}">Login here</a>
                </small>
            </div>

        </form>
    </div>
</div>

</body>
</html>