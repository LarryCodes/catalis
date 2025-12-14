<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Catalis HR</title>
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

        .reset-container {
            background: white;
            border-radius: 4px;
            width: 100%;
            max-width: 340px;
            padding: 32px;
        }

        .reset-header {
            margin-bottom: 24px;
        }

        .reset-header h1 {
            font-size: 1.1rem;
            color: #000;
            font-weight: 800;
        }

        .reset-header p {
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
            margin-top: 8px;
        }

        .submit-btn:hover {
            background: rgb(228, 228, 228);
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
    </style>
</head>
<body>
    <div class="reset-container">
        <div class="reset-header">
            <h1>Reset Password</h1>
            <p>Enter your new password</p>
        </div>

        @if ($errors->any())
            <div class="error-message">
                <ul class="error-list">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="form-group">
                <label for="email">Email</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="{{ old('email', $request->email) }}" 
                    required 
                    autofocus
                >
            </div>

            <div class="form-group">
                <label for="password">New Password</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    required
                >
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input 
                    type="password" 
                    id="password_confirmation" 
                    name="password_confirmation" 
                    required
                >
            </div>

            <button type="submit" class="submit-btn">Reset Password</button>
        </form>
    </div>
</body>
</html>
