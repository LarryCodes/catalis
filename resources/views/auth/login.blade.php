<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Catalis HR</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Helvetica;
            font-size: 0.875rem;
        }

        body {
            background-color: #f4f3f3;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            background: white;
            border-radius: 4px;
            width: 100%;
            max-width: 340px;
            padding: 32px;
        }

        .login-header {
            margin-bottom: 24px;
        }

        .login-header h1 {
            font-size: 1.1rem;
            color: #000;
            font-weight: 800;
            text-transform: capitalize;
        }

        .login-header p {
            color: #888;
            font-size: 0.75rem;
            margin-top: 4px;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            color: #000;
            font-weight: 500;
        }

        .form-group input {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            font-size: 0.875rem;
            transition: border-color 0.2s;
        }

        .form-group input:focus {
            outline: none;
            border-color: #a3a2a3;
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 6px;
            color: #555;
        }

        .remember-me input[type="checkbox"] {
            width: 14px;
            height: 14px;
        }

        .forgot-password {
            color: #888;
            text-decoration: none;
        }

        .forgot-password:hover {
            color: #000;
        }

        .login-btn {
            width: 100%;
            padding: 12px;
            background-color: #000000;
            border-color: #000000;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .login-btn:hover {
            background-color: #333333;
            border-color: #333333;
        }

        .error-message {
            background: #fff;
            border-left: 2px solid #dc2626;
            color: #dc2626;
            padding: 10px 12px;
            margin-bottom: 16px;
        }

        .error-list {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .status-message {
            background: #fff;
            border-left: 2px solid #16a34a;
            color: #16a34a;
            padding: 10px 12px;
            margin-bottom: 16px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1>Catalis HR</h1>
            <p>Sign in to your account</p>
        </div>

        @if (session('status'))
            <div class="status-message">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="error-message">
                <ul class="error-list">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    required 
                    autofocus
                >
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    required
                >
            </div>

            <div class="remember-forgot">
                <label class="remember-me">
                    <input type="checkbox" name="remember">
                    <span>Remember me</span>
                </label>
                <a href="{{ route('password.request') }}" class="forgot-password">Forgot password?</a>
            </div>

            <button type="submit" class="login-btn">Sign In</button>
        </form>

    </div>
</body>
</html>
