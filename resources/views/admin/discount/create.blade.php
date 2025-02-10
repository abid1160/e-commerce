@extends('layouts.master')

@section('content')
<div class="container">
    <h2>Add Discount</h2>
    <form action="{{ route('admin.discount.store') }}" method="POST">
        @csrf
        {{-- Removed coupon input as per requirement --}}

        <div class="mb-3">
            <label>Type</label>
            <select name="type" class="form-control">
                <option value="percentage">Percentage</option>
                <option value="fixed">Fixed Amount</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Amount</label>  <!-- Changed 'Value' to 'Amount' for consistency -->
            <input type="number" name="amount" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Valid From</label>
            <input type="date" name="valid_from" class="form-control">
        </div>

        <div class="mb-3">
            <label>Valid To</label>
            <input type="date" name="valid_to" class="form-control">
        </div>

        <div class="mb-3">
            <label>Active</label>
            <input type="checkbox" name="active" value="1" checked>
        </div>

        <div class="mb-3">
            <label>Select User</label>
            <select name="user_id" class="form-control">
                <option value="">All Users</option>
                @foreach($users as $u) <!-- Changed from $user -->
                    <option value="{{ $u->id }}">{{ $u->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Select Product</label>
            <select name="product_id" class="form-control">
                <option value="">All Products</option>
                @foreach($products as $p) <!-- Changed from $product -->
                    <option value="{{ $p->id }}">
                        {{ $p->product_name ?? 'Unnamed Product' }} 
                        - {{ $p->category->name ?? 'No Category' }} <!-- Ensure category relation exists -->
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Save Discount</button>
    </form>
</div>
@endsection
