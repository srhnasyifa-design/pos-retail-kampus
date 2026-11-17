
@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

<div id="dashboardPage">

    {{-- HEADER DASHBOARD --}}
    <div class="dashboard-heading">
        <div>
            <h3>Selamat Datang, {{ auth()->user()->name }}! 👋</h3>
            <p>Kelola aktivitas POS Retail Kampus melalui dashboard utama.</p>
        </div>

        <button type="button" class="theme-toggle" id="themeToggle">
            <i class="bi bi-sun-fill" id="themeIcon"></i>
            <span id="themeText">Mode Terang</span>
        </button>
    </div>

    {{-- BANNER --}}
    <div class="dashboard-banner">
        <div class="banner-content">
            <span class="banner-label">POS RETAIL KAMPUS</span>
            <h2>Kelola Toko Lebih Mudah dan Efisien</h2>
            <p>
                Pantau produk, stok, pelanggan, dan transaksi penjualan
                dalam satu sistem terintegrasi.
            </p>
            <a href="{{ route('sales.index') }}" class="banner-button">
                <i class="bi bi-cart3"></i> Buka Penjualan
            </a>
        </div>
        <div class="banner-icon">
            <i class="bi bi-shop"></i>
        </div>
    </div>

    {{-- RINGKASAN PENJUALAN HARI INI --}}
    <div class="section-heading">
        <div>
            <h5>Ringkasan Penjualan Hari Ini</h5>
            <p>Informasi transaksi dan pendapatan pada hari ini.</p>
        </div>
        <span class="date-label">
            <i class="bi bi-calendar3"></i>
            {{ now()->translatedFormat('d F Y') }}
        </span>
    </div>

    <div class="today-grid">
        <div class="today-card">
            <div class="today-icon">
                <i class="bi bi-receipt"></i>
            </div>
            <div>
                <small>Transaksi Hari Ini</small>
                <h3>{{ number_format($transaksiHariIni) }}</h3>
                <span>Transaksi selesai</span>
            </div>
        </div>

        <div class="today-card">
            <div class="today-icon">
                <i class="bi bi-cash-stack"></i>
            </div>
            <div>
                <small>Pendapatan Hari Ini</small>
                <h3>Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}</h3>
                <span>Total penjualan selesai</span>
            </div>
        </div>

        <div class="today-card">
            <div class="today-icon">
                <i class="bi bi-wallet2"></i>
            </div>
            <div>
                <small>Total Pendapatan</small>
                <h3>Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
                <span>Akumulasi seluruh transaksi selesai</span>
            </div>
        </div>
    </div>

    {{-- STATISTIK UTAMA --}}
    <div class="section-heading">
        <div>
            <h5>Statistik Sistem</h5>
            <p>Gambaran keseluruhan data POS Retail Kampus.</p>
        </div>
    </div>

    <div class="stats-grid">

        <div class="stat-card">
            <div class="stat-icon icon-purple">
                <i class="bi bi-box-seam"></i>
            </div>
            <div>
                <small>Total Produk</small>
                <h3>{{ number_format($totalProduk) }}</h3>
                <span>Produk terdaftar</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon icon-pink">
                <i class="bi bi-tags"></i>
            </div>
            <div>
                <small>Kategori Produk</small>
                <h3>{{ number_format($totalKategori) }}</h3>
                <span>Kategori tersedia</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon icon-orange">
                <i class="bi bi-truck"></i>
            </div>
            <div>
                <small>Total Supplier</small>
                <h3>{{ number_format($totalSupplier) }}</h3>
                <span>Supplier terdaftar</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon icon-blue">
                <i class="bi bi-people"></i>
            </div>
            <div>
                <small>Total Pelanggan</small>
                <h3>{{ number_format($totalPelanggan) }}</h3>
                <span>Pelanggan terdaftar</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon icon-green">
                <i class="bi bi-receipt-cutoff"></i>
            </div>
            <div>
                <small>Total Transaksi</small>
                <h3>{{ number_format($totalTransaksi) }}</h3>
                <span>Seluruh transaksi</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon icon-red">
                <i class="bi bi-exclamation-triangle"></i>
            </div>
            <div>
                <small>Stok Menipis</small>
                <h3>{{ number_format($stokMenipis) }}</h3>
                <span>Produk perlu diperiksa</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon icon-darkpink">
                <i class="bi bi-x-circle"></i>
            </div>
            <div>
                <small>Stok Habis</small>
                <h3>{{ number_format($stokHabis) }}</h3>
                <span>Produk tidak tersedia</span>
            </div>
        </div>

    </div>

    {{-- GRAFIK --}}
    <div class="section-heading">
        <div>
            <h5>Analisis Penjualan</h5>
            <p>Pantau perkembangan penjualan berdasarkan data transaksi.</p>
        </div>
    </div>

    <div class="charts-grid">

        <div class="dashboard-panel">
            <div class="panel-heading">
                <div>
                    <h6>Grafik Penjualan Bulanan</h6>
                    <small>Periode Januari – Desember {{ $tahun }}</small>
                </div>
                <i class="bi bi-graph-up-arrow panel-icon"></i>
            </div>
            <div class="chart-container">
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        <div class="dashboard-panel">
            <div class="panel-heading">
                <div>
                    <h6>Penjualan Berdasarkan Kategori</h6>
                    <small>Distribusi penjualan tahun {{ $tahun }}</small>
                </div>
                <i class="bi bi-pie-chart panel-icon"></i>
            </div>
            <div class="chart-container doughnut-container">
                <canvas id="categoryChart"></canvas>
            </div>
            @if($labelKategori->isEmpty())
                <p class="empty-chart">Belum ada data penjualan kategori.</p>
            @endif
        </div>

    </div>

    {{-- PRODUK TERLARIS DAN PERINGATAN STOK --}}
    <div class="section-heading">
        <div>
            <h5>Informasi Produk</h5>
            <p>Produk dengan penjualan tertinggi dan kondisi stok terkini.</p>
        </div>
    </div>

    <div class="two-column-grid">

        <div class="dashboard-panel">
            <div class="panel-heading">
                <div>
                    <h6>Produk Terlaris</h6>
                    <small>5 produk dengan jumlah penjualan tertinggi</small>
                </div>
                <i class="bi bi-trophy panel-icon"></i>
            </div>

            <div class="table-responsive">
                <table class="table dashboard-table align-middle">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Terjual</th>
                            <th>Total Penjualan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($produkTerlaris as $produk)
                            <tr>
                                <td>
                                    <strong>{{ $produk->name }}</strong>
                                    <small class="d-block muted-text">{{ $produk->code }}</small>
                                </td>
                                <td>
                                    <span class="quantity-badge">
                                        {{ $produk->jumlah_terjual }} unit
                                    </span>
                                </td>
                                <td>
                                    Rp {{ number_format($produk->total_penjualan, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-4">
                                    Belum ada data produk terjual.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="dashboard-panel">
            <div class="panel-heading">
                <div>
                    <h6>Peringatan Stok Produk</h6>
                    <small>Produk yang mencapai batas minimum stok</small>
                </div>
                <i class="bi bi-exclamation-circle panel-icon"></i>
            </div>

            <div class="stock-list">
                @forelse($produkStokMenipis as $produk)
                    <div class="stock-item">
                        <div class="stock-product-icon">
                            <i class="bi bi-box-seam"></i>
                        </div>
                        <div class="stock-product-info">
                            <strong>{{ $produk->name }}</strong>
                            <small>{{ $produk->code }}</small>
                        </div>
                        <div class="stock-status">
                            @if($produk->stock <= 0)
                                <span class="stock-danger">Habis</span>
                            @else
                                <span class="stock-warning">
                                    {{ $produk->stock }} tersisa
                                </span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <i class="bi bi-check-circle"></i>
                        <p>Semua stok produk dalam kondisi aman.</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>

    {{-- TRANSAKSI TERBARU --}}
    <div class="section-heading">
        <div>
            <h5>Transaksi Terbaru</h5>
            <p>Daftar lima transaksi terakhir yang tercatat dalam sistem.</p>
        </div>
        <a href="{{ route('history.index') }}" class="small-link">
            Lihat Riwayat <i class="bi bi-arrow-right"></i>
        </a>
    </div>

    <div class="dashboard-panel">
        <div class="table-responsive">
            <table class="table dashboard-table align-middle">
                <thead>
                    <tr>
                        <th>No. Invoice</th>
                        <th>Pelanggan</th>
                        <th>Kasir</th>
                        <th>Tanggal</th>
                        <th>Pembayaran</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksiTerbaru as $transaksi)
                        <tr>
                            <td>
                                <strong>{{ $transaksi->invoice_number }}</strong>
                            </td>
                            <td>{{ $transaksi->customer_name ?? 'Umum' }}</td>
                            <td>{{ $transaksi->cashier_name ?? '-' }}</td>
                            <td>
                                {{ \Carbon\Carbon::parse($transaksi->sale_date)->format('d/m/Y H:i') }}
                            </td>
                            <td>{{ ucfirst($transaksi->payment_method ?? '-') }}</td>
                            <td>
                                <strong>
                                    Rp {{ number_format($transaksi->total, 0, ',', '.') }}
                                </strong>
                            </td>
                            <td>
                                @if($transaksi->status === 'completed')
                                    <span class="status-success">Selesai</span>
                                @else
                                    <span class="status-pending">
                                        {{ ucfirst($transaksi->status) }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                Belum ada transaksi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- PRODUK TERBARU --}}
    <div class="section-heading">
        <div>
            <h5>Produk Terbaru</h5>
            <p>Lima produk terakhir yang ditambahkan ke sistem.</p>
        </div>
        <a href="{{ route('products.index') }}" class="small-link">
            Lihat Produk <i class="bi bi-arrow-right"></i>
        </a>
    </div>

    <div class="dashboard-panel">
        <div class="table-responsive">
            <table class="table dashboard-table align-middle">
                <thead>
                    <tr>
                        <th>Kode Produk</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Harga Jual</th>
                        <th>Stok</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($produkTerbaru as $produk)
                        <tr>
                            <td>{{ $produk->code }}</td>
                            <td><strong>{{ $produk->name }}</strong></td>
                            <td>{{ $produk->category_name ?? 'Tanpa Kategori' }}</td>
                            <td>
                                Rp {{ number_format($produk->selling_price, 0, ',', '.') }}
                            </td>
                            <td>
                                @if($produk->stock <= 0)
                                    <span class="stock-danger">Habis</span>
                                @elseif($produk->stock <= $produk->minimum_stock)
                                    <span class="stock-warning">{{ $produk->stock }}</span>
                                @else
                                    <span class="stock-good">{{ $produk->stock }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                Belum ada produk yang ditambahkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
#dashboardPage {
    --dash-text: #fff0f6;
    --dash-muted: #d9b2c6;
    --dash-card: #3b2030;
    --dash-border: rgba(230,90,155,.18);
    --dash-pink: #e65a9b;
    color: var(--dash-text);
}

#dashboardPage * {
    box-sizing: border-box;
}

