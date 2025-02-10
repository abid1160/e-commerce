<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.style')
    <title>
        @yield('title')
    </title>
</head>

<body>
    <div class="wrapper">
        @include('layouts.sidebar')
    </div>
    <div class="main-panel" id="main-panel">
        <!-- Navbar -->
        @include('layouts.navbar')
        <!-- End Navbar -->
        @yield('content')
    </div>

    <!-- Core JS Files -->
    @include('layouts.javascript') <!-- Include global JS files -->
    @stack('scripts') <!-- Allow page-specific scripts to be included -->
</body>

</html>
