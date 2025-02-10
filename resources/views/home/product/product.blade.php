@extends('home.layouts.master')

@section('title', 'Products')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Products</h1>

    @if($products->isEmpty())
        <p>No products found for this category and subcategory.</p>
    @else
        <div class="row">
            @foreach($products as $product)
                <!-- Find discount for this product -->
                @php
                    $discount = $discounts->where('product_id', $product->id)->first();
                    $discountedPrice = $product->price;

                    if ($discount) {
                        if ($discount->type == 'percentage') {
                            $discountedPrice = $product->price - ($product->price * $discount->value / 100);
                        } elseif ($discount->type == 'fixed') {
                            $discountedPrice = max($product->price - $discount->value, 0); // Ensure price doesn't go negative
                        }
                    }
                @endphp

                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <!-- Image Slider (Carousel) -->
                        @if($product->images->isNotEmpty())
                            <div id="carousel{{ $product->id }}" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    @foreach($product->images as $index => $image)
                                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                            <img 
                                                src="{{ asset('uploads/productsimage/' . $image->image_path) }}" 
                                                class="d-block w-100" 
                                                alt="{{ $product->name }}">
                                        </div>  
                                    @endforeach
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carousel{{ $product->id }}" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carousel{{ $product->id }}" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        @else
                            <!-- Default Image if No Images Exist -->
                            <img 
                                src="{{ asset('home/assets/images/default-product.png') }}" 
                                class="card-img-top" 
                                alt="Default Image">
                        @endif

                        <!-- Card Body -->
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{ $product->description ?? 'No description available' }}</p>
                            <h5 class="card-title">{{ $product->color }}</h5>
                            <h5 class="card-title">{{ $product->size }}</h5>

                            <!-- Show Price with Discount -->
                            @if($discount)
                                <p class="card-text">
                                    <strong>Original Price:</strong> 
                                    <span class="text-muted text-decoration-line-through">${{ number_format($product->price, 2) }}</span>
                                </p>
                                <p class="card-text">
                                    <strong>Discounted Price:</strong> 
                                    <span class="text-success">${{ number_format($discountedPrice, 2) }}</span>
                                </p>
                                <p class="card-text text-danger">
                                    <strong>Discount Applied:</strong> 
                                    {{ $discount->type == 'percentage' ? $discount->value . '%' : '$' . number_format($discount->value, 2) }} off
                                </p>
                            @else
                                <p class="card-text">
                                    <strong>Price:</strong> ${{ number_format($product->price, 2) }}
                                </p>
                            @endif
                        </div>

                        <!-- Card Footer -->
                        <div class="card-footer">
                            <a href="{{ route('user.add.cart', $product->id) }}" class="btn btn-primary">  
                                Add to Cart
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
