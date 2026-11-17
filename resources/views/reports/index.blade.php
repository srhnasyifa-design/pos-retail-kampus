
@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Laporan Penjualan</h3>
            <p class="text-muted mb-0">
                Ringkasan dan analisis transaksi penjualan POS Retail Kampus.
            </p>
        </div>

        <button onclick="window.print()" class="btn btn-outline-primary">
            <i class="bi bi-printer me-1"></i> Cetak Laporan
        </button>
    </div>

    {{-- Filter Periode --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('reports.index') }}" method="GET"
                  class="row g-3 align-items-end">

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Tanggal Mulai</label>
                    <input type="date" name="start_date"
                           class="form-control"
                           value="{{ $startDate }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Tanggal Akhir</label>
                    <input type="date" name="end_date"
                           class="form-control"
                           value="{{ $endDate }}">
                </div>

                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-funnel me-1"></i> Terapkan Filter
                    </button>

                    <a href="{{ route('reports.index') }}"
                       class="btn btn-light border">
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Statistik --}}
    <div class="row g-3 mb-4">

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-muted small mb-2">Total Transaksi</div>
                    <h3 class="fw-bold mb-1">{{ $totalTransaksi }}</h3>
                    <small class="text-muted">Transaksi pada periode dipilih</small>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-muted small mb-2">Total Pendapatan</div>
                    <h3 class="fw-bold text-success mb-1">
                        Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                    </h3>
                    <small class="text-muted">Dari transaksi selesai</small>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-muted small mb-2">Rata-rata Transaksi</div>
                    <h3 class="fw-bold mb-1">
                        Rp {{ number_format($rataRata, 0, ',', '.') }}
                    </h3>
                    <small class="text-muted">Pendapatan dibagi jumlah transaksi</small>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-muted small mb-2">Transaksi Selesai</div>
                    <h3 class="fw-bold text-primary mb-1">
                        {{ $transaksiSelesai }}
                    </h3>
                    <small class="text-muted">
                        {{ $transaksiDibatalkan }} transaksi dibatalkan
                    </small>
                </div>
            </div>
        </div>

    </div>

    {{-- Produk Terlaris --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <h5 class="fw-bold mb-3">5 Produk Terlaris</h5>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Jumlah Terjual</th>
                            <th>Total Pendapatan</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($produkTerlaris as $index => $produk)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td class="fw-semibold">{{ $produk->name }}</td>
                                <td>{{ number_format($produk->total_terjual, 0, ',', '.') }}</td>
                                <td>
                                    Rp {{ number_format($produk->total_pendapatan, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    Belum ada data penjualan produk pada periode ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Rincian Transaksi --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <h5 class="fw-bold mb-3">Rincian Transaksi</h5>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Invoice</th>
                            <th>Tanggal</th>
                            <th>Pelanggan</th>
                            <th>Kasir</th>
                            <th>Pembayaran</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($daftarTransaksi as $index => $item)
                            <tr>
                                <td>{{ $daftarTransaksi->firstItem() + $index }}</td>
                                <td class="fw-semibold">{{ $item->invoice_number }}</td>
                                <td>
                                    {{ \Carbon\Carbon::parse($item->sale_date)->format('d/m/Y') }}
                                </td>
                                <td>{{ $item->customer_name ?? 'Pelanggan Umum' }}</td>
                                <td>{{ $item->cashier_name ?? '-' }}</td>
                                <td>{{ strtoupper($item->payment_method) }}</td>
                                <td class="fw-semibold">
                                    Rp {{ number_format($item->total, 0, ',', '.') }}
                                </td>
                                <td>
                                    @if($item->status == 'completed')
                                        <span class="badge bg-success">Selesai</span>
                                    @elseif($item->status == 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @else
                                        <span class="badge bg-danger">Dibatalkan</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    Belum ada transaksi untuk ditampilkan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $daftarTransaksi->links('pagination::bootstrap-5') }}
            </div>

        </div>
    </div>

</div>

<style>
    @media print {
        body {
            background: white !important;
        }

        .sidebar,
        .navbar,
        button,
        form,
        .pagination {
            display: none !important;
        }

        .container-fluid {
            width: 100% !important;
            padding: 0 !important;
        }

        .card {
            box-shadow: none !important;
            border: 1px solid #ddd !important;
            break-inside: avoid;
        }
    }
</style>
@endsection
