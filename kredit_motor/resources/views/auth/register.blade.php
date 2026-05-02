<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background-color: #f8fafc;
      font-family: 'Segoe UI', sans-serif;
    }

    .register-container {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .register-box {
      width: 100%;
      max-width: 420px;
      background: #fff;
      padding: 32px;
      border-radius: 10px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }

    .register-title {
      font-size: 22px;
      font-weight: 600;
      text-align: center;
      margin-bottom: 6px;
    }

    .register-sub {
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

<div class="register-container">
  <div class="register-box">

    <h2 class="register-title">Daftar</h2>
    <p class="register-sub">Buat akun baru</p>

    <form method="POST" action="{{ route('register') }}">
      @csrf

      <div class="mb-3">
        <label class="form-label">Nama Lengkap</label>
        <input type="text" name="name"
          class="form-control @error('name') is-invalid @enderror"
          placeholder="Nama lengkap" required>
        @error('name')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

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
          placeholder="Minimal 8 karakter" required>
        @error('password')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3">
        <label class="form-label">Konfirmasi Password</label>
        <input type="password" name="password_confirmation"
          class="form-control"
          placeholder="Ulangi password" required>
      </div>

      <button type="submit" class="btn btn-primary w-100">
        Daftar
      </button>
    </form>

    <div class="text-center mt-3" style="font-size:13px">
      Sudah punya akun?
      <a href="{{ route('login') }}">Login</a>
    </div>

  </div>
</div>

</body>
</html>   