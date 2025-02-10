@extends('home.layouts.master')

@section('title', 'My Orders')

@section('content')
<div class="container py-3">
    <h2 class="mb-4">Your Orders</h2>

    @if (empty($orderDetails))
        <div class="alert alert-warning text-center">No orders found.</div>
    @else
        @foreach ($orderDetails as $detail)
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Order ID: {{ $detail['order']->id }}</h5>
                </div>
                <div class="card-body">
                    <p><strong>Order Date:</strong> {{ $detail['order']->created_at->format('d M Y, h:i A') }}</p>

                    <div class="row align-items-center">
                        <div class="col-md-3 text-center">
                            @if ($detail['image'])
                                <img src="{{ asset('uploads/productsimage/' . $detail['image']->image_path) }}" 
                                     alt="Product Image" 
                                     class="img-fluid rounded" 
                                     style="max-width: 150px;">
                            @else
                                <div class="alert alert-info">No image available.</div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h5 class="mb-1">{{ $detail['product']->product_name }}</h5>
                            <p class="mb-1"><strong>Quantity:</strong> {{ $detail['orderItem']->quantity }}</p>
                            <p class="mb-1"><strong>Price:</strong> ${{ number_format($detail['product']->price, 2) }}</p>
                            <h5 class="mb-1">Status: {{ $detail['order']->status }}</h5>
                        </div>
                        @if($detail['order']->status == 'pending') 
                            <div class="col-md-1 text-end">
                                <form action="{{ route('user.order.delete', $detail['order']->id) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-danger btn-sm">Cancel</button>
                                </form>
                            </div>
                        @endif
                        </div>
                        
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection

@push('scripts')
<script>
    console.log('Order details page loaded.');
</script>

 
@endpush
