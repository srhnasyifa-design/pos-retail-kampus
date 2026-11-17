
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - POS Retail Kampus</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <script>
        const savedTheme = localStorage.getItem('pos-theme') || 'dark';
        document.documentElement.setAttribute('data-theme', savedTheme);
    </script>

    <style>
        :root {
            --pink-dark: #210f1b;
            --pink-sidebar: #2b1422;
            --pink-card: #3b2030;
            --pink-main: #a83270;
            --pink-accent: #e65a9b;
            --pink-soft: #f8dce9;
            --sidebar-width: 260px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: var(--pink-dark);
            color: #fceaf2;
            font-family: Arial, sans-serif;
            transition: background .25s, color .25s;
        }

        /* SIDEBAR */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: var(--pink-sidebar);
            color: white;
            padding: 24px 17px;
            display: flex;
            flex-direction: column;
            z-index: 1000;
            overflow-y: auto;
            border-right: 1px solid rgba(230,90,155,.15);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 10px 28px;
            border-bottom: 1px solid rgba(255,255,255,.12);
            margin-bottom: 25px;
        }

        .brand-icon {
            width: 43px;
            height: 43px;
            border-radius: 12px;
            background: var(--pink-main);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 23px;
            color: white;
        }

        .brand h5 {
            margin: 0;
            font-size: 16px;
            font-weight: 700;
        }

        .brand small {
            color: #e9b5cf;
            font-size: 11px;
        }

        .menu-title {
            color: #d98bb2;
            font-size: 10px;
            font-weight: bold;
            letter-spacing: 1.2px;
            padding: 0 12px;
            margin: 14px 0 10px;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            margin-bottom: 5px;
            border-radius: 9px;
            color: #f3dce8;
            text-decoration: none;
            font-size: 13px;
            transition: .2s;
        }

        .sidebar a i {
            font-size: 17px;
            color: #f08ab8;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: var(--pink-main);
            color: white;
        }

        .sidebar a:hover i,
        .sidebar a.active i {
            color: white;
        }

        .sidebar-bottom {
            margin-top: auto;
            border-top: 1px solid rgba(255,255,255,.15);
            padding-top: 18px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px;
            margin-bottom: 10px;
        }

        .user-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #e65a9b;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .user-info strong {
            display: block;
            font-size: 12px;
        }

        .user-info small {
            color: #e9b5cf;
            font-size: 11px;
            text-transform: capitalize;
        }

        .logout-btn {
            width: 100%;
            border: 0;
            background: rgba(230,90,155,.15);
            color: white;
            padding: 11px;
            border-radius: 8px;
            text-align: left;
            font-size: 13px;
        }

        .logout-btn:hover {
            background: #a83270;
        }

        /* KONTEN UTAMA */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            background: var(--pink-dark);
        }

        .topbar {
            min-height: 70px;
            background: var(--pink-sidebar);
            border-bottom: 1px solid rgba(230,90,155,.2);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
        }

        .topbar h6 {
            margin: 0;
            font-size: 15px;
            font-weight: 700;
            color: #fff0f6;
        }

        .topbar small {
            color: #d9a8c1;
        }

        .topbar .bi-person-circle {
            color: var(--pink-accent) !important;
        }

        .topbar .fw-semibold {
            color: #fceaf2;
        }

        .content-area {
            padding: 28px 30px;
            background: var(--pink-dark);
            min-height: calc(100vh - 70px);
        }

        /* KARTU DAN PANEL */
        .stat-card,
        .panel,
        .card {
            background: var(--pink-card);
            color: #fff0f6;
            border: 1px solid rgba(230,90,155,.16);
            border-radius: 17px;
        }

        .stat-card,
        .panel {
            padding: 22px;
        }

        .stat-label,
        .text-secondary {
            color: #d9b2c6 !important;
        }

        .stat-number {
            color: #fff0f6;
        }

        /* WARNA BOOTSTRAP */
        .text-primary {
            color: var(--pink-accent) !important;
        }

        .bg-primary,
        .btn-primary {
            background-color: var(--pink-main) !important;
            border-color: var(--pink-main) !important;
            color: white !important;
        }

        .btn-primary:hover {
            background-color: #852456 !important;
            border-color: #852456 !important;
        }

        .bg-primary-subtle {
            background-color: rgba(230,90,155,.17) !important;
        }

        .btn-outline-primary {
            color: var(--pink-accent) !important;
            border-color: var(--pink-accent) !important;
        }

        .btn-outline-primary:hover {
            color: white !important;
            background: var(--pink-main) !important;
        }

        .badge.bg-primary-subtle {
            color: #ff9bc5 !important;
        }

        .form-control,
        .form-select {
            background-color: #321b29;
            border-color: #694056;
            color: #fff0f6;
        }

        .form-control:focus,
        .form-select:focus {
            background-color: #321b29;
            border-color: var(--pink-accent);
            color: white;
            box-shadow: 0 0 0 .2rem rgba(230,90,155,.2);
        }

        .form-control::placeholder {
            color: #c69aaf;
        }

        .table {
            --bs-table-bg: transparent;
            --bs-table-color: #fceaf2;
            --bs-table-border-color: rgba(230,90,155,.16);
            --bs-table-hover-bg: rgba(230,90,155,.08);
            --bs-table-hover-color: white;
            color: #fceaf2;
        }

        .table-light {
            --bs-table-bg: #51253d;
            --bs-table-color: #fff0f6;
        }

        .table thead th {
            color: #f5b7d2;
        }

        .dropdown-menu {
            background: var(--pink-card);
            border-color: #694056;
        }

        .dropdown-item {
            color: #fff0f6;
        }

        .dropdown-item:hover {
            background: var(--pink-main);
            color: white;
        }

        .pagination {
            --bs-pagination-bg: #3b2030;
            --bs-pagination-color: #fceaf2;
            --bs-pagination-border-color: #694056;
            --bs-pagination-hover-bg: #a83270;
            --bs-pagination-hover-color: white;
            --bs-pagination-hover-border-color: #a83270;
            --bs-pagination-active-bg: #a83270;
            --bs-pagination-active-border-color: #a83270;
            --bs-pagination-disabled-bg: #321b29;
            --bs-pagination-disabled-color: #a98a9a;
        }

        .alert-success {
            background: #253b32;
            border-color: #397657;
            color: #b9f3d1;
        }

        .alert-danger {
            background: #48212e;
            border-color: #a83270;
            color: #ffc1d9;
        }

        /* MODE TERANG */
        html[data-theme="light"] body,
        html[data-theme="light"] .main-content,
        html[data-theme="light"] .content-area {
            background: #fff3f8;
            color: #492338;
        }

        html[data-theme="light"] .sidebar {
            background: #57213f;
        }

        html[data-theme="light"] .topbar {
            background: white;
            border-color: #f0c5da;
        }

        html[data-theme="light"] .topbar h6,
        html[data-theme="light"] .topbar .fw-semibold {
            color: #492338;
        }

        html[data-theme="light"] .stat-card,
        html[data-theme="light"] .panel,
        html[data-theme="light"] .card {
            background: white;
            color: #492338;
            border-color: #f0c5da;
        }

        html[data-theme="light"] .stat-number {
            color: #492338;
        }

        html[data-theme="light"] .table {
            --bs-table-color: #492338;
            --bs-table-border-color: #f0c5da;
            --bs-table-hover-color: #492338;
        }

        html[data-theme="light"] .table-light {
            --bs-table-bg: #fce2ee;
            --bs-table-color: #492338;
        }

        html[data-theme="light"] .form-control,
        html[data-theme="light"] .form-select {
            background: white;
            color: #492338;
            border-color: #e8b4cd;
        }

        html[data-theme="light"] .text-secondary {
            color: #91627a !important;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 75px;
                padding: 20px 9px;
            }

            .brand {
                justify-content: center;
                padding: 0 0 22px;
            }

            .brand-text,
            .menu-title,
            .sidebar a span,
            .user-info div,
            .logout-text {
                display: none;
            }

            .sidebar a {
                justify-content: center;
                padding: 13px 5px;
            }

            .sidebar a i {
                font-size: 20px;
            }

            .user-info {
                justify-content: center;
                padding: 5px 0;
            }

            .logout-btn {
                text-align: center;
            }

            .main-content {
                margin-left: 75px;
            }

            .topbar {
                padding: 0 15px;
            }

            .content-area {
                padding: 18px 14px;
            }
        }
    </style>
