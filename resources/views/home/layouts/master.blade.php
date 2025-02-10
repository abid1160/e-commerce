<!DOCTYPE html>
<html lang="en">

<head>
  <title>@yield('title', 'Kaira')</title>

  @include('home.layouts.style')
</head>

<body class="homepage">
@include('home.layouts.link')

{{-- all thing related to the navbar --}}

@include('home.layouts.navbar')

@yield('content')

@include('home.layouts.footer')
@include('home.layouts.script')

<!-- This is where scripts pushed with @push('scripts') will be included -->
@stack('scripts') <!-- Add this line just before the closing body tag -->

</body>
</html>
