 @extends('layouts.master')

@section('title', 'View Profile')

@section('content')
<div class="container mt-5">
    <h2>View Profile</h2>

    <!-- Display Success Message -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.user.update') }}" method="POST">
        @csrf
        <input type="hidden" name="user_id" value="{{ $user->id }}">

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" class="form-control" id="name" value="{{ old('name', $user->name) }}" required>
            @error('name')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" id="email" value="{{ old('email', $user->email) }}" required>
            @error('email')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" name="phone_number" class="form-control" id="phone" value="{{ old('phone_number', $user->phone_number) }}" required>
            @error('phone_number')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Make Changes</button>
    </form>
</div>
@endsection
