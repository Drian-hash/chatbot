<header class="topbar" data-navbarbg="skin6">
    <nav class="navbar top-navbar navbar-expand-md">

        <!-- Navbar Header -->
        <div class="navbar-header" data-logobg="skin6">

            <!-- Sidebar toggle (mobile only) -->
            <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)">
                <i class="ti-menu ti-close"></i>
            </a>

            <!-- Logo -->
            <div class="navbar-brand">
                <a href="{{ route('admin.dashboard') }}">
                    <span class="logo-text">
                        <img src="{{ asset('images/logo1.png') }}"
                             alt="logo"
                             style="height: 150px; margin-left: -20px;">
                    </span>
                </a>
            </div>

            <!-- Topbar toggler (mobile only) -->
            <a class="topbartoggler d-block d-md-none waves-effect waves-light"
               href="javascript:void(0)"
               data-toggle="collapse"
               data-target="#navbarSupportedContent">
                <i class="ti-more"></i>
            </a>
        </div>

        <!-- Navbar Content -->
        <div class="navbar-collapse collapse" id="navbarSupportedContent">

            <!-- Left Side -->
            <ul class="navbar-nav float-left mr-auto ml-3 pl-1">
            </ul>

            <!-- Right Side -->
            <ul class="navbar-nav float-right">

                @php
                    $admin = Auth::guard('admin')->user();
                @endphp

                <!-- User Profile -->
                <li class="nav-item dropdown">

                    <a class="nav-link dropdown-toggle d-flex align-items-center"
                       href="javascript:void(0)"
                       data-toggle="dropdown">

                        <!-- FOTO -->
                        <img src="{{ $admin?->foto_url ?? asset('images/default-user.png') }}"
                             class="rounded-circle shadow-sm"
                             width="40" height="40"
                             style="object-fit: cover;">

                        <span class="ml-2 d-none d-lg-inline-block">
                            <span style="font-size:13px;">Hello,</span>
                            <span class="text-dark font-weight-semibold">
                                {{ $admin->name ?? 'Admin' }}
                            </span>
                            <i data-feather="chevron-down" class="svg-icon"></i>
                        </span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY">

                        <!-- My Profile -->
                        <a class="dropdown-item" href="{{ route('admin.profile') }}">
                            <i data-feather="user" class="svg-icon mr-2 ml-1"></i>
                            My Profile
                        </a>

                        <div class="dropdown-divider"></div>

                        <!-- Logout -->
                        <a class="dropdown-item"
                           href="{{ route('admin.logout') }}"
                           onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                            <i data-feather="power" class="svg-icon mr-2 ml-1"></i>
                            Logout
                        </a>

                        <form id="logout-form"
                              action="{{ route('admin.logout') }}"
                              method="POST"
                              style="display: none;">
                            @csrf
                        </form>

                    </div>
                </li>

            </ul>

        </div>
    </nav>
</header>
