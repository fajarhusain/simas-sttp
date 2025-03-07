<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #0f172a, #1e293b);
        }
        .container {
            display: flex;
            max-width: 900px;
            width: 100%;
            background: #1e293b;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(245, 250, 178, 0.3);
        }
        .left-section {
            flex: 2;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px;
            color: white;
        }
        .left-section h2 {
            font-size: 28px;
            margin-bottom: 10px;
        }
        .left-section p {
            font-size: 16px;
            opacity: 0.7;
        }
        .right-section {
            flex: 2;
            background: #0f172a;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 40px;
        }
        .input-group {
            margin-bottom: 20px;
        }
        .input-group label {
            display: block;
            margin-bottom: 6px;
            color: #ccc;
        }
        .input-group input {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: none;
            background: #334155;
            color: white;
            font-size: 14px;
        }
        .input-group input:focus {
            outline: 2px solid #4f46e5;
        }
        .btn-login {
            width: 100%;
            padding: 14px;
            background: #4f46e5;
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
        }
        .btn-login:hover {
            background: #4338ca;
        }
        .forgot-password {
            margin-top: 10px;
            font-size: 14px;
            color: #bbb;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        
        <div class="left-section">

            <div class="app-brand justify-content-center">
                <a href="{{ route('home') }}" class="app-brand-link gap-2">
                    <img src="{{ asset('logo-black.png') }}" alt="{{ config('app.name') }}" srcset="" width="100px">
                </a>
            </div>
            <div class="app-brand justify-content-center" >
                <a href="{{ route('home') }}" class="app-brand-link gap-2">
                    
                </a>
            </div>
            <h2>SIMAS</h2>
              <p style="text-align: center;">Sistem Informasi Manajemen Administrasi Surat</p>
        </div>
        <div class="right-section">
            <form id="formAuthentication" action="{{ route('login') }}" method="POST">
                @csrf
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Masukkan Email Anda" required>
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Masukkan password Anda" required>
                </div>
                <button class="btn-login" type="submit">Masuk</button>
            </form>
            <p class="forgot-password">Lupa Password?</p>
        </div>
    </div>
</body>
</html>