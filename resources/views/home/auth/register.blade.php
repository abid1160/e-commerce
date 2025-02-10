@extends('home.layouts.master')

@section('title', 'User Registration Form')

@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6"> 
            <div class="card">
                <div class="card-header text-center">
                    <h4>User Registration</h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('user.register.form.submit') }}">
                        @csrf
                        
                        <!-- Name -->
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Phone Number -->
                        <div class="form-group">
                            <label for="phone_number">Phone Number</label>
                            <input type="text" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" required>
                            @error('phone_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                        </div>

                        <!-- Address Section -->
                        <div class="address-section mt-4">
                            <h5 class="text-center">Address Details</h5>

                            <div class="form-group">
                                <label for="Label">Place</label>
                                <input type="text" class="form-control @error('label') is-invalid @enderror" id="label" name="label" value="{{ old('label') }}" >
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Address Line 1 -->
                            <div class="form-group">
                                <label for="address">Address </label>
                                <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address') }}" >
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Address Line 2 (Optional) -->
                        

                            <!-- City -->
                            <div class="form-group">
                                <label for="city">City</label>
                                <input type="text" class="form-control @error('city') is-invalid @enderror" id="city" name="city" value="{{ old('city') }}" required>
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- State -->
                            <div class="form-group">
                                <label for="state">State</label>
                                <input type="text" class="form-control @error('state') is-invalid @enderror" id="state" name="state" value="{{ old('state') }}" required>
                                @error('state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Zip Code -->
                            <div class="form-group">
                                <label for="zip_code">Zip Code</label>
                                <input type="text" class="form-control @error('zip_code') is-invalid @enderror" id="zip_code" name="zip_code" value="{{ old('zip_code') }}" required>
                                @error('zip_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Country -->
                            <div class="form-group">
                                <label for="country">Country</label>
                                <input type="text" class="form-control @error('country') is-invalid @enderror" id="country" name="country" value="{{ old('country', 'USA') }}" required>
                                @error('country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group text-center mt-4">
                            <button type="submit" class="btn btn-primary btn-block">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
