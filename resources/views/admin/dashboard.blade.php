<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <meta name="description"
          content="adminHMD professional admin dashboard template">

    <title>@yield('title','Dashboard | SILAPU')</title>


    <!-- Bootstrap -->

    <link rel="stylesheet"
          href="{{ asset('assets/css/bootstrap.min.css') }}">


    <!-- Bootstrap Icons -->

    <link rel="stylesheet"
          href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">


    <!-- Main Style -->

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

</head>

<body>

<div class="admin-shell">

    <div class="sidebar-backdrop"
         data-sidebar-close>
    </div>


    {{-- SIDEBAR --}}
    @include('admin.components.sidebar')


    <div class="admin-main">

        {{-- @include('admin.components.navbar') --}}

        @yield('admin')

    </div>

</div>


<!-- Bootstrap JS -->

<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>


<!-- Main JS -->

<script src="{{ asset('assets/js/main.js') }}"></script>

@stack('script')

</body>

</html>
