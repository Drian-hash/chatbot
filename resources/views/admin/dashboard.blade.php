<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>

    <!-- ICON -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

   <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background: #f5f6fa;
            transition: 0.3s;
        }

        .container {
            display: flex;
        }

        /* ===== SIDEBAR ===== */
        /* ===== SIDEBAR (TYPO & SPACING FIX) ===== */
        .sidebar {
            width: 260px;
            background: #fff;
            height: 100vh;
            padding: 22px 14px;
            /* sedikit lebih lega */
            border-right: 1px solid #e5e7eb;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        /* LOGO */
        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 26px;
            padding-left: 8px;
        }

        .logo img {
            width: 42px;
        }

        .logo-text {
            font-size: 17px;
            font-weight: 600;
            letter-spacing: 0.2px;
        }

        /* LIST */
        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        /* SECTION TITLE */
        .menu-title {
            font-size: 11px;
            font-weight: 500;
            color: #94a3b8;
            margin: 18px 10px 8px;
            letter-spacing: 0.6px;
            text-transform: uppercase;
        }

        /* ITEM */
        .sidebar li {
            margin: 6px 0;
            /* 🔥 lebih lega */
        }

        /* LINK */
        .sidebar li a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 14px;
            /* 🔥 lebih nyaman */
            border-radius: 10px;
            color: #374151;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            position: relative;
            transition: all 0.15s ease;
        }

        /* ICON */
        .sidebar li i {
            width: 20px;
            font-size: 15px;
            text-align: center;
            color: #6b7280;
        }

        /* TEXT */
        .sidebar li span {
            line-height: 1;
        }

        /* HOVER */
        .sidebar li a:hover {
            background: #f9fafb;
        }

        /* ACTIVE */
        .sidebar li.active a {
            background: #f3f4f6;
            color: #111827;
        }

        .menu-toggle {
            font-size: 18px;
            cursor: pointer;
            color: #374151;
        }

        .menu-toggle:hover {
            color: #111827;
        }

        /* GARIS KIRI */
        .sidebar li.active a::before {
            content: "";
            position: absolute;
            left: 0;
            top: 6px;
            bottom: 6px;
            width: 2px;
            background: #22c55e;
            border-radius: 2px;
        }

        /* ===== PROFILE ===== */
        .profile {
            border-top: 1px solid #eee;
            padding: 14px 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .avatar {
            width: 38px;
            height: 38px;
            background: #6b7280;
            color: white;
            border-radius: 50%;
            font-size: 13px;
        }

        .profile-text strong {
            font-size: 13px;
        }

        .profile-text small {
            font-size: 11px;
            color: #6b7280;
        }

        /* ===== MAIN ===== */
        .main {
            flex: 1;
        }

        /* NAVBAR */
        .navbar {
            height: 60px;
            background: #fff;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
            border-bottom: 1px solid #eee;
        }

        .nav-icon {
            cursor: pointer;
        }

        /* CONTENT */
        .content-area {
            padding: 20px;
        }

        .table-box {
            background: #fff;
            padding: 20px;
            border-radius: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #f9fafb;
            text-align: left;
        }

        td,
        th {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }

        /* ===== DARK MODE ===== */
        body.dark {
            background: #0f172a;
            color: #e2e8f0;
        }

        body.dark .sidebar {
            background: #020617;
            border-right: 1px solid #1e293b;
        }

        body.dark .sidebar li a {
            color: #cbd5f5;
        }

        body.dark .sidebar li a:hover {
            background: #1e293b;
        }

        body.dark .sidebar li.active a {
            background: #1e293b;
        }

        body.dark .navbar {
            background: #020617;
            border-bottom: 1px solid #1e293b;
        }

        /* 🔥 FIX TABLE DARK */
        body.dark .table-box {
            background: #020617;
            border: 1px solid #1e293b;
        }

        body.dark th {
            background: #0f172a;
            color: #cbd5f5;
        }

        body.dark td {
            color: #e2e8f0;
        }

        body.dark td,
        body.dark th {
            border-bottom: 1px solid #1e293b;
        }

        body.dark tr:hover {
            background: #1e293b;
        }

        body.dark input,
        body.dark select {
            background: #020617;
            color: #e2e8f0;
            border: 1px solid #1e293b;
        }
    </style>
</head>

<body>

    <div class="container">

        <!-- SIDEBAR -->
        @include('admin.components.sidebar')
        <!-- MAIN -->
        <div class="main">

            @include('admin.components.navbar')

            <div class="content-area">
                @yield('admin')
            </div>

        </div>

    </div>

    <script>
        function toggleSidebar() {
            document.getElementById("sidebar").classList.toggle("collapsed");
        }

        function toggleTheme() {
            document.body.classList.toggle("dark");
        }
    </script>

</body>

</html>
