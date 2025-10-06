<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #f3f3f3;
        }
        .login-box {
            width: 90vw;
            max-width: 50vw;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 4px 5px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }
        .login-left {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .login-left img {
            width: 100%;
            height: auto;
            object-fit: contain;
        }
        .login-right {
            padding: 30px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            height: 100%;
        }
        .form-control {
            border-radius: 10px;
        }
        .btn {
            border-radius: 10px;
        }
    </style>
</head>
<body>

<div class="login-box row g-0 align-items-center">
    <!-- Bagian Kiri -->
    <div class="col-md-6 login-left d-none d-md-flex">
        <img src="{{ asset('assets/images/login/rinobsn.png') }}" alt="Illustration">
    </div>

    <!-- Bagian Kanan -->
    <div class="col-md-6 login-right">
        <div class="text-center mb-3">
            <img src="https://mastan.or.id/wp-content/uploads/2020/02/bsn-logo.png" alt="Logo" width="80">
            <h3 class="mt-2">LOGIN</h3>
        </div>

        <form action="{{ url('login') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            <button type="submit" class="btn btn-primary w-100">Login</button>
            <div class="form-check mt-2">
                <input class="form-check-input" type="checkbox" name="remember" checked>
                <label class="form-check-label">Remember me</label>
            </div>
        </form>
    </div>
</div>

@if(request()->has('expired'))
<script>
Swal.fire({
    icon: 'warning',
    title: 'Sesi Berakhir',
    text: 'Sesi Anda telah berakhir. Silakan login kembali.',
    confirmButtonColor: '#3085d6',
    confirmButtonText: 'OK'
});
</script>
@endif

</body>
</html>
