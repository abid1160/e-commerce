<nav class="navbar navbar-expand-lg navbar-transparent bg-primary navbar-absolute">
  <div class="container-fluid">
    <div class="navbar-wrapper">
      <a class="navbar-brand" href="{{ route('admin.profile') }}">
        Welcome, {{ Auth::guard('admin')->user()->name }}
      </a>
    </div>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-bar"></span>
      <span class="navbar-toggler-bar"></span>
      <span class="navbar-toggler-bar"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navigation">
      <form action="{{ route('admin.user.search') }}" method="GET" class="d-flex">
        <div class="input-group no-border">
            <input type="text" class="form-control" name="search" placeholder="Search user..." value="{{ request('search') }}">
            <div class="input-group-append">
                <div class="input-group-text">
                    <i class="now-ui-icons ui-1_zoom-bold"></i>
                </div>
            </div>
        </div>
      </form>
    
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle d-flex align-items-center" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="now-ui-icons users_single-02 mr-2"></i>
            {{ Auth::guard('admin')->user()->name }}
            <span class="d-lg-none d-md-block">Actions</span>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="{{ route('admin.profile') }}">
              <i class="now-ui-icons users_circle-08 mr-2"></i> View Profile
            </a>
            <a class="dropdown-item" href="{{ route('admin.change.password.form') }}">
              <i class="now-ui-icons ui-1_lock-circle-open mr-2"></i> Change Password
            </a>
            <div class="dropdown-divider"></div>
            <form action="{{ route('admin.logout') }}" method="POST" class="m-0">
              @csrf
              <button type="submit" class="dropdown-item">
                <i class="now-ui-icons media-1_button-power mr-2"></i> Logout
              </button>
            </form>
          </div>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="panel-header panel-header-sm">
  <canvas id="chartCanvas"></canvas> <!-- Specify the canvas ID if needed -->
</div>