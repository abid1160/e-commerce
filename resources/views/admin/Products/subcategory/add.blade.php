<!-- resources/views/subcategories/create.blade.php -->
@extends('layouts.master') <!-- Adjust this to your layout file -->

@section('content')
<div class="container">
    <h1>Create Subcategory</h1>
    <form action="{{route('admin.product.subcategory.insert')}}" method="POST" enctype="multipart/form-data">
        @csrf <!-- CSRF Token for form security -->

        <!-- Category Selection -->
        <div class="mb-3">
            @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
            <label for="category_id" class="form-label">Category</label>
            <select name="category_id" id="category_id" class="form-control" required>
                <option value="">Select a Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Subcategory Name -->
        <div class="mb-3">
            <label for="name" class="form-label">Subcategory Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <!-- Subcategory Description -->
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control"></textarea>
        </div>

        <!-- Subcategory Image -->
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="file" name="image" id="image" class="form-control">
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Create Subcategory</button>
    </form>
</div>
@endsection