#dashboardPage .dashboard-heading,
#dashboardPage .section-heading,
#dashboardPage .panel-heading {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
}

#dashboardPage .dashboard-heading {
    margin-bottom: 22px;
}

#dashboardPage .dashboard-heading h3 {
    font-size: 23px;
    font-weight: 800;
    margin-bottom: 6px;
}

#dashboardPage .dashboard-heading p,
#dashboardPage .section-heading p {
    color: var(--dash-muted);
    font-size: 13px;
    margin: 0;
}

#dashboardPage .theme-toggle {
    border: 1px solid var(--dash-border);
    background: var(--dash-card);
    color: var(--dash-text);
    padding: 10px 15px;
    border-radius: 10px;
    font-size: 12px;
    white-space: nowrap;
}

#dashboardPage .theme-toggle i {
    color: var(--dash-pink);
    margin-right: 5px;
}

#dashboardPage .dashboard-banner {
    min-height: 215px;
    border-radius: 19px;
    padding: 30px;
    margin-bottom: 30px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    overflow: hidden;
    position: relative;
    background:
        linear-gradient(100deg, rgba(57,15,40,.97), rgba(168,50,112,.88)),
        url('https://images.unsplash.com/photo-1441986300917-64674bd600d8?auto=format&fit=crop&w=1400&q=80')
        center/cover;
    border: 1px solid rgba(255,255,255,.12);
}

