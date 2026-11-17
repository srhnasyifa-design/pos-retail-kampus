
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - POS Retail Kampus</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #eaf2ff, #f8fbff);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            width: 100%;
            max-width: 430px;
            background: white;
            border-radius: 18px;
            padding: 38px;
            box-shadow: 0 15px 45px rgba(20, 45, 90, .10);
        }

        .brand-icon {
            width: 65px;
            height: 65px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #eaf1ff;
            color: #174ea6;
            border-radius: 17px;
            font-size: 30px;
            margin: 0 auto 18px;
        }

        .form-control {
            padding: 12px 14px;
            border-radius: 9px;
        }

        .btn-login {
            background: #173b70;
            color: white;
            padding: 12px;
            border-radius: 9px;
            font-weight: 600;
        }

        .btn-login:hover {
            background: #102d57;
            color: white;
        }
    </style>
</head>

<body>

<div class="login-card">

    <div class="text-center mb-4">
        <div class="brand-icon">
            <i class="bi bi-shop"></i>
        </div>

        <h4 class="fw-bold mb-1">POS RETAIL KAMPUS</h4>
        <p class="text-muted small">Silakan login untuk masuk ke sistem</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('login.process') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label fw-semibold">Email</label>
            <input type="email"
                   name="email"
                   class="form-control"
                   value="{{ old('email') }}"
                   placeholder="Masukkan email"
                   required autofocus>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Password</label>
            <input type="password"
                   name="password"
                   class="form-control"
                   placeholder="Masukkan password"
                   required>
        </div>

        <div class="form-check mb-4">
            <input type="checkbox"
                   class="form-check-input"
                   name="remember"
                   value="1"
                   id="remember">
            <label class="form-check-label text-muted" for="remember">
                Ingat saya
            </label>
        </div>

        <button type="submit" class="btn btn-login w-100">
            <i class="bi bi-box-arrow-in-right me-2"></i>
            Login Sekarang
        </button>
    </form>

    <div class="text-center mt-4">
        <small class="text-muted">
            POS Retail Kampus &copy; {{ date('Y') }}
        </small>
    </div>

</div>

</body>
</html>
