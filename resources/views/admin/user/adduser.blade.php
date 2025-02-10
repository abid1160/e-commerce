@extends('layouts.master')

@section('title', 'Add User')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center bg-primary text-white">
                    <h4>Register Form for User</h4>
                </div>
                <div class="card-body">
                    <!-- Display success message -->
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Display error message -->
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('admin.user.form.submit') }}" method="POST">
                        @csrf <!-- Laravel CSRF protection -->

                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" id="name" name="name" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   placeholder="Enter your name" 
                                   value="{{ old('name') }}" 
                                   required>
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   placeholder="Enter your email" 
                                   value="{{ old('email') }}" 
                                   required>
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            <small id="email-error" class="text-danger"></small>
                        </div>

                        <!-- Phone -->
                        <div class="mb-3">
                            <label for="phone_number" class="form-label">Phone Number</label>
                            <input type="text" id="phone_number" name="phone_number" 
                                   class="form-control @error('phone_number') is-invalid @enderror" 
                                   placeholder="Enter your phone number" 
                                   value="{{ old('phone_number') }}" 
                                   required>
                            @error('phone_number')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            <small id="phone-error" class="text-danger"></small>
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password" name="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   placeholder="Enter your password" 
                                   required>
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="text-center">
                            <button type="submit" id="submit-btn" class="btn btn-primary w-100" disabled>Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Email and Phone validation on keyup/blur
    $('#email, #phone_number').on('keyup blur', function() {
        let email = $('#email').val();
        let phone = $('#phone_number').val();

        // AJAX request to check if email or phone number exists
        $.ajax({
            url: "{{route('admin.user.check')}}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                email: email,
                phone_number: phone
            },
            success: function(response) {
                // Email validation
                if (response.email_exists) {
                    $('#email-error').text('Email already exists!');
                    $('#email').addClass('is-invalid');
                } else {
                    $('#email-error').text('');
                    $('#email').removeClass('is-invalid').addClass('is-valid');
                }

                // Phone validation
                if (response.phone_exists) {
                    $('#phone-error').text('Phone number already exists!');
                    $('#phone_number').addClass('is-invalid');
                } else {
                    $('#phone-error').text('');
                    $('#phone_number').removeClass('is-invalid').addClass('is-valid');
                }

                // Enable/Disable the Submit button based on validation
                if (response.email_exists || response.phone_exists) {
                    $('#submit-btn').prop('disabled', true);  // Disable Submit if either exists
                } else {
                    $('#submit-btn').prop('disabled', false);  // Enable Submit if both are valid
                }
            }
        });
    });
});
</script>

@endsection
