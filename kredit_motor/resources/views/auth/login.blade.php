<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background-color: #f8fafc;
      font-family: 'Segoe UI', sans-serif;
    }

    .login-container {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .login-box {
      width: 100%;
      max-width: 380px;
      background: #fff;
      padding: 32px;
      border-radius: 10px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }

    .login-title {
      font-size: 22px;
      font-weight: 600;
      text-align: center;
      margin-bottom: 6px;
    }

    .login-sub {
      font-size: 13px;
      text-align: center;
      color: #6b7280;
      margin-bottom: 20px;
    }

    .form-label {
      font-size: 13px;
    }

    .form-control {
      font-size: 14px;
    }

    .btn-primary {
      font-size: 14px;
      font-weight: 500;
    }
  </style>
</head>

<body>

<div class="login-container">
  <div class="login-box">

    <h2 class="login-title">Login</h2>
    <p class="login-sub">Masuk ke akun Anda</p>

    <form method="POST" action="{{ route('login') }}">
      @csrf

      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email"
          class="form-control @error('email') is-invalid @enderror"
          placeholder="email@gmail.com" required>
        @error('email')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password"
          class="form-control @error('password') is-invalid @enderror"
          placeholder="••••••••" required>
        @error('password')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3 d-flex justify-content-between align-items-center">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="remember">
          <label class="form-check-label" style="font-size:13px">Ingat saya</label>
        </div>

        <a href="{{ route('password.request') }}" style="font-size:12px">
          Lupa password?
        </a>
      </div>

      <button type="submit" class="btn btn-primary w-100">
        Masuk
      </button>
    </form>

    <div class="text-center mt-3" style="font-size:13px">
      Belum punya akun?
      <a href="{{ route('register') }}">Daftar</a>
    </div>

  </div>
</div>

</body>
</html>