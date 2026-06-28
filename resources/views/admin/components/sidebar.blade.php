<aside class="admin-sidebar" id="adminSidebar" aria-label="Main navigation">

    <div class="sidebar-header">
        <a class="brand-mark" href="{{ route('admin.dashboard') }}">
            <div class="brand-icon logo-container">
                <img src="{{ asset('img/logo/logo.png') }}" alt="SILAPU Logo" class="sidebar-logo">
            </div>
            <div class="brand-copy">
                <span class="brand-title">SILAPU</span>

                <button class="sidebar-theme-toggle" type="button" id="themeToggle">
                    <span class="theme-label light-label">
                        <i class="bi bi-sun-fill"></i> Light
                    </span>
                    <div class="toggle-switch">
                        <div class="toggle-dot"></div>
                    </div>
                    <span class="theme-label dark-label">
                        <i class="bi bi-moon-stars-fill"></i> Dark
                    </span>
                </button>
            </div>
        </a>
    </div>

    <nav class="sidebar-nav">
        <a class="nav-link {{ request()->is('admin/dashboard*') ? 'active' : '' }}"
            href="{{ route('admin.dashboard') }}">
            <span class="nav-icon">
                <i class="bi bi-house-door"></i>
            </span>
            <span class="nav-text">Dashboard</span>
        </a>

        <small class="menu-title">Master Data</small>

        <a class="nav-link {{ request()->is('admin/layanan*') ? 'active' : '' }}"
            href="{{ route('admin.layanan.index') }}">
            <span class="nav-icon">
                <i class="bi bi-grid"></i>
            </span>
            <span class="nav-text">Layanan</span>
        </a>

        <a class="nav-link {{ request()->is('admin/faq*') ? 'active' : '' }}" href="{{ route('admin.faq.index') }}">
            <span class="nav-icon">
                <i class="bi bi-question-circle"></i>
            </span>
            <span class="nav-text">FAQ</span>
        </a>

        <small class="menu-title">Layanan Publik</small>

        <a class="nav-link {{ request()->is('admin/permohonan*') ? 'active' : '' }}"
            href="{{ route('admin.permohonan.index') }}">
            <span class="nav-icon">
                <i class="bi bi-file-earmark-text"></i>
            </span>
            <span class="nav-text">Permohonan</span>
        </a>

        <a class="nav-link {{ request()->is('admin/percakapan*') ? 'active' : '' }}"
            href="{{ route('admin.chatlog.index') }}">
            <span class="nav-icon">
                <i class="bi bi-chat-dots"></i>
            </span>
            <span class="nav-text">Percakapan</span>
        </a>

        <small class="menu-title">Monitoring</small>

        <a class="nav-link {{ request()->is('admin/user*') ? 'active' : '' }}" href="{{ route('admin.user.index') }}">
            <span class="nav-icon">
                <i class="bi bi-people"></i>
            </span>
            <span class="nav-text">Pengguna</span>
        </a>
    </nav>

    <div class="sidebar-profile-wrapper">
        <div class="sidebar-profile">
            <div class="profile-avatar">AD</div>
            <div class="profile-info">
                <div class="profile-name">Admin Hasan</div>
                <div class="profile-email">admin@kominfo.go.id</div>
            </div>
            <div class="profile-dropdown">
                <i class="bi bi-chevron-right"></i>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="bi bi-box-arrow-right"></i> Log Out
            </button>
        </form>
    </div>

</aside>

