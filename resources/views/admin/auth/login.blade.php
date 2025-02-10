<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons for Eye icon -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container vh-100 d-flex justify-content-center align-items-center">
        <div>
            <!-- Login Card -->
            <div class="card shadow-lg rounded-3" style="width: 400px;">
                <div class="card-header text-center bg-primary text-white">
                    <h4>Login</h4>
                </div>
                <div class="card-body">
                    <!-- Display Validation Errors -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.login') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="Enter your email" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                                <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                    <i class="bi bi-eye-slash" id="eyeIcon"></i> 
                                </button>
                            </div>
                        </div>

                         
                        
                        <div class="d-grid mb-2">
                            <button type="submit" class="btn btn-primary btn-lg">Login</button>
                        </div>

                        <div class="text-center mt-3">
                            <a href="{{route('forgetpassword')}}" class="text-decoration-none text-muted">Forgot Your Password?</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JavaScript to toggle password visibility -->
    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            var passwordInput = document.getElementById('password');
            var eyeIcon = document.getElementById('eyeIcon');

            // Toggle the input type between password and text
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('bi-eye-slash');
                eyeIcon.classList.add('bi-eye');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('bi-eye');
                eyeIcon.classList.add('bi-eye-slash');
            }
        });
    </script>
</body>
</html>
