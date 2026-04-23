<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: sans-serif;
        }

        body {
            height: 100vh;
            background: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* CARD LOGIN */
        .login-container {
            background: #fff;
            padding: 40px;
            width: 350px;
            border-radius: 15px;
            text-align: center;

            /* 🔥 SHADOW HIJAU */
            box-shadow:
                0 10px 30px rgba(0, 0, 0, 0.1),
                0 0 15px rgba(34, 197, 94, 0.5),
                0 0 30px rgba(34, 197, 94, 0.3);

            border: 1px solid rgba(34, 197, 94, 0.3);
        }

        /* LOGO */
        .login-container img {
            width: 60px;
            margin-bottom: 15px;
        }

        .login-container h2 {
            margin-bottom: 5px;
        }

        .login-container p {
            color: gray;
            margin-bottom: 25px;
            font-size: 14px;
        }

        /* INPUT */
        .input-group {
            text-align: left;
            margin-bottom: 15px;
        }

        .input-group label {
            font-size: 13px;
            display: block;
            margin-bottom: 5px;
        }

        .input-group input {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ddd;
            outline: none;
            transition: 0.2s;
        }

        .input-group input:focus {
            border-color: #22c55e;
            box-shadow: 0 0 5px rgba(34, 197, 94, 0.5);
        }

        /* BUTTON */
        .btn-login {
            width: 100%;
            padding: 12px;
            background: #22c55e;
            border: none;
            border-radius: 8px;
            color: white;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
            transition: 0.3s;
        }

        .btn-login:hover {
            background: #16a34a;
            box-shadow: 0 0 10px rgba(34, 197, 94, 0.6);
        }

        /* FOOTER */
        .footer {
            margin-top: 15px;
            font-size: 12px;
            color: gray;
        }

        .footer a {
            color: #22c55e;
            text-decoration: none;
        }
    </style>

</head>

<body>

    <div class="login-container">

        <img src="logo.png" alt="logo">

        <h2>Login</h2>
        <p>Sistem Informasi Pelayanan Publik</p>

        <form method="POST" action="{{ route('admin.login.submit') }}">
            @csrf

            <div class="input-group">
                <label>Username</label>
                <input type="text" name="username" placeholder="Masukkan Username" required>
            </div>

            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Masukkan password" required>
            </div>

            <button type="submit" class="btn-login">Login</button>
        </form>

        <div class="footer">
            Lupa password? <a href="#">Klik di sini</a>
        </div>

    </div>

</body>

</html>