#dashboardPage .banner-content {
    max-width: 620px;
    position: relative;
    z-index: 2;
}

#dashboardPage .banner-label {
    display: inline-block;
    background: rgba(255,255,255,.16);
    padding: 6px 11px;
    border-radius: 20px;
    font-size: 10px;
    letter-spacing: 1.4px;
    font-weight: 700;
}

#dashboardPage .banner-content h2 {
    font-size: 27px;
    font-weight: 800;
    margin: 13px 0 8px;
}

#dashboardPage .banner-content p {
    color: #f9dce9;
    font-size: 13px;
    line-height: 1.7;
    margin-bottom: 18px;
}

#dashboardPage .banner-button {
    display: inline-block;
    background: white;
    color: #a83270;
    padding: 10px 16px;
    border-radius: 9px;
    font-size: 12px;
    font-weight: 700;
    text-decoration: none;
}

#dashboardPage .banner-icon {
    font-size: 110px;
    color: rgba(255,255,255,.22);
    padding-right: 35px;
}

#dashboardPage .section-heading {
    margin: 27px 0 15px;
}

#dashboardPage .section-heading h5 {
    font-size: 16px;
    font-weight: 800;
    margin-bottom: 4px;
}

#dashboardPage .date-label {
    font-size: 12px;
    color: var(--dash-muted);
    white-space: nowrap;
}

