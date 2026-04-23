<aside class="sidebar" id="sidebar">

    <div>

        <!-- LOGO -->
        <h2 class="logo">
            <img src="{{ asset('img/logo/logo.png') }}" alt="logo">
            <span class="logo-text">SILAPU</span>
        </h2>

        <ul>

            <!-- DASHBOARD -->
            <li class="{{ request()->is('admin/dashboard*') ? 'active' : '' }}">
               <a href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- MASTER DATA -->
            <small class="menu-title">MASTER DATA</small>

            <li class="{{ request()->is('admin/layanan*') ? 'active' : '' }}">
                <a href="{{ route('admin.layanan.index') }}">
                    <i class="fas fa-layer-group"></i>
                    <span>Layanan</span>
                </a>
            </li>

            <li class="{{ request()->is('admin/faq*') ? 'active' : '' }}">
                <a href="{{ route('admin.faq.index') }}">
                    <i class="fas fa-comments"></i>
                    <span>FAQ</span>
                </a>
            </li>

            <!-- OPERASIONAL -->
            <small class="menu-title">OPERASIONAL</small>

            <li class="{{ request()->is('admin/keyword*') ? 'active' : '' }}">
                <a href="{{ route('admin.keyword.index') }}">
                    <i class="fas fa-robot"></i>
                    <span>Auto Response</span>
                </a>
            </li>

            <!-- MONITORING -->
            <small class="menu-title">MONITORING</small>

            <li class="{{ request()->is('admin/chatlog*') ? 'active' : '' }}">
                <a href="{{ route('admin.chatlog.index') }}">
                    <i class="fas fa-comments"></i>
                    <span>Pesan</span>
                </a>
            </li>

            <!-- SISTEM -->
            <small class="menu-title">SISTEM</small>

            <li class="{{ request()->is('admin/user*') ? 'active' : '' }}">
                <a href="{{ route('admin.user.index') }}">
                    <i class="fas fa-users"></i>
                    <span>Pengguna</span>
                </a>
            </li>

            <li>
                <a href="#">
                    <i class="fas fa-cog"></i>
                    <span>Pengaturan</span>
                </a>
            </li>

        </ul>
    </div>

    <!-- PROFILE -->
    <div class="profile">
        <div class="avatar">AD</div>
        <div class="profile-text">
            <strong>Admin</strong><br>
            <small>admin@kominfo.go.id</small>
        </div>
    </div>

</aside>
