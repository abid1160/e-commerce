@extends('layouts.master')

@section('title', 'category form')

@section('content') 
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white text-center">
                    <h4>Add New Category</h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form action="{{ route('admin.product.category.insert') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name">Name<span class="text-danger">*</span></label>
                            <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter name" value="{{ old('name') }}"required>
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- City -->
                        <div class="mb-3">
                            <label for="description">Description<span class="text-danger">*</span></label>
                            <input type="text" id="description" name="description" class="form-control @error('description') is-invalid @enderror" placeholder="Description" value="{{ old('Description') }}" required>
                            @error('city')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                  

                        
                        

                        <!-- Salary -->
                   

                        <!-- Profile Picture -->
                        <div class="mb-3">
                            <label for="image">Category Image</label>
                            <div class="input-group">
                                <input type="file" id="image" name="image" class="form-control @error('image') is-invalid @enderror">
                                <button type="button" class="btn btn-outline-secondary" id="clear-profile">Clear</button>
                            </div>
                            @error('image')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-success w-100">Add category</button>
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