#dashboardPage .today-grid,
#dashboardPage .stats-grid {
    display: grid;
    gap: 15px;
    grid-template-columns: repeat(3, minmax(0, 1fr));
}

#dashboardPage .stats-grid {
    grid-template-columns: repeat(4, minmax(0, 1fr));
}

#dashboardPage .today-card,
#dashboardPage .stat-card,
#dashboardPage .dashboard-panel {
    background: var(--dash-card);
    border: 1px solid var(--dash-border);
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0,0,0,.08);
}

#dashboardPage .today-card,
#dashboardPage .stat-card {
    display: flex;
    align-items: center;
    gap: 13px;
    padding: 19px;
    min-width: 0;
}

#dashboardPage .today-icon,
#dashboardPage .stat-icon {
    width: 45px;
    height: 45px;
    flex-shrink: 0;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
}

#dashboardPage .today-icon {
    color: #ffabd0;
    background: rgba(230,90,155,.17);
}

#dashboardPage .today-card small,
#dashboardPage .stat-card small {
    color: var(--dash-muted);
    display: block;
    font-size: 11px;
}

#dashboardPage .today-card h3,
#dashboardPage .stat-card h3 {
    font-size: 21px;
    font-weight: 800;
    margin: 5px 0;
    overflow-wrap: anywhere;
}

#dashboardPage .today-card span,
#dashboardPage .stat-card span {
    font-size: 10px;
    color: var(--dash-muted);
}

#dashboardPage .icon-purple { background: rgba(166,130,255,.16); color: #b99aff; }
#dashboardPage .icon-pink { background: rgba(230,90,155,.16); color: #ff9bc5; }
#dashboardPage .icon-orange { background: rgba(255,174,89,.16); color: #ffb86f; }
#dashboardPage .icon-blue { background: rgba(104,174,255,.16); color: #83bcff; }
#dashboardPage .icon-green { background: rgba(95,211,153,.16); color: #79e4ae; }
#dashboardPage .icon-red { background: rgba(255,105,125,.16); color: #ff8296; }
#dashboardPage .icon-darkpink { background: rgba(230,90,155,.2); color: #ff79b5; }

#dashboardPage .charts-grid,
#dashboardPage .two-column-grid {
    display: grid;
    grid-template-columns: 1.5fr 1fr;
    gap: 17px;
}

#dashboardPage .dashboard-panel {
    padding: 20px;
    min-width: 0;
    margin-bottom: 18px;
}

#dashboardPage .panel-heading {
    margin-bottom: 18px;
}

#dashboardPage .panel-heading h6 {
    font-size: 14px;
    font-weight: 800;
    margin: 0 0 5px;
}

#dashboardPage .panel-heading small {
    color: var(--dash-muted);
    font-size: 11px;
}

#dashboardPage .panel-icon {
    color: var(--dash-pink);
    font-size: 21px;
}

#dashboardPage .chart-container {
    position: relative;
    height: 270px;
    width: 100%;
}

#dashboardPage .doughnut-container {
    max-width: 350px;
    margin: auto;
}

#dashboardPage .empty-chart,
#dashboardPage .empty-state {
    color: var(--dash-muted);
    text-align: center;
    font-size: 12px;
}

#dashboardPage .dashboard-table {
    min-width: 560px;
    margin-bottom: 0;
    font-size: 12px;
}

#dashboardPage .dashboard-table th {
    color: #f5b7d2;
    font-size: 11px;
    font-weight: 700;
    white-space: nowrap;
    padding: 12px;
}

#dashboardPage .dashboard-table td {
    padding: 13px 12px;
    vertical-align: middle;
}

#dashboardPage .muted-text {
    color: var(--dash-muted);
    font-size: 10px;
}

