<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Aplikasi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            background: #e8f5e9;
            font-family: Arial, sans-serif;
        }
        .container {
            width: 100%;
            max-width: 400px;
            margin: 80px auto;
            padding: 30px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #2e7d32;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        .password-wrapper {
            position: relative;
        }
        .password-wrapper span {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            user-select: none;
        }
        button {
            background: #2e7d32;
            color: white;
            padding: 12px;
            width: 100%;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background: #1b5e20;
        }
        .login-link {
            text-align: center;
            margin-top: 15px;
        }
        .login-link a {
            color: #2e7d32;
            text-decoration: none;
        }
        .error {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Register</h2>

        @if ($errors->any())
            <div class="error">
                @foreach ($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf
            <input type="text" name="name" placeholder="Nama Lengkap" required>
            <input type="email" name="email" placeholder="Email" required>

            <div class="password-wrapper">
                <input type="password" id="password" name="password" placeholder="Password" required>
                <span onclick="togglePassword('password', this)">👁️</span>
            </div>
            <div class="password-wrapper">
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Password Konfirmasi" required>
                <span onclick="togglePassword('password_confirmation', this)">👁️</span>
            </div>

            <button type="submit">Daftar</button>
        </form>

        <div class="login-link">
            Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>
        </div>
    </div>

    <script>
        function togglePassword(id, icon) {
            const input = document.getElementById(id);
            if (input.type === "password") {
                input.type = "text";
                icon.textContent = "🙈";
            } else {
                input.type = "password";
                icon.textContent = "👁️";
            }
        }
    </script>
</body>
</html>
