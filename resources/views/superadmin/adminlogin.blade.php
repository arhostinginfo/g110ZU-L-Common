<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Super Admin Login </title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>

    <style>
        body {
            background: #f4f6f9;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .login-card {
            max-width: 400px;
            width: 100%;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .input-group-text {
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="card login-card">
    <div class="card-body">
        <div class="text-center mb-4">
            <img src="{{ asset('asset/default.jpg') }}"" alt="Logo" style="height: 60px;">
            <h4 class="mt-2">Admin Login</h4>
        </div>

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form id="loginform" method="POST" action="{{ route('adminlogin') }}">
            @csrf
            <div class="mb-3">
                <label for="superemail" class="form-label">User name</label>
                <input type="text" class="form-control" id="superemail" name="superemail" placeholder="Enter username">
            </div>

            <div class="mb-3">
                <label for="superpassword" class="form-label">Password</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="superpassword" name="superpassword" placeholder="Enter password">
                    <span class="input-group-text" id="togglePassword">
                        <i class="fas fa-eye"></i>
                    </span>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100">Sign in</button>
        </form>
    </div>
</div>

<script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#superpassword');

    togglePassword.addEventListener('click', function () {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.querySelector('i').classList.toggle('fa-eye');
        this.querySelector('i').classList.toggle('fa-eye-slash');
    });
</script>

</body>
</html>