#dashboardPage .quantity-badge,
#dashboardPage .status-success,
#dashboardPage .status-pending,
#dashboardPage .stock-warning,
#dashboardPage .stock-danger,
#dashboardPage .stock-good {
    display: inline-block;
    padding: 5px 9px;
    border-radius: 20px;
    font-size: 10px;
    font-weight: 700;
    white-space: nowrap;
}

#dashboardPage .quantity-badge {
    color: #ffacd0;
    background: rgba(230,90,155,.15);
}

#dashboardPage .status-success,
#dashboardPage .stock-good {
    color: #83e7b0;
    background: rgba(69,190,124,.14);
}

#dashboardPage .status-pending,
#dashboardPage .stock-warning {
    color: #ffc477;
    background: rgba(255,174,89,.14);
}

#dashboardPage .stock-danger {
    color: #ff9aa9;
    background: rgba(255,90,110,.15);
}

#dashboardPage .stock-list {
    display: flex;
    flex-direction: column;
}

#dashboardPage .stock-item {
    display: flex;
    align-items: center;
    gap: 11px;
    padding: 13px 0;
    border-bottom: 1px solid var(--dash-border);
}

#dashboardPage .stock-item:last-child {
    border-bottom: 0;
}

#dashboardPage .stock-product-icon {
    width: 37px;
    height: 37px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    color: var(--dash-pink);
    background: rgba(230,90,155,.14);
}

#dashboardPage .stock-product-info {
    display: flex;
    flex-direction: column;
    min-width: 0;
    flex: 1;
}

#dashboardPage .stock-product-info strong {
    font-size: 12px;
}

#dashboardPage .stock-product-info small {
    font-size: 10px;
    color: var(--dash-muted);
}

#dashboardPage .small-link {
    color: var(--dash-pink);
    font-size: 11px;
    font-weight: 700;
    text-decoration: none;
    white-space: nowrap;
}

#dashboardPage .small-link:hover {
    text-decoration: underline;
}

html[data-theme="light"] #dashboardPage {
    --dash-text: #492338;
    --dash-muted: #91627a;
    --dash-card: #ffffff;
    --dash-border: #f0c5da;
}

html[data-theme="light"] #dashboardPage .dashboard-table {
    --bs-table-color: #492338;
    --bs-table-border-color: #f0c5da;
    --bs-table-hover-color: #492338;
}

html[data-theme="light"] #dashboardPage .dashboard-table th {
    color: #a83270;
}

html[data-theme="light"] #dashboardPage .dashboard-table td {
    color: #492338;
}

html[data-theme="light"] #dashboardPage .theme-toggle {
    background: #fff;
}

@media (max-width: 1100px) {
    #dashboardPage .stats-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

@media (max-width: 768px) {
    #dashboardPage .dashboard-heading {
        align-items: flex-start;
    }

    #dashboardPage .dashboard-heading h3 {
        font-size: 19px;
    }

    #dashboardPage .dashboard-heading p {
        font-size: 11px;
    }

    #dashboardPage .theme-toggle {
        padding: 8px 10px;
        font-size: 10px;
    }

    #dashboardPage .dashboard-banner {
        min-height: 190px;
        padding: 22px;
    }

    #dashboardPage .banner-content h2 {
        font-size: 21px;
    }

    #dashboardPage .banner-icon {
        display: none;
    }

    #dashboardPage .today-grid,
    #dashboardPage .stats-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    #dashboardPage .charts-grid,
    #dashboardPage .two-column-grid {
        grid-template-columns: 1fr;
    }

    #dashboardPage .today-card,
    #dashboardPage .stat-card {
        padding: 13px;
        gap: 9px;
    }

    #dashboardPage .today-icon,
    #dashboardPage .stat-icon {
        width: 37px;
        height: 37px;
        font-size: 17px;
    }

    #dashboardPage .today-card h3,
    #dashboardPage .stat-card h3 {
        font-size: 16px;
    }

    #dashboardPage .today-card small,
    #dashboardPage .stat-card small {
        font-size: 10px;
    }

    #dashboardPage .chart-container {
        height: 230px;
    }

    #dashboardPage .dashboard-panel {
        padding: 15px;
    }
}

