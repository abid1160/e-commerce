@extends('layouts.master')


@section('title','admin change password')

@section('content')
<div class="container">
    <h2>Change Password</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{route('admin.change.password')}}" method="POST">
        @csrf

        <div class="form-group">
            <label for="old_password">Old Password</label>
            <input type="password" class="form-control @error('old_password') is-invalid @enderror" name="old_password" required>
            @error('old_password')
                <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="new_password">New Password</label>
            <input type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password" required>
            @error('new_password')
                <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="new_password_confirmation">Confirm New Password</label>
            <input type="password" class="form-control" name="new_password_confirmation" required>
        </div>

        <button type="submit" class="btn btn-primary">Change Password</button>
    </form>
</div>
@endsection
