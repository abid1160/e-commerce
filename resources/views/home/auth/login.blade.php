@extends('home.layouts.master')

@section('content')
<div class="container d-flex justify-content-center align-items-center vh-100" style="background-color: #f8f9fa;">
    <div class="card shadow" style="width: 400px;">
        <div class="card-body">
            <h3 class="card-title text-center mb-4">Login</h3>
            <form action="{{ route('user.login.submit') }}" method="POST">
                @csrf
                <!-- Email Input -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="Enter your email" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password Input -->
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Enter your password" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Login Button -->
                <button type="submit" class="btn btn-primary w-100">Login</button>

                <!-- Register Link -->
                <div class="text-center mt-3">
                    <p>Don't have an account? <a href="{{ route('user.register.form') }}">Register here</a></p>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