@media (max-width: 420px) {
    #dashboardPage .dashboard-heading {
        flex-direction: column;
    }

    #dashboardPage .date-label {
        font-size: 10px;
    }

    #dashboardPage .today-grid,
    #dashboardPage .stats-grid {
        gap: 9px;
    }

    #dashboardPage .today-card,
    #dashboardPage .stat-card {
        align-items: flex-start;
        flex-direction: column;
    }

    #dashboardPage .dashboard-banner {
        padding: 18px;
    }

    #dashboardPage .banner-content h2 {
        font-size: 18px;
    }

    #dashboardPage .section-heading h5 {
        font-size: 14px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // TEMA GELAP DAN TERANG
    const themeToggle = document.getElementById('themeToggle');
    const themeIcon = document.getElementById('themeIcon');
    const themeText = document.getElementById('themeText');

    function applyTheme(theme) {
        document.documentElement.setAttribute('data-theme', theme);
        localStorage.setItem('pos-theme', theme);

        if (theme === 'dark') {
            themeIcon.className = 'bi bi-sun-fill';
            themeText.textContent = 'Mode Terang';
        } else {
            themeIcon.className = 'bi bi-moon-fill';
            themeText.textContent = 'Mode Gelap';
        }

        if (window.salesChartInstance) {
            window.salesChartInstance.options.scales.x.ticks.color =
                theme === 'dark' ? '#d9b2c6' : '#91627a';

            window.salesChartInstance.options.scales.y.ticks.color =
                theme === 'dark' ? '#d9b2c6' : '#91627a';

            window.salesChartInstance.options.scales.x.grid.color =
                theme === 'dark' ? 'rgba(230,90,155,.10)' : 'rgba(168,50,112,.10)';

            window.salesChartInstance.options.scales.y.grid.color =
                theme === 'dark' ? 'rgba(230,90,155,.10)' : 'rgba(168,50,112,.10)';

            window.salesChartInstance.update();
        }

        if (window.categoryChartInstance) {
            window.categoryChartInstance.options.plugins.legend.labels.color =
                theme === 'dark' ? '#fceaf2' : '#492338';

            window.categoryChartInstance.update();
        }
    }

    applyTheme(localStorage.getItem('pos-theme') || 'dark');

    themeToggle.addEventListener('click', function () {
        const currentTheme = document.documentElement.getAttribute('data-theme');
        applyTheme(currentTheme === 'dark' ? 'light' : 'dark');
    });

    // DATA GRAFIK DARI LARAVEL
    const labelsBulan = @json($namaBulan);
    const dataPenjualan = @json($dataPenjualan);
    const labelKategori = @json($labelKategori);
    const dataKategori = @json($dataKategori);

    const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
    const textColor = isDark ? '#d9b2c6' : '#91627a';
    const gridColor = isDark
        ? 'rgba(230,90,155,.10)'
        : 'rgba(168,50,112,.10)';

    // GRAFIK GARIS PENJUALAN
    const salesCanvas = document.getElementById('salesChart');

    if (salesCanvas) {
        window.salesChartInstance = new Chart(salesCanvas, {
            type: 'line',
            data: {
                labels: labelsBulan,
                datasets: [{
                    label: 'Pendapatan',
                    data: dataPenjualan,
                    borderColor: '#e65a9b',
                    backgroundColor: 'rgba(230,90,155,.15)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 3,
                    pointRadius: 4,
                    pointBackgroundColor: '#e65a9b'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    intersect: false,
                    mode: 'index'
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                return ' Rp ' + new Intl.NumberFormat('id-ID')
                                    .format(context.raw);
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: { color: textColor },
                        grid: { color: gridColor }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: textColor,
                            callback: function (value) {
                                return 'Rp ' + new Intl.NumberFormat('id-ID')
                                    .format(value);
                            }
                        },
                        grid: { color: gridColor }
                    }
                }
            }
        });
    }

    // GRAFIK DONAT KATEGORI
    const categoryCanvas = document.getElementById('categoryChart');

    if (categoryCanvas && labelKategori.length > 0) {
        window.categoryChartInstance = new Chart(categoryCanvas, {
            type: 'doughnut',
            data: {
                labels: labelKategori,
                datasets: [{
                    data: dataKategori,
                    backgroundColor: [
                        '#e65a9b',
                        '#a83270',
                        '#ff9bc5',
                        '#c77dff',
                        '#ffb86f',
                        '#79c9ff',
                        '#78d6a5'
                    ],
                    borderWidth: 3,
                    borderColor: isDark ? '#3b2030' : '#ffffff',
                    hoverOffset: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: textColor,
                            padding: 16,
                            usePointStyle: true,
                            font: {
                                size: 11
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                return context.label + ': Rp ' +
                                    new Intl.NumberFormat('id-ID')
                                    .format(context.raw);
                            }
                        }
                    }
                }
            }
        });
    }
});
</script>

@endpush
