<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Forgot Password</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow-lg p-4" style="max-width: 400px; width: 100%;">
            <div class="card-body">
                <h3 class="card-title text-center mb-4">Forgot Password</h3>
                
                <!-- Display success message if status is available -->
                @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="" method="POST" onsubmit="return showModal()">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="Enter your email" required>
                        @error('email')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Send Password Reset Link</button>
                </form>
                <div class="text-center mt-3">
                    <a href="{{ route('login.form') }}" class="text-decoration-none">Back to Login</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Password Reset Link Sent</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    We have e-mailed your password reset link!
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Function to show the modal
        function showModal() {
            var myModal = new bootstrap.Modal(document.getElementById('successModal'), {
                keyboard: false
            });
            myModal.show();
            return true; // Allow the form to submit
        }
    </script>
</body>
</html>