<style>
    /* =====================================
        GLOBAL SIDEBAR STRUCTURE
    ===================================== */
    .admin-sidebar {
        width: 280px;
        height: 100vh;
        display: flex;
        flex-direction: column;
        background: linear-gradient(180deg, #0b3d2e 0%, #0f5132 35%, #146c43 75%, #198754 100%);
        border-right: 1px solid rgba(255, 255, 255, .08);
        box-shadow: 0 10px 35px rgba(0, 0, 0, .18);
        transition: background .3s ease;
    }

    /* =====================================
        HEADER & LOGO
    ===================================== */
    .sidebar-header {
        padding: 16px 18px;
        /* Dikurangi dari 24px agar lebih padat */
        border-bottom: 1px solid rgba(255, 255, 255, .08);
    }

    .brand-mark {
        display: flex;
        align-items: center;
        gap: 14px;
        text-decoration: none;
    }

    .logo-container {
        width: 48px;
        /* Dioptimalkan dari 52px */
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.12);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        padding: 6px;
        box-shadow: inset 0 2px 4px rgba(255, 255, 255, 0.1), 0 4px 12px rgba(0, 0, 0, 0.1);
        transition: transform .3s ease, background .3s ease;
    }

    .brand-mark:hover .logo-container {
        transform: scale(1.04);
        background: rgba(255, 255, 255, 0.18);
    }

    .sidebar-logo {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .brand-copy {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .brand-title {
        font-size: 18px;
        /* Disesuaikan sedikit dari 20px */
        font-weight: 800;
        color: #ffffff;
        letter-spacing: 0.8px;
        line-height: 1.2;
    }

    /* =====================================
        THEME SWITCH
    ===================================== */
    .sidebar-theme-toggle {
        display: flex;
        align-items: center;
        gap: 6px;
        width: fit-content;
        padding: 2px 6px;
        border-radius: 30px;
        border: 1px solid rgba(255, 255, 255, .1);
        background: rgba(255, 255, 255, .06);
        backdrop-filter: blur(10px);
        cursor: pointer;
        transition: all .3s ease;
    }

    .sidebar-theme-toggle:hover {
        background: rgba(255, 255, 255, .12);
    }

    .theme-label {
        display: flex;
        align-items: center;
        gap: 4px;
        font-size: 9px;
        font-weight: 600;
    }

    .light-label {
        color: #ffffff;
    }

    .dark-label {
        color: rgba(255, 255, 255, .4);
    }

    .toggle-switch {
        width: 28px;
        height: 14px;
        background: rgba(255, 255, 255, .15);
        border-radius: 30px;
        position: relative;
    }

    .toggle-dot {
        width: 10px;
        height: 10px;
        background: white;
        border-radius: 50%;
        position: absolute;
        top: 2px;
        left: 2px;
        transition: all .3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* =====================================
        NAVIGATION MENU & LINKS (COMPACTED)
    ===================================== */
    .sidebar-nav {
        flex: 1;
        padding: 10px 12px;
        /* Dikurangi dari 16px */
        display: flex;
        flex-direction: column;
        gap: 2px;
        /* Jarak antar tombol dipersempit */
        overflow-y: auto;
        scrollbar-width: none;
    }

    .sidebar-nav::-webkit-scrollbar {
        display: none;
    }

    .menu-title {
        margin: 10px 0 4px 12px;
        /* Jarak atas dipangkas dari 16px ke 10px */
        font-size: 10px;
        /* Ukuran teks diperkecil agar proporsional */
        font-weight: 700;
        letter-spacing: 1.2px;
        text-transform: uppercase;
        color: rgba(255, 255, 255, .45);
    }

    .nav-link {
        display: flex;
        align-items: center;
        gap: 12px;
        min-height: 40px;
        /* Dipersempit dari 48px agar muat dalam 1 layar */
        padding: 6px 12px;
        /* Padding dikurangi */
        border-radius: 10px;
        text-decoration: none;
        color: rgba(255, 255, 255, 0.8);
        transition: all .25s ease;
    }

    .nav-icon {
        width: 30px;
        /* Diperkecil dari 34px */
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        background: rgba(255, 255, 255, .08);
        color: white;
        font-size: 14px;
        transition: all .25s ease;
    }

    .nav-text {
        font-size: 13.5px;
        font-weight: 500;
        color: rgba(255, 255, 255, 0.9);
    }

    /* Hover State */
    .nav-link:hover {
        background: rgba(255, 255, 255, .08);
        color: #ffffff;
        transform: translateX(4px);
    }

    .nav-link:hover .nav-icon {
        background: rgba(255, 255, 255, 0.16);
        transform: scale(1.05);
    }

    /* Active State */
    .nav-link.active {
        background: #ffffff;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .nav-link.active .nav-icon {
        background: #198754;
        color: #ffffff;
    }

    .nav-link.active .nav-text {
        color: #0f5132;
        font-weight: 700;
    }

    /* =====================================
        USER PROFILE FOOTER
    ===================================== */
    .sidebar-profile-wrapper {
        margin-top: auto;
        padding: 12px 0;
        /* Dikurangi dari 16px */
        border-top: 1px solid rgba(255, 255, 255, .08);
        background: rgba(0, 0, 0, 0.05);
    }

    .sidebar-profile {
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 0 14px 8px;
        /* Margin bottom dikurangi dari 12px ke 8px */
        padding: 8px 12px;
        /* Diperpadat */
        border-radius: 12px;
        background: rgba(255, 255, 255, .06);
        border: 1px solid rgba(255, 255, 255, .06);
    }

    .profile-avatar {
        width: 34px;
        /* Diperkecil dari 38px */
        height: 34px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        font-weight: 700;
        background: linear-gradient(135deg, #ffffff, #e5e7eb);
        color: #0f5132;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

    .profile-info {
        flex: 1;
        overflow: hidden;
    }

    .profile-name {
        font-size: 12.5px;
        font-weight: 600;
        color: #ffffff;
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
    }

    .profile-email {
        font-size: 10.5px;
        color: rgba(255, 255, 255, .6);
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
    }

    .profile-dropdown {
        color: rgba(255, 255, 255, .4);
        font-size: 12px;
    }

    /* =====================================
        LOGOUT BUTTON
    ===================================== */
    .logout-btn {
        width: calc(100% - 28px);
        margin: 0 14px;
        padding: 8px;
        /* Dikurangi dari 11px agar menghemat ruang vertikal */
        border: none;
        border-radius: 10px;
        cursor: pointer;
        font-size: 12.5px;
        font-weight: 700;
        color: #ffffff;
        background: linear-gradient(135deg, #ef4444, #dc2626);
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all .25s ease;
    }

    .logout-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(220, 38, 38, 0.35);
        background: linear-gradient(135deg, #f87171, #dc2626);
    }

    /* =====================================
        DARK MODE THEMING
    ===================================== */
    [data-theme="dark"] .admin-sidebar {
        background: linear-gradient(180deg, #111b21 0%, #0b141a 100%);
    }

    [data-theme="dark"] .toggle-dot {
        left: 15px;
        /* Disesuaikan dengan lebar toggle baru */
        background: #25D366;
    }

    [data-theme="dark"] .light-label {
        color: rgba(255, 255, 255, .3);
    }

    [data-theme="dark"] .dark-label {
        color: #25D366;
    }

    [data-theme="dark"] .nav-link.active {
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    [data-theme="dark"] .nav-link.active .nav-icon {
        background: #25D366;
        color: #111b21;
    }

    [data-theme="dark"] .nav-link.active .nav-text {
        color: #25D366;
    }

    /* =====================================
        RESPONSIVE BREAKPOINT
    ===================================== */
    @media(max-width:768px) {
        .admin-sidebar {
            width: 260px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const toggleBtn = document.getElementById('themeToggle');
        let currentTheme = localStorage.getItem('theme') || 'light';

        document.documentElement.setAttribute('data-theme', currentTheme);

        toggleBtn.addEventListener('click', (e) => {
            e.preventDefault();
            let theme = document.documentElement.getAttribute('data-theme');
            let newTheme = (theme === 'dark') ? 'light' : 'dark';

            document.documentElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
        });
    });
</script>
