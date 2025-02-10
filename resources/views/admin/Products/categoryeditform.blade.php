@extends('layouts.master')

@section('title', 'Edit category')
 
@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Card for Employee Edit Form -->
            <div class="card shadow-lg">
                <div class="card-header bg-gradient-primary text-white text-center">
                    <h4 class="mb-0">  Edit Category</h4>
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

                    <form action="{{route('admin.product.category.update')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <!-- Hidden input to indicate update operation -->
                        <input type="hidden" name="category_id" value="{{ $category->id }}">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" id="name" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       value="{{ old('name', $category->name) }}" 
                                       placeholder="Enter employee name" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="description" class="form-label">Description</label>
                                <input type="text" name="description" id="Description" 
                                       class="form-control @error('description') is-invalid @enderror" 
                                       value="{{ old('description', $category->description) }}" 
                                       placeholder="Enter description" required>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Profile Image Upload -->
                            <div class="col-md-6 mb-3">
                                <label for="image" class="form-label">Category Image</label>
                                <input type="file" name="image" id="image" 
                                       class="form-control @error('image') is-invalid @enderror">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                @if (!empty($category->image))
                                    <div class="mt-2">
                                        <p>Current Image:</p>
                                        <a href="{{ asset('uploads/categoryimage/' . $category->image) }}" target="_blank">
                                            <img src="{{ asset('uploads/categoryimage/' . $category->image) }}" 
                                                 alt="Category Image" class="img-thumbnail" width="100" height="100">
                                        </a>
                                    </div>
                                @endif

                                <!-- Hidden input to pass old profile path -->
                                <input type="hidden" name="old_image_path" value="{{ $category->image }}">
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">Update Category</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
