@extends('layouts.master')

@section('content')
    <div class="container">
        <h2>Edit Discount Code</h2>
        <a href="{{ route('admin.discount.create') }}" class="btn btn-primary mb-3">Add Discount</a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow-sm p-4">
            <form action="{{ route('admin.discount.update') }}" method="POST">
                @csrf
                <input type="hidden" name="discount_id" value="{{ $discount->id }}" required>

                <div class="mb-3">
                    <label>User</label>
                    <select name="user_id" class="form-control">
                        <option value="">Select User</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ $discount->user_id == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Select Product</label>
                    <select name="product_id" class="form-control">
                        <option value="">All Products</option>
                        @foreach($products as $p)
                            <option value="{{ $p->id }}" {{ $discount->product_id == $p->id ? 'selected' : '' }}>
                                {{ $p->product_name ?? 'Unnamed Product' }} - {{ $p->category->name ?? 'No Category' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Type</label>
                    <select name="type" class="form-control">
                        <option value="percentage" {{ $discount->type == 'percentage' ? 'selected' : '' }}>Percentage</option>
                        <option value="fixed" {{ $discount->type == 'fixed' ? 'selected' : '' }}>Fixed Amount</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Value</label>
                    <input type="number" name="value" class="form-control" value="{{ $discount->value }}" required>
                </div>

                <div class="mb-3">
                    <label>Valid From</label>
                    <input type="date" name="start_date" class="form-control" value="{{ $discount->start_date }}" required>
                </div>

                <div class="mb-3">
                    <label>Valid To</label>
                    <input type="date" name="end_date" class="form-control" value="{{ $discount->end_date }}" required>
                </div>

                <div class="mb-3">
                    <label>Active Status</label>
                    <select name="is_active" class="form-control">
                        <option value="1" {{ $discount->is_active == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ $discount->is_active == 0 ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-success">Update Discount</button>
            </form>
        </div>
    </div>
@endsection
