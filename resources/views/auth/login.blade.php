<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Login</title>
    <style>
        :root{
            --card-width: 420px;
            --green: #28a745;
            --green-dark: #218838;
            --muted: #888;
            --bg: #f3f4f5;
        }

        *{box-sizing:border-box}
        body{
            margin:0;
            font-family: Inter, "Segoe UI", Roboto, Arial, sans-serif;
            background: var(--bg);
            display:flex;
            align-items:center;
            justify-content:center;
            min-height:100vh;
        }

        .card{
            width: min(var(--card-width), 92%);
            background:#fff;
            border-radius:12px;
            box-shadow: 0 8px 28px rgba(17,17,17,0.08);
            padding:28px;
        }

        .card h1{
            margin:0 0 18px;
            text-align:center;
            font-size:22px;
            letter-spacing:0.2px;
        }

        .msg {
            padding:8px 12px;
            border-radius:8px;
            margin-bottom:12px;
            font-size:14px;
        }
        .msg.error { background:#ffecec; color:#b30000; }
        .msg.success { background:#e8f8ed; color:#1b7a3d; }

        form { display:flex; flex-direction:column; gap:12px; }

        .field {
            display:block;
        }

        .input-group{
            display:flex;
            align-items:center;
            gap:8px;
            border:1px solid #e0e0e0;
            border-radius:8px;
            padding:6px 10px;
            background:#fff;
            transition: border-color .15s;
        }
        .input-group:focus-within{ border-color:#d0d0d0; box-shadow: 0 0 0 3px rgba(40,167,69,0.04); }

        .input-group input{
            border:0;
            outline:0;
            flex:1;
            padding:10px 6px;
            font-size:14px;
            background:transparent;
        }

        .input-group button.icon-btn{
            display:inline-flex;
            align-items:center;
            justify-content:center;
            width:36px;
            height:36px;
            border-radius:6px;
            border:0;
            background:transparent;
            cursor:pointer;
            color:var(--muted);
        }
        .input-group button.icon-btn:hover { background: rgba(0,0,0,0.03); }

        .btn {
            display:inline-block;
            width:100%;
            padding:12px 14px;
            border-radius:8px;
            border:0;
            cursor:pointer;
            color:#fff;
            background:var(--green);
            font-weight:600;
            font-size:15px;
        }
        .btn:hover{ background:var(--green-dark); }

        .meta {
            margin-top:6px;
            text-align:center;
            font-size:14px;
            color:#666;
        }
        .meta a { color:var(--green); text-decoration:none; font-weight:600; }

        /* responsive tiny */
        @media (max-width:420px){
            .card{ padding:18px; border-radius:10px; }
        }
    </style>
</head>
<body>
    <div class="card" role="main" aria-labelledby="login-title">
        <h1 id="login-title">Login</h1>

        {{-- session message --}}
        @if(session('error'))
            <div class="msg error">{{ session('error') }}</div>
        @endif
        @if(session('success'))
            <div class="msg success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('login') }}" method="POST" autocomplete="on" novalidate>
            @csrf

            <label class="field" for="email" style="display:none">Email</label>
            <div class="input-group" aria-hidden="false">
                <input id="email" type="email" name="email" placeholder="Email" value="{{ old('email') }}" required autocomplete="email" />
            </div>

            <label class="field" for="password" style="display:none">Password</label>
            <div class="input-group" style="position:relative;">
                <input id="password" type="password" name="password" placeholder="Password" required autocomplete="current-password" />
                <button type="button" class="icon-btn" id="togglePassword" aria-label="Tampilkan password" title="Tampilkan password">
                    <!-- Eye SVG (default: closed eye will be replaced by JS when toggled) -->
                    <svg id="iconEye" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                </button>
            </div>

            <button type="submit" class="btn">Login</button>
        </form>

        <div class="meta">
            Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
        </div>
    </div>

    <script>
        (function(){
            const input = document.getElementById('password');
            const toggle = document.getElementById('togglePassword');
            const icon = document.getElementById('iconEye');

            const eyeOpen = `<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                <circle cx="12" cy="12" r="3"></circle>
            </svg>`;

            const eyeClosed = `<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17.94 17.94A10.94 10.94 0 0 1 12 20c-7 0-11-8-11-8a20.11 20.11 0 0 1 5-5"></path>
                <path d="M1 1l22 22"></path>
            </svg>`;

            // start with eyeOpen (masked)
            toggle.innerHTML = eyeOpen;
            toggle.setAttribute('aria-pressed', 'false');

            toggle.addEventListener('click', function(){
                const isPassword = input.type === 'password';
                if(isPassword){
                    input.type = 'text';
                    toggle.innerHTML = eyeClosed;
                    toggle.setAttribute('aria-pressed', 'true');
                    toggle.setAttribute('aria-label', 'Sembunyikan password');
                    toggle.title = 'Sembunyikan password';
                } else {
                    input.type = 'password';
                    toggle.innerHTML = eyeOpen;
                    toggle.setAttribute('aria-pressed', 'false');
                    toggle.setAttribute('aria-label', 'Tampilkan password');
                    toggle.title = 'Tampilkan password';
                }
                // keep focus on input for UX
                input.focus();
            });

            // Optional: allow toggle by pressing End key when focused on input
            input.addEventListener('keydown', function(e){
                if(e.key === 'End'){ // example: End toggles; remove if undesired
                    e.preventDefault();
                    toggle.click();
                }
            });
        })();
    </script>
</body>
</html>
