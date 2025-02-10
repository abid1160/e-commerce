@extends('layouts.master')

@section('title', 'Edit Product')

@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Card for Product Edit Form -->
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">Edit Product</h4>
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

                    <form action="{{route('admin.product.update')}}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="product_id" value="{{ $Product->id }}">

                        <!-- Category Selection -->
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Category</label>
                            <select name="category_id" id="category_id" class="form-control" required>
                                <option value="">Select a Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                        {{ old('category_id', $Product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Subcategory Selection -->
                        <div class="mb-3">
                            <label for="subcategory_id" class="form-label">Subcategory</label>
                            <select name="subcategory_id" id="subcategory_id" class="form-control" required>
                                <option value="">Select a Subcategory</option>
                                @foreach($subcategories as $subcategory)
                                    <option value="{{ $subcategory->id }}" 
                                        {{ old('subcategory_id', $Product->subcategory_id) == $subcategory->id ? 'selected' : '' }}>{{ $subcategory->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Product Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Product Name</label>
                            <input type="text" name="name" id="name" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name', $Product->product_name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Product Description (Array: Color, Size, Comment) -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Product Description</label>
                            <input type="text" name="description[]" id="color" class="form-control" placeholder="Enter Color" value="{{ old('description.0', $descriptions[0] ?? '') }}">
                            <input type="text" name="description[]" id="size" class="form-control mt-2" placeholder="Enter Size" value="{{ old('description.1', $descriptions[1] ?? '') }}">
                            {{-- <input type="text" name="description[]" id="comment" class="form-control mt-2" placeholder="Enter Comment" value="{{ old('description.2', $descriptions[2] ?? '') }}"> --}}
                        </div>

                        <!-- Product Price -->
                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" name="price" id="price" 
                                   class="form-control @error('price') is-invalid @enderror" 
                                   value="{{ old('price', $Product->price) }}" required>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Product Quantity -->
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" name="quantity" id="quantity" 
                                   class="form-control @error('quantity') is-invalid @enderror" 
                                   value="{{ old('quantity', $Product->quantity) }}" required>
                            @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Update Product</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