</head>

<body>

@auth
<aside class="sidebar">

    <div class="brand">
        <div class="brand-icon">
            <i class="bi bi-shop"></i>
        </div>
        <div class="brand-text">
            <h5>POS RETAIL</h5>
            <small>Kampus Management</small>
        </div>
    </div>

    <div class="menu-title">MENU UTAMA</div>

    <a href="{{ route('dashboard') }}"
       class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
    </a>

    <a href="{{ route('products.index') }}"
       class="{{ request()->routeIs('products.*') ? 'active' : '' }}">
        <i class="bi bi-box-seam"></i>
        <span>Data Produk</span>
    </a>

    @if(auth()->user()->role === 'admin')
        <a href="{{ route('categories.index') }}"
           class="{{ request()->routeIs('categories.*') ? 'active' : '' }}">
            <i class="bi bi-tags"></i>
            <span>Kategori</span>
        </a>

        <a href="{{ route('suppliers.index') }}"
           class="{{ request()->routeIs('suppliers.*') ? 'active' : '' }}">
            <i class="bi bi-truck"></i>
            <span>Supplier</span>
        </a>
    @endif

    <a href="{{ route('customers.index') }}"
       class="{{ request()->routeIs('customers.*') ? 'active' : '' }}">
        <i class="bi bi-people"></i>
        <span>Pelanggan</span>
    </a>

    <div class="menu-title">TRANSAKSI</div>

    <a href="{{ route('sales.index') }}"
       class="{{ request()->routeIs('sales.*') ? 'active' : '' }}">
        <i class="bi bi-cart3"></i>
        <span>Penjualan</span>
    </a>

    <a href="{{ route('history.index') }}"
       class="{{ request()->routeIs('history.*') ? 'active' : '' }}">
        <i class="bi bi-clock-history"></i>
        <span>Riwayat Transaksi</span>
    </a>

    @if(auth()->user()->role === 'admin')
        <div class="menu-title">PENGELOLAAN</div>

        <a href="{{ route('reports.index') }}"
           class="{{ request()->routeIs('reports.*') ? 'active' : '' }}">
            <i class="bi bi-bar-chart"></i>
            <span>Laporan</span>
        </a>

        <a href="{{ route('settings.index') }}"
           class="{{ request()->routeIs('settings.*') ? 'active' : '' }}">
            <i class="bi bi-gear"></i>
            <span>Pengaturan</span>
        </a>
    @endif

    <div class="sidebar-bottom">
        <div class="user-info">
            <div class="user-avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div>
                <strong>{{ auth()->user()->name }}</strong>
                <small>{{ auth()->user()->role }}</small>
            </div>
        </div>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="bi bi-box-arrow-left"></i>
                <span class="logout-text">Keluar dari Sistem</span>
            </button>
        </form>
    </div>

</aside>
@endauth

<main class="main-content">

    @auth
    <header class="topbar">
        <div>
            <h6>@yield('page-title', 'Dashboard')</h6>
            <small>POS Retail Kampus</small>
        </div>

        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-person-circle fs-5"></i>
            <span class="small fw-semibold">{{ auth()->user()->name }}</span>
        </div>
    </header>
    @endauth

    <section class="content-area">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')

    </section>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')

</body>
</html>
