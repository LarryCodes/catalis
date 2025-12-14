<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Catalis HR</title>
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

        .forgot-container {
            background: white;
            border-radius: 4px;
            width: 100%;
            max-width: 340px;
            padding: 32px;
        }

        .forgot-header {
            margin-bottom: 24px;
        }

        .forgot-header h1 {
            font-size: 1.1rem;
            color: #000;
            font-weight: 800;
        }

        .forgot-header p {
            color: #888;
            font-size: 0.75rem;
            margin-top: 4px;
            line-height: 1.4;
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

        .submit-btn {
            width: 100%;
            padding: 10px;
            background: radial-gradient(circle at top left, #e6e3e5, #a3a2a3);
            color: #000;
            border: none;
            border-radius: 4px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .submit-btn:hover {
            background: rgb(228, 228, 228);
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
            color: #888;
        }

        .back-link a {
            color: #000;
            text-decoration: none;
        }

        .back-link a:hover {
            text-decoration: underline;
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
    <div class="forgot-container">
        <div class="forgot-header">
            <h1>Forgot Password</h1>
            <p>Enter your email and we'll send you a reset link.</p>
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

        <form method="POST" action="{{ route('password.email') }}">
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

            <button type="submit" class="submit-btn">Send Reset Link</button>
        </form>

        <div class="back-link">
            <a href="{{ route('login') }}">← Back to login</a>
        </div>
    </div>
</body>
</html>
