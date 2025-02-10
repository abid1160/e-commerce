@extends('home.layouts.master')

@section('title', 'Checkout')

@section('content')
<div class="container mt-3">
    <h3 class="text-center mb-3 text-primary font-weight-bold">🛒 Checkout</h3>

    @if(session('error'))
        <div class="alert alert-danger mb-3">
            {{ session('error') }}
        </div>
    @endif

    <div class="row">
        <!-- Left Side: Product Details -->
        <div class="col-md-6">
            <div class="card mb-3 shadow-sm border-light">
                <div class="card-body p-2">
                    <h5 class="card-title text-success text-center"><i class="fas fa-user-circle"></i> {{ $user->name }}</h5>
                    <p class="text-muted mb-2"><strong>Email:</strong> {{ $user->email }}</p>
                    <p class="text-muted mb-3"><strong>Phone:</strong> {{ $user->phone_number ?? 'N/A' }}</p>
                </div>
            </div>

            <div class="card shadow-sm border-light">
                <div class="card-body p-2">
                    <h6 class="text-dark">🛍 Your Cart Items</h6>
                    @php
                        $totalPrice = 0;
                    @endphp

                    @foreach($cartItems as $cartItem)
                        @php
                            $subtotal = $cartItem->quantity * $cartItem->product->price;
                            $totalPrice += $subtotal;
                        @endphp
                        <div class="d-flex align-items-center mb-2 p-2 bg-light rounded">
                            <img src="{{ asset('uploads/productsimage/' . $cartItem->image) }}" 
                                 alt="{{ $cartItem->product->product_name }}" 
                                 class="img-fluid rounded" 
                                 style="max-width: 60px;">
                            <div class="ml-2">
                                <p class="mb-0"><strong>{{ $cartItem->product->product_name }}</strong></p>
                                <p class="text-muted mb-0">Qty: {{ $cartItem->quantity }} | ${{ number_format($cartItem->product->price, 2) }}</p>
                                <p class="text-muted mb-1">Subtotal: ${{ number_format($subtotal, 2) }}</p>
                            </div>
                        </div>
                    @endforeach

                    <hr class="my-2">
                    <h5 class="text-right text-danger">
                        <strong>Total:</strong> ${{ number_format($totalPrice, 2) }}
                    </h5>
                </div>
            </div>
        </div>

        <!-- Right Side: Address Details & Add New Address Button -->
        <div class="col-md-6">
            <div class="card shadow-sm border-light mb-3">
                <div class="card-body p-2">
                    <h6 class="text-dark">🏠 Your Address</h6>
                    @if($user->addresses && $user->addresses->count() > 0)
                        <!-- Displaying Addresses as Radio Buttons -->
                        @foreach($user->addresses as $address)
                            <div class="form-check mb-2 p-2 bg-light rounded">
                                <input class="form-check-input" type="radio" name="address" id="address{{ $address->id }}" value="{{ $address->id }}" 
                                       @if($loop->first) checked @endif>
                                <label class="form-check-label" for="address{{ $address->id }}">
                                    <strong>{{ $address->label ?? 'No Label' }}</strong><br>
                                    {{ $address->address }}, {{ $address->city }}, {{ $address->state }}, {{ $address->zip_code }}, {{ $address->country }}
                                </label>
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted mb-2">No address found. Please add one below.</p>
                    @endif
                </div>
            </div>

            <!-- Add New Address Button -->
            <div class="card shadow-sm border-light mb-3">
                <div class="card-body p-2">
                    <button class="btn btn-info btn-sm btn-block" data-toggle="modal" data-target="#addAddressModal">+ Add New Address</button>
                </div>
            </div>

            <!-- Form to Proceed to Payment -->
            <div class="card shadow-sm border-light mb-3">
                <div class="card-body p-2">
                    <!-- Form to submit address and total price to the payment route -->
                    <form action="{{ route('user.payment') }}" method="POST">
                        @csrf
                        @php
                            $shippingId = $user->addresses->first()->id;
                        @endphp
                        
                        <input type="hidden" name="address_id" id="address_id" value="{{ $shippingId }}">
                        <input type="hidden" name="total_price" value="{{ $totalPrice }}">

                        <!-- Discount Checkbox -->
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="applyDiscount" name="apply_discount">
                            <label class="form-check-label" for="applyDiscount">
                                Apply Discount
                            </label>
                        </div>

                        <button type="submit" class="btn btn-info btn-sm btn-block">Proceed Payment</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal to Add New Address -->
<div class="modal fade" id="addAddressModal" tabindex="-1" role="dialog" aria-labelledby="addAddressModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="addAddressModalLabel">Address Form</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('user.addressmodal') }}" method="POST">
                    @csrf
                    <div class="form-group mb-2">
                        <input type="text" class="form-control form-control-sm" name="label" placeholder="Address Label (e.g., Home, Office)">
                    </div>
                    <div class="form-group mb-2">
                        <input type="text" class="form-control form-control-sm" name="address" placeholder="Address" required>
                    </div>
                    <div class="form-group mb-2">
                        <input type="text" class="form-control form-control-sm" name="city" placeholder="City" required>
                    </div>
                    <div class="form-group mb-2">
                        <input type="text" class="form-control form-control-sm" name="state" placeholder="State" required>
                    </div>
                    <div class="form-group mb-2">
                        <input type="text" class="form-control form-control-sm" name="zip_code" placeholder="Zip Code" required>
                    </div>
                    <div class="form-group mb-2">
                        <input type="text" class="form-control form-control-sm" name="country" placeholder="Country" required>
                    </div>
                    <button type="submit" class="btn btn-info btn-sm btn-block">Save Address</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    <!-- jQuery first, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
@endpush
