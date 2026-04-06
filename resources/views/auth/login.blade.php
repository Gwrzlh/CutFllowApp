<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Cutflow Photography</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #0A3D91; /* Biru sesuai mockup */
            --gold: #D4AF37;
            --text-main: #2D3436;
            --text-muted: #636E72;
            --bg-white: #FFFFFF;
            --input-border: #E0E0E0;
            --error-red: #D63031;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background-color: #F5F6FA;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            width: 90%;
            max-width: 1000px;
            height: 600px;
            background: var(--bg-white);
            border-radius: 20px;
            overflow: hidden;
            display: flex;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        /* Sisi Kiri: Form */
        .login-left {
            flex: 1;
            padding: 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-header h1 {
            font-size: 24px;
            color: var(--text-main);
            margin-bottom: 8px;
            font-weight: 700;
        }

        .login-header p {
            font-size: 14px;
            color: var(--text-muted);
            margin-bottom: 40px;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: var(--text-main);
            margin-bottom: 8px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper input {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid var(--input-border);
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.3s ease;
            outline: none;
        }

        .input-wrapper input:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(10, 61, 145, 0.1);
        }

        .toggle-password {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: var(--text-muted);
            font-size: 18px;
            user-select: none;
        }

        .remember-forgot {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            color: var(--text-muted);
            cursor: pointer;
        }

        .remember-me input {
            cursor: pointer;
        }

        .btn-login {
            background-color: var(--primary-blue);
            color: white;
            border: none;
            padding: 14px;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s ease;
            width: 100%;
            margin-bottom: 20px;
        }

        .btn-login:hover {
            background-color: #08347A;
        }

        .error-message {
            color: var(--error-red);
            font-size: 12px;
            margin-top: 4px;
            display: block;
        }

        /* Sisi Kanan: Brand */
        .login-right {
            flex: 1;
            background-color: var(--primary-blue);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            position: relative;
        }

        .brand-logo {
            width: 80%;
            max-width: 300px;
            text-align: center;
        }

        .brand-logo img {
            width: 100%;
            height: auto;
        }

        /* Placeholder logo jika file tidak ada */
        .logo-placeholder {
            display: flex;
            flex-direction: column;
            align-items: center;
            color: var(--gold);
        }

        .logo-c {
            font-size: 80px;
            font-weight: 700;
            border: 4px solid var(--gold);
            width: 120px;
            height: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin-bottom: 10px;
        }

        .logo-text {
            font-size: 32px;
            font-weight: 700;
            letter-spacing: 2px;
        }

        .logo-subtext {
            font-size: 12px;
            letter-spacing: 4px;
            text-transform: uppercase;
            opacity: 0.8;
        }

        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
                height: auto;
                max-width: 450px;
            }
            .login-right {
                display: none;
            }
            .login-left {
                padding: 40px 30px;
            }
        }
    </style>
</head>
<body>

    <div class="login-container">
        <!-- Sisi Kiri: Form -->
        <div class="login-left">
            <div class="login-header">
                <h1>Selamat Datang</h1>
                <p>Login to access your cutflow account</p>
            </div>

            <form action="{{ url('/login') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label for="email">Masukan Email</label>
                    <div class="input-wrapper">
                        <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Enter your email" required autofocus>
                    </div>
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Kata Sandi</label>
                    <div class="input-wrapper">
                        <input type="password" id="password" name="password" placeholder="Enter your password" required>
                        <span class="toggle-password" id="togglePassword">👁️</span>
                    </div>
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="remember-forgot">
                    <label class="remember-me">
                        <input type="checkbox" name="remember" id="remember">
                        <span>Remember me</span>
                    </label>
                </div>

                <button type="submit" class="btn-login">Login</button>
            </form>
        </div>

        <!-- Sisi Kanan: Brand -->
        <div class="login-right">
            <div class="brand-logo">
                @if(file_exists(public_path('assets/logo-gold.png')))
                    <img src="{{ asset('assets/logo-gold.png') }}" alt="Cutflow Logo">
                @else
                    <div class="logo-placeholder">
                        <div class="logo-c">C</div>
                        <div class="logo-text">cutflow.id</div>
                        <div class="logo-subtext">PHOTOGRAPHY</div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function (e) {
            // toggle the type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            // toggle the eye icon
            this.textContent = type === 'password' ? '👁️' : '🔒';
        });
    </script>
</body>
</html>
