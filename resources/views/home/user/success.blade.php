@extends('home.layouts.master')

@section('title', 'Payment Successful')

@section('content')
<div class="container text-center mt-5">
    <div class="card shadow-lg border-success p-4">
        <div class="card-body">
            <h1 class="text-success"><i class="fas fa-check-circle"></i></h1>
            <h2 class="text-success">Payment Successful!</h2>
            <p class="mt-3">Thank you for your purchase. Your payment has been processed successfully.</p>

            <div class="mt-4">
                <a href="{{route('user.view.order')}}" class="btn btn-primary">View Orders</a>
                <a href="{{ route('website') }}" class="btn btn-outline-success">Back to Home</a>
            </div>
        </div>
    </div>
</div>
@endsection
