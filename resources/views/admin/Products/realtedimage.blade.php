@extends('layouts.master')

@section('title', 'Product image')

@section('content')
<div class="container mt-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <table class="table table-bordered table-hover text-center">
        <thead class="table-dark">
            <tr>
                <th>Product ID</th>
                <th>Product Images</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $product->id }}</td>

                <!-- Display Product Images -->
                <td>
                    @foreach ($product->images as $image)
                        <div>
                            <a href="{{ asset('uploads/productsimage/' . $image->image_path) }}" target="_blank">
                                <img src="{{ asset('uploads/productsimage/' . $image->image_path) }}" alt="Product Image" class="img-thumbnail" width="50" height="50">
                            </a>

                            <!-- Only Show "Set as Master" Button if it's Not Already Master -->
                            @if(!$image->is_master)
                                <form action="{{ route('admin.product.image.set_master', ['productId' => $product->id, 'imageId' => $image->id]) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-info" title="Set as Master Image">
                                        <i class="fas fa-star"></i> Set as Master
                                    </button>
                                </form>
                            @else
                                <!-- Display a message that this is the master image -->
                                <span class="badge bg-success">Master Image</span>
                            @endif

                            <!-- Delete Image Button -->
                            <form action="{{ route('admin.product.image.delete', ['productId' => $product->id, 'imageId' => $image->id]) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Delete Image">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    @endforeach
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
