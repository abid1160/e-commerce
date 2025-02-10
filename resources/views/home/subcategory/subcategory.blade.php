@extends('home.layouts.master')

@section('title', 'Subcategories')

@section('content')
<h3>{{ $category->name }}</h3>

<div class="container mt-5">
    @if ($subcategory->isEmpty())  
        <p>No subcategories found for this category.</p>
    @else
        <div class="row">
            @foreach ($subcategory as $sub)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="{{ asset('uploads/subcategoryimage/' . $sub->image) }}" class="card-img-top img-fluid" alt="{{ $sub->name }}" style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $sub->name }}</h5>
                            <p class="card-text">{{ $sub->description ?? 'No description available' }}</p>
                            <a href="{{ route('product', ['category_id' => $category->id, 'subcategory_id' => $sub->id]) }}" class="btn btn-primary">Products </a>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
