<aside class="left-sidebar" data-sidebarbg="skin6">
    <!-- Sidebar scroll -->
    <div class="scroll-sidebar" data-sidebarbg="skin6">

        <!-- Sidebar navigation -->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">

                <!-- Dashboard -->
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ url('/admin/dashboard') }}" aria-expanded="false">
                        <i data-feather="home" class="feather-icon"></i>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>

                <li class="list-divider"></li>

                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ url('/admin/user') }}" aria-expanded="false">
                        <i data-feather="users" class="feather-icon"></i>
                        <span class="hide-menu">User</span>
                    </a>
                </li>

                <li class="list-divider"></li>

                <!-- Layanan -->
                <li class="nav-small-cap">
                    <span class="hide-menu">Layanan</span>
                </li>

                <!-- TTE -->
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ url('/admin/tte') }}" aria-expanded="false">
                        <i data-feather="file-text" class="feather-icon"></i>
                        <span class="hide-menu">TTE</span>
                    </a>
                </li>


                <!-- IKASANDI -->
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                        <i data-feather="shield" class="feather-icon"></i>
                        <span class="hide-menu">IKASANDI</span>
                    </a>

                    <ul aria-expanded="false" class="collapse first-level base-level-line">

                        <li class="sidebar-item">
                            <a href="{{ url('/admin/ikasandi/kategori') }}" class="sidebar-link">
                                <span class="hide-menu">Kategori</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="{{ url('/admin/ikasandi/identifikasi') }}" class="sidebar-link">
                                <span class="hide-menu">Identifikasi</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="{{ url('/admin/ikasandi/proteksi') }}" class="sidebar-link">
                                <span class="hide-menu">Proteksi</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="{{ url('/admin/ikasandi/deteksi') }}" class="sidebar-link">
                                <span class="hide-menu">Deteksi</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="{{ url('/admin/ikasandi/Gulih') }}" class="sidebar-link">
                                <span class="hide-menu">Gulih</span>
                            </a>
                        </li>

                    </ul>
                </li>

                <!-- Cards -->
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ url('/admin/berita') }}" aria-expanded="false">
                        <i data-feather="file-text" class="feather-icon"></i>
                        <span class="hide-menu">Berita Berklasifikasi</span>
                    </a>
                </li>


                <li class="list-divider"></li>

                <!-- Extra -->
                <li class="nav-small-cap">
                    <span class="hide-menu">Laporan</span>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link" href="ui-cards.html" aria-expanded="false">
                        <i data-feather="sidebar" class="feather-icon"></i>
                        <span class="hide-menu">Laporan Insiden</span>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- End Sidebar navigation -->

    </div>
    <!-- End Sidebar scroll -->
</aside>
