<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- FontAwesome for icons -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: #fff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 400px;
        }
        h2 {
            text-align: center;
            margin-bottom: 1rem;
        }
        .form-group {
            margin-bottom: 1rem;
            position: relative;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
        }
        .form-group input {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }
        .form-group .eye-icon {
            position: absolute;
            right: 10px;
            top: 10px;
            cursor: pointer;
        }
        .btn {
            width: 100%;
            padding: 0.75rem;
            border: none;
            background: #007bff;
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn:hover {
            background: #0056b3;
        }
        .alert {
            margin-top: 1rem;
            color: red;
            font-size: 0.9rem;
        }
        @media (max-width: 480px) {
            .container {
                width: 90%;
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Reset Password</h2>

        <!-- Success or Error Messages -->
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <!-- Reset Password Form -->
        <form action="{{ route('resetpassword.submit') }}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" name="email" id="email" placeholder="Enter your email" value="{{ old('email') }}" required>
                @error('email')
                    <div class="alert">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">New Password</label>
                <input type="password" name="password" id="password" placeholder="Enter your new password" required>
                <i class="fas fa-eye eye-icon" id="togglePassword1"></i> <!-- Eye icon -->
                @error('password')
                    <div class="alert">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm your new password" required>
                <i class="fas fa-eye eye-icon" id="togglePassword2"></i> <!-- Eye icon -->
                @error('password_confirmation')
                    <div class="alert">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn">Reset Password</button>
        </form>
    </div>

    <script>
        // Toggle password visibility
        const togglePassword1 = document.getElementById('togglePassword1');
        const password1 = document.getElementById('password');
        
        const togglePassword2 = document.getElementById('togglePassword2');
        const password2 = document.getElementById('password_confirmation');

        togglePassword1.addEventListener('click', function () {
            const type = password1.type === 'password' ? 'text' : 'password';
            password1.type = type;
            togglePassword1.classList.toggle('fa-eye-slash');
        });

        togglePassword2.addEventListener('click', function () {
            const type = password2.type === 'password' ? 'text' : 'password';
            password2.type = type;
            togglePassword2.classList.toggle('fa-eye-slash');
        });
    </script>
</body>
</html>
