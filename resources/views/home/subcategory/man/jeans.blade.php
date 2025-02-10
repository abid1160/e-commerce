@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Men's Jeans</h2>
    
    @if ($products->isEmpty())
        <p>No products found in this category.</p>
    @else
        <div class="row">
            @foreach ($products as $product)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <!-- Carousel for Product Images -->
                        <div id="carouselProduct{{ $product->id }}" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @foreach ($product->images as $index => $image)
                                    <div class="carousel-item @if($index === 0) active @endif">
                                        <img src="{{ asset('uploads/productsimage/' . $image->image_path) }}" 
                                             class="d-block w-100" 
                                             alt="Product Image">
                                    </div>
                                @endforeach
                            </div>
                            <!-- Controls for the Carousel -->
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselProduct{{ $product->id }}" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselProduct{{ $product->id }}" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                        <!-- Product Details -->
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{ $product->description }}</p>
                            <p class="card-text"><strong>Price:</strong> ${{ $product->price }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
