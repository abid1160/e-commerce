@extends('home.layouts.master')

@section('content')
<div class="container mt-5">
    <h3>{{ Auth::guard('user')->user()->name }}'s profile</h3>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ Auth::guard('user')->user()->name }}</h5>
            <p class="card-text"><strong>Email:</strong> {{ Auth::guard('user')->user()->email }}</p>
            <p class="card-text"><strong>Phone:</strong> {{ Auth::guard('user')->user()->phone_number ?? 'N/A' }}</p>
            @if ($address)
            <p><strong>Address:</strong> {{ $address->address }}</p>
            <p><strong>City:</strong> {{ $address->city }}</p>
            <p><strong>State:</strong> {{ $address->state }}</p>
            <p><strong>Zip Code:</strong> {{ $address->zip_code }}</p>
            <p><strong>Country:</strong> {{ $address->country }}</p>
        @else
            <p>No address available.</p>
        @endif
        
        
        

            <!-- Add any other user details here -->

            <!-- Logout form -->
            <form action="{{ route('user.logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-danger">Logout</button>
                
            </form>
        </div>
    </div>   
</div>   
@endsection
