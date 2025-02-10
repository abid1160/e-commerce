<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="{{route('website')}}">Kaira 
      @if(Auth::guard('user')->check())
        {{ Auth::guard('user')->user()->name }}
      @else
        
      @endif
    </a>
    

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <form class="d-flex" role="search">
            <input class="form-control me-2" type="search" placeholder="Search products" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
          </form>
        </li>

        <!-- Check if user is logged in -->
        @if (Auth::guard('user')->check())

        @php
        $count = Auth::guard('user')->check() ? Auth::guard('user')->user()->carts()->count() : 0; // Count items in the user's cart
     @endphp
       <li class="nav-item">
        <a class="nav-link" href="{{ route('website') }}">Home</a>
      </li>
     <li class="nav-item">
         <a class="nav-link" href="{{ route('user.cart') }}">
             <i class="bi bi-cart"></i> Cart ({{ $count }})
         </a>
     </li>
     <li class="nav-item">
      <a class="nav-link px-3 py-2" href="{{ route('user.view.order') }}">
          <i class="bi bi-box"></i> View Order
      </a>
  </li>
  
  
        
          <!-- If logged in -->
          <li class="nav-item">
            <a class="nav-link" href="{{ route('user.profile') }}">View Profile</a>
          </li>
          
          <!-- Logout Form -->
          {{-- <li class="nav-item">
            <form action="{{route('user.logout')}}" method="POST">
              @csrf
              <button type="submit" class="btn nav-link">Logout</button>
            </form>
          </li> --}}

        
         
        @else
          <!-- If not logged in -->
          <li class="nav-item">
            <a class="nav-link" href="{{ route('website') }}">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('user.login.form') }}">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('user.register.form') }}">Register</a>
          </li>
        @endif

     
      </ul>
    </div>
  </div>
</nav>
