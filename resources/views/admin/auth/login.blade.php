<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Admin | SIPASANDI</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #4f46e5;
            --primary-dark: #4338ca;
            --text-dark: #0f172a;
            --text-muted: #64748b;
            --border: #cbd5e1;
            --bg-soft: #eef2ff;
        }

        * {
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            margin: 0;
            min-height: 100vh;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .login-card {
            width: 100%;
            max-width: 900px;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.15);
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        .login-visual img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .login-form {
            padding: 48px 44px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-form h1 {
            font-size: 24px;
            margin: 0;
            color: var(--text-dark);
        }

        .login-form p {
            font-size: 13px;
            margin: 6px 0 28px;
            color: var(--text-muted);
        }

        .alert {
            background: #fee2e2;
            color: #991b1b;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 18px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            font-size: 13px;
            font-weight: 500;
            color: var(--text-dark);
            margin-bottom: 6px;
            display: block;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px 14px;
            border-radius: 10px;
            border: 1px solid var(--border);
            font-size: 14px;
            outline: none;
            transition: .2s;
        }

        input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15);
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: #334155;
            margin: 4px 0 22px;
        }

        .btn {
            width: 100%;
            padding: 13px;
            background: var(--primary);
            color: #ffffff;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            font-size: 14px;
        }

        .footer {
            margin-top: 24px;
            text-align: center;
            font-size: 12px;
            color: var(--text-muted);
        }

        /* ================= RESPONSIVE================= */
       /* Responsive */
        @media (max-width: 768px) {

        body {
            background: linear-gradient(135deg,#fefeff,#6366f1);
        }

        .login-box {
            flex-direction: column;
            width: 100%;
            min-height: 100vh;
            background: transparent;
            box-shadow: none;
        }

        .login-right {
            width: 100%;
            height: 180px;
            border-radius: 0 0 60% 60% / 0 0 18% 18%;
            box-shadow: inset 0 -25px 35px rgba(0, 0, 0, 0.25);
            position: relative;
            overflow: hidden;
            z-index: 1;
            background-size: cover;
            background-position: center;
        }

        .login-right::after {
            display: none;
        }

        .overlay {
            padding: 30px 20px;
            height: 100%;
            backdrop-filter: blur(6px);
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: center;
            border-radius: 0 0 60% 60% / 0 0 18% 18%;
            background: linear-gradient(180deg, rgba(79,70,229,.85), rgba(99,102,241,.9));
            color: #fff;
        }

        .overlay h1 {
            font-size: 20px;
            margin: 0;
            font-weight: 600;
            margin-bottom: 40px;
            letter-spacing: .5px;
        }

        .overlay p {
            display: none;
        }

        .login-left {
            width: 100%;
            background: #fff;
            margin: -80px auto 30px auto;
            padding: 35px 25px 45px 25px;
            border-radius: 60px 60px 0 0;
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.25);
            position: relative;
            z-index: 2;
            animation: fadeUp .6s ease;
        }

        .login-left p {
            color: #666;
            margin-bottom: 28px;
            font-size: 12px;
            text-align: center;
        }

        .logo {
            justify-content: center;
        }

        .logo span {
            font-size: 22px;
            font-weight: 600;
        }

        input {
            border-radius: 12px;
        }

        button {
            border-radius: 12px;
            font-weight: 600;
        }

        @keyframes fadeUp {
            from {
            opacity: 0;
            transform: translateY(25px);
            }
            to {
            opacity: 1;
            transform: translateY(0);
            }
        }
        }
    </style>
</head>
<body>

<div class="login-card">

    <div class="login-visual">
        <img src="{{ asset('images/security-login.png') }}" alt="Login Illustration">
    </div>

    <div class="login-form">
        <h1>SIPASANDI</h1>
        <p>Sistem Informasi Persandian dan Keamanan Informasi</p>

        <form method="POST" action="{{ route('admin.login.submit') }}">
            @csrf

            <div class="form-group">
                <label>Username</label>
               <input type="text" name="username" placeholder="Masukkan username" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Masukkan password" required>
            </div>

            <div class="remember">
                <input type="checkbox">
                <label>Ingat saya</label>
            </div>

            <button class="btn">Masuk</button>
        </form>

        <div class="footer">
            © {{ date('Y') }} SIPASANDI
        </div>
    </div>

</div>

</body>
</html>
