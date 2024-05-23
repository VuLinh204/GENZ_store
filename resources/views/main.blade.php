<!DOCTYPE html>
<html lang="en">
<head>
    @include('head')
    @yield('css')
</head>

<body >

<!-- Header -->
@include('header')


@yield('content')

<!-- Footer -->
@include('footer')

</body>
</html>