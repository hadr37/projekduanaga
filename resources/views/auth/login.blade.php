<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Aplikasi</title>
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
        .register-link {
            text-align: center;
            margin-top: 15px;
        }
        .register-link a {
            color: #2e7d32;
            text-decoration: none;
        }
        .error {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }
        .success {
            color: green;
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>

        @if(session('error'))
            <div class="error">{{ session('error') }}</div>
        @endif

        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <input type="email" name="email" placeholder="Email" required>

            <div class="password-wrapper">
                <input type="password" id="password" name="password" placeholder="Password" required>
                <span onclick="togglePassword()">👁️</span>
            </div>
                <!-- Tambahkan dropdown role
    <select name="role" required style="width: 100%; padding: 12px; margin: 10px 0; border: 1px solid #ccc; border-radius: 5px;">
        <option value="">-- Pilih Role --</option>
        <option value="admin">Admin</option>
        <option value="user">User</option>
    </select> -->

            <button type="submit">Masuk</button>
        </form>

        <div class="register-link">
            Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
        </div>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById("password");
            const icon = event.target;
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
