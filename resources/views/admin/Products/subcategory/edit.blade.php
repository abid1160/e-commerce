@extends('layouts.master')

@section('title', 'Edit Subcategory')

@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Card for Subcategory Edit Form -->
            <div class="card shadow-lg">
                <div class="card-header bg-gradient-primary text-white text-center">
                    <h4 class="mb-0">Edit Subcategory</h4>
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

                    <form action="{{route('admin.product.subcategory.update')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <!-- Use PUT method for updates -->
                        <!-- Hidden input to indicate update operation -->
                        <input type="hidden" name="subcategory_id" value="{{ $subcategory->id }}">

                        <div class="col-md-6 mb-3">
                            <label for="category_id" class="form-label">Category</label>
                            <select name="category_id" id="category_id" class="form-control" required>
                                <option value="">Select a Category</option>
                                @foreach($categories as $category) <!-- Assuming $categories is passed to the view -->
                                    <option value="{{ $category->id }}" 
                                        {{ old('category_id', $subcategory->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" id="name" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       value="{{ old('name', $subcategory->name) }}" 
                                       placeholder="Enter subcategory name" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="description" class="form-label">Description</label>
                                <input type="text" name="description" id="Description" 
                                       class="form-control @error('description') is-invalid @enderror" 
                                       value="{{ old('description', $subcategory->description) }}" 
                                       placeholder="Enter description" required>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Profile Image Upload -->
                            <div class="col-md-6 mb-3">
                                <label for="image" class="form-label">Subcategory Image</label>
                                <input type="file" name="image" id="image" 
                                       class="form-control @error('image') is-invalid @enderror">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                @if (!empty($subcategory->image))
                                    <div class="mt-2">
                                        <p>Current Image:</p>
                                        <a href="{{ asset('uploads/subcategoryimage/' . $subcategory->image) }}" target="_blank">
                                            <img src="{{ asset('uploads/subcategoryimage/' . $subcategory->image) }}" 
                                                 alt="Category Image" class="img-thumbnail" width="100" height="100">
                                        </a>
                                    </div>
                                @endif

                                <!-- Hidden input to pass old profile path -->
                                <input type="hidden" name="old_image_path" value="{{ $subcategory->image }}">
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">Update Subcategory</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
