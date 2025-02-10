@extends('layouts.master')

@section('title', 'Edit Employee')

@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Card for Employee Edit Form -->
            <div class="card shadow-lg">
                <div class="card-header bg-gradient-primary text-white text-center">
                    <h4 class="mb-0">Edit Employee Details</h4>
                </div>
                <div class="card-body">

                    <!-- Success Message -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Display Errors -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.employee.update', $employee->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <!-- Hidden input to indicate update operation -->
                        <input type="hidden" name="employee_id" value="{{ $employee->id }}">

                        <div class="row">
                            <!-- Employee Name -->
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Employee Name</label>
                                <input type="text" name="name" id="name" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       value="{{ old('name', $employee->name) }}" 
                                       placeholder="Enter employee name" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- City -->
                            <div class="col-md-6 mb-3">
                                <label for="city" class="form-label">City</label>
                                <input type="text" name="city" id="city" 
                                       class="form-control @error('city') is-invalid @enderror" 
                                       value="{{ old('city', $employee->city) }}" 
                                       placeholder="Enter city" required>
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Phone Number -->
                            <div class="col-md-6 mb-3">
                                <label for="phone_number" class="form-label">Phone Number</label>
                                <input type="tel" name="phone_number" id="phone_number" 
                                       class="form-control @error('phone_number') is-invalid @enderror" 
                                       value="{{ old('phone_number', $employee->phone_number) }}" 
                                       placeholder="+123-456-7890" required>
                                @error('phone_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Role -->
                            <div class="col-md-6 mb-3">
                                <label for="role" class="form-label">Role</label>
                                <select id="role" name="role" 
                                        class="form-control @error('role') is-invalid @enderror" required>
                                    <option value="">Select role</option>
                                    <option value="Manager" {{ old('role', $employee->role) == 'Manager' ? 'selected' : '' }}>Manager</option>
                                    <option value="Developer" {{ old('role', $employee->role) == 'Developer' ? 'selected' : '' }}>Developer</option>
                                    <option value="HR" {{ old('role', $employee->role) == 'HR' ? 'selected' : '' }}>HR</option>
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Salary -->
                            <div class="col-md-6 mb-3">
                                <label for="salary" class="form-label">Salary</label>
                                <input type="number" name="salary" id="salary" 
                                       class="form-control @error('salary') is-invalid @enderror" 
                                       value="{{ old('salary', $employee->salary) }}" 
                                       placeholder="Enter salary" required>
                                @error('salary')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Profile Image Upload -->
                            <div class="col-md-6 mb-3">
                                <label for="profile" class="form-label">Profile Image</label>
                                <input type="file" name="profile" id="profile" 
                                       class="form-control @error('profile') is-invalid @enderror">
                                @error('profile')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                @if (!empty($employee->profile_path))
                                    <div class="mt-2">
                                        <p>Current Profile Image:</p>
                                        <a href="{{ asset('uploads/employeeimage/' . $employee->profile_path) }}" target="_blank">
                                            <img src="{{ asset('uploads/employeeimage/' . $employee->profile_path) }}" 
                                                 alt="Employee Image" class="img-thumbnail" width="100">
                                        </a>
                                    </div>
                                @endif

                                <!-- Hidden input to pass old profile path -->
                                <input type="hidden" name="old_profile_path" value="{{ $employee->profile_path }}">
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">Update Employee</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
