@extends('layouts.master')

@section('title', 'Product Detail')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between mb-3">
                <h3>Product Detail</h3>
                <!-- Added a button to add the product image -->
                <div class="btn-group">
                    <a href="{{ route('admin.product.list') }}" class="btn btn-secondary">Back to Products</a>
                    <a href="{{ route('admin.product.image', $Product->id) }}" class="btn btn-info">Add Product Image</a>
                </div>
            </div>
            <hr>

            <!-- Product Details -->
            <div class="card">
                <div class="card-header">
                    <h4>{{ $Product->product_name }}</h4>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-3">Product Name:</dt>
                        <dd class="col-sm-9">{{ $Product->product_name }}</dd>

                        <dt class="col-sm-3">Price:</dt>
                        <dd class="col-sm-9">${{ number_format($Product->price, 2) }}</dd>

                        <dt class="col-sm-3">Quantity:</dt>
                        <dd class="col-sm-9">{{ $Product->quantity }}</dd>

                        <dt class="col-sm-3">Category:</dt>
                        <dd class="col-sm-9">{{ $Product->category->name }}</dd>

                        <dt class="col-sm-3">Sub-Category:</dt>
                        <dd class="col-sm-9">{{ $Product->subcategory->name }}</dd>

                        <dt class="col-sm-3">Description:</dt>
                        <dd class="col-sm-9">{{ $Product->description ?? 'No description available' }}</dd>
                        
                        <dt class="col-sm-3">Color:</dt>
                        <dd class="col-sm-9">{{ $Product->color ?? 'No color available' }}</dd>

                        <dt class="col-sm-3">Size:</dt>
                        <dd class="col-sm-9">{{ $Product->size ?? 'No size available' }}</dd>

                        <dt class="col-sm-3">Created At:</dt>
                        <dd class="col-sm-9">{{ $Product->created_at->format('d-m-Y H:i') }}</dd>

                        <dt class="col-sm-3">Updated At:</dt>
                        <dd class="col-sm-9">{{ $Product->updated_at->format('d-m-Y H:i') }}</dd>

                        <dt class="col-sm-3">Product Images:</dt>
                        <dd class="col-sm-9">
                            <div class="row">
                                @foreach ($Product->images as $image)
                                <div class="col-md-3">
                                    <div class="card mb-3">
                                        <img src="/uploads/productsimage/{{ $image->image_path }}" class="card-img-top" alt="Product Image">
                                        <div class="card-body text-center">
                                            <form action="{{ route('admin.product.image.delete', $image->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this image?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </dd>
                    </dl>
                </div>
            </div>

            <!-- Discount Details (New Card) -->
            @if($Product->discount)
            <div class="card mt-4">
                <div class="card-header">
                    <h5>Discount Information</h5>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-3">Discount Code:</dt>
                        <dd class="col-sm-9">{{ $Product->discount->code }}</dd>

                        <dt class="col-sm-3">Discount Type:</dt>
                        <dd class="col-sm-9">{{ $Product->discount->type }}</dd>

                        <dt class="col-sm-3">Discount Amount:</dt>
                        <dd class="col-sm-9">${{ number_format($Product->discount->value, 2) }}</dd>

                        <dt class="col-sm-3">Valid From:</dt>
                        <dd class="col-sm-9">{{ $Product->discount->start_date }}</dd>

                        <dt class="col-sm-3">Valid To:</dt>
                        <dd class="col-sm-9">{{ $Product->discount->end_date  }}</dd>

                        <dt class="col-sm-3">Status:</dt>
                        <dd class="col-sm-9">{{ $Product->discount->is_active ? 'Active' : 'Inactive' }}</dd>
                    </dl>
                </div>
            </div>
            @else
            <div class="card mt-4">
                <div class="card-body text-center">
                    <p>No discount available for this product.</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
