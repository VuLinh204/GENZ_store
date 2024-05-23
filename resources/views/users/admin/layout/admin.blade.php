<!DOCTYPE html>
<html>

<head>
    @include('users.admin.partials.head')
    @yield('css')
    <style>
        .header-left .header-search {
            width: 100% !important;
            background: #fff;
            padding-left: 0 !important;
        }

        
    </style>
</head>

<body>
    @include('users.admin.partials.header')
    @include('users.admin.partials.siderbar')


    <div class="mobile-menu-overlay"></div>

    <!--Container-->
    <div class="main-container">
        @yield('search')
        @yield('content')
        @include('users.admin.partials.footer')
    </div>

    @yield('js')

</body>

</html>
