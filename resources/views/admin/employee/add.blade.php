@extends('layouts.master')

@section('title', 'Add Employee')

@section('content') 
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white text-center">
                    <h4>Add New Employee</h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form action="{{ route('admin.employee.insert') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name">Name <span class="text-danger">*</span></label>
                            <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter name" value="{{ old('name') }}"required>
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- City -->
                        <div class="mb-3">
                            <label for="name">City<span class="text-danger">*</span></label>
                            <input type="text" id="city" name="city" class="form-control @error('city') is-invalid @enderror" placeholder="Enter city" value="{{ old('city') }}" required>
                            @error('city')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Phone Number -->
                        <div class="mb-3">
                            <label for="name">Phone number <span class="text-danger">*</span></label>
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
                            <div id="phone-error" class="text-danger"></div> <!-- Error message display -->
                        </div>

                        <!-- Role -->
                        <div class="mb-3">
                            <label for="name">Role <span class="text-danger">*</span></label>
                            <select id="role" name="role" class="form-control @error('role') is-invalid @enderror" required>
                                <option value="">Select role</option>
                                <option value="Manager" {{ old('role') == 'Manager' ? 'selected' : '' }}>Manager</option>
                                <option value="Developer" {{ old('role') == 'Developer' ? 'selected' : '' }}>Developer</option>
                                <option value="HR" {{ old('role') == 'HR' ? 'selected' : '' }}>HR</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        

                        <!-- Salary -->
                        <div class="mb-3">
                            <label for="name">Salary <span class="text-danger">*</span></label>
                            <input type="number" id="salary" name="salary" class="form-control @error('salary') is-invalid @enderror" placeholder="Enter salary"value="{{ old('salary') }}" required>
                            @error('salary')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Profile Picture -->
                        <div class="mb-3">
                            <label for="profile">Profile Picture</label>
                            <div class="input-group">
                                <input type="file" id="profile" name="profile" class="form-control @error('profile') is-invalid @enderror">
                                <button type="button" class="btn btn-outline-secondary" id="clear-profile">Clear</button>
                            </div>
                            @error('profile')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-success w-100">Add Employee</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#phone_number').on('keyup blur', function() {
            let phone_number = $(this).val();

            // AJAX request to check if the phone number exists
            $.ajax({
                url: "{{ route('admin.employee.check') }}", // Route to your controller method
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",  // CSRF token for security
                    phone_number: phone_number
                },
                success: function(response) {
                    if (response.phone_exists) {
                        $('#phone-error').text('Phone number already exists!');
                        $('#phone_number').addClass('is-invalid');
                    } else {
                        $('#phone-error').text('');
                        $('#phone_number').removeClass('is-invalid').addClass('is-valid');
                    }
                },
                error: function(xhr, status, error) {
                    console.log(error); // Handle any AJAX error
                }
            });
        });
    });
</script>

@endsection
