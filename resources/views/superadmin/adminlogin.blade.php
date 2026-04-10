<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Super Admin — Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            background: linear-gradient(135deg, #0D3D47 0%, #0F5C7B 55%, #00BFC5 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', system-ui, sans-serif;
        }

        .login-wrap {
            width: 100%;
            max-width: 420px;
            padding: 20px;
        }

        /* Brand */
        .login-brand {
            text-align: center;
            margin-bottom: 28px;
        }
        .login-brand img {
            width: 72px; height: 72px;
            border-radius: 50%;
            border: 3px solid rgba(255,255,255,.3);
            box-shadow: 0 4px 20px rgba(0,0,0,.3);
            object-fit: cover;
        }
        .login-brand h5 {
            color: #fff;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 20px;
            font-weight: 700;
            margin: 12px 0 4px;
        }
        .login-brand p {
            color: rgba(255,255,255,.65);
            font-size: 13px;
            margin: 0;
        }

        /* Card */
        .login-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0,0,0,.25);
            padding: 36px 32px 28px;
            border: none;
        }

        .login-card .form-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: #0D3D47;
            margin-bottom: 6px;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .login-card .form-control {
            border: 1.5px solid #d1d8e0;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 0.875rem;
            color: #0D3D47;
            transition: border-color .15s, box-shadow .15s;
        }
        .login-card .form-control:focus {
            border-color: #00BFC5;
            box-shadow: 0 0 0 3px rgba(0,191,197,.15);
            outline: none;
        }
        .login-card .form-control::placeholder {
            color: #A8B2BC;
        }

        /* Input group (password toggle) */
        .input-group .form-control { border-right: none; }
        .input-group-text {
            background: #fff;
            border: 1.5px solid #d1d8e0;
            border-left: none;
            border-radius: 0 8px 8px 0;
            cursor: pointer;
            color: #6c757d;
            transition: color .15s;
        }
        .input-group:focus-within .form-control,
        .input-group:focus-within .input-group-text {
            border-color: #00BFC5;
        }
        .input-group-text:hover { color: #0F5C7B; }

        /* Submit button */
        .btn-login {
            background: linear-gradient(135deg, #0F5C7B, #00BFC5);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            padding: 12px;
            width: 100%;
            transition: opacity .15s, box-shadow .15s;
            margin-top: 8px;
        }
        .btn-login:hover {
            opacity: .9;
            box-shadow: 0 6px 20px rgba(0,191,197,.4);
            color: #fff;
        }

        /* Alert */
        .alert-danger {
            background: #fdecea;
            color: #c0392b;
            border: none;
            border-left: 4px solid #dc3545;
            border-radius: 8px;
            font-size: 0.875rem;
            padding: 10px 14px;
        }
    </style>
</head>
<body>

<div class="login-wrap">
    <div class="login-brand">
        <img src="{{ asset('asset/default.jpg') }}" alt="Logo">
        <h5>Super Admin</h5>
        <p>Sign in to your account</p>
    </div>

    <div class="login-card">
        @if (session('error'))
            <div class="alert alert-danger mb-3">{{ session('error') }}</div>
        @endif

        <form id="loginform" method="POST" action="{{ route('adminlogin') }}">
            @csrf
            <div class="mb-3">
                <label for="superemail" class="form-label">Username</label>
                <input type="text" class="form-control" id="superemail" name="superemail" placeholder="Enter username" autocomplete="username">
            </div>

            <div class="mb-4">
                <label for="superpassword" class="form-label">Password</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="superpassword" name="superpassword" placeholder="Enter password" autocomplete="current-password">
                    <span class="input-group-text" id="togglePassword">
                        <i class="fas fa-eye"></i>
                    </span>
                </div>
            </div>

            <button type="submit" class="btn-login">Sign In</button>
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
