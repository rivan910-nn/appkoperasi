
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - KoperasiKu</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            min-height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f4f7fb;
            color: #243247;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            padding: 35px;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 8px 30px rgba(36, 50, 71, 0.08);
        }

        .login-title {
            font-size: 26px;
            font-weight: 700;
            text-align: center;
            margin-bottom: 8px;
        }

        .login-description {
            text-align: center;
            color: #778196;
            font-size: 14px;
            margin-bottom: 28px;
        }

        .form-label {
            font-weight: 600;
            font-size: 14px;
        }

        .form-control {
            padding: 11px 13px;
            border-radius: 8px;
        }

        .btn-login {
            width: 100%;
            padding: 11px;
            border-radius: 8px;
            background-color: #243247;
            color: white;
            font-weight: 600;
            border: none;
        }

        .btn-login:hover {
            background-color: #354966;
            color: white;
        }

        .forgot-link {
            color: #243247;
            text-decoration: none;
            font-size: 14px;
        }

        .forgot-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="container px-3">
        <div class="login-card mx-auto">

            <div class="login-title">KoperasiKu</div>

            <p class="login-description">
                Silakan masuk ke akun Anda
            </p>

            <x-auth-session-status
                class="alert alert-success mb-3"
                :status="session('status')"
            />

            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    Email atau password tidak sesuai.
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>

                    <input
                        id="email"
                        class="form-control"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Masukkan email"
                        required
                        autofocus
                        autocomplete="username"
                    >

                    @error('email')
                        <div class="text-danger small mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">
                        Password
                    </label>

                    <input
                        id="password"
                        class="form-control"
                        type="password"
                        name="password"
                        placeholder="Masukkan password"
                        required
                        autocomplete="current-password"
                    >

                    @error('password')
                        <div class="text-danger small mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-check mb-3">
                    <input
                        id="remember_me"
                        type="checkbox"
                        class="form-check-input"
                        name="remember"
                    >

                    <label
                        for="remember_me"
                        class="form-check-label small"
                    >
                        Ingat saya
                    </label>
                </div>

                <button type="submit" class="btn btn-login">
                    Login
                </button>

                @if (Route::has('password.request'))
                    <div class="text-center mt-3">
                        <a
                            class="forgot-link"
                            href="{{ route('password.request') }}"
                        >
                            Lupa password?
                        </a>
                    </div>
                @endif
            </form>

        </div>
    </div>

</body>
</html>
