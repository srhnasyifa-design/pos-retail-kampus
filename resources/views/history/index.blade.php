
@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Riwayat Transaksi</h3>
            <p class="text-muted mb-0">
                Kelola dan pantau seluruh transaksi penjualan.
            </p>
        </div>

        <a href="{{ route('sales.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Transaksi Baru
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="text-muted small">Total Transaksi</div>
                    <h3 class="fw-bold mb-0">{{ $totalTransaksi }}</h3>
                    <small class="text-muted">Seluruh transaksi tersimpan</small>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="text-muted small">Pendapatan</div>
                    <h3 class="fw-bold text-success mb-0">
                        Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                    </h3>
                    <small class="text-muted">Transaksi selesai</small>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="text-muted small">Transaksi Hari Ini</div>
                    <h3 class="fw-bold mb-0">{{ $jumlahHariIni }}</h3>
                    <small class="text-muted">Transaksi berdasarkan tanggal hari ini</small>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <h5 class="fw-bold mb-3">Daftar Riwayat Transaksi</h5>

            <form method="GET" action="{{ route('history.index') }}" class="row g-2 mb-4">

                <div class="col-md-3">
                    <input type="text"
                           name="search"
                           class="form-control"
                           placeholder="Cari invoice / pelanggan"
                           value="{{ request('search') }}">
                </div>

                <div class="col-md-2">
                    <input type="date"
                           name="start_date"
                           class="form-control"
                           value="{{ request('start_date') }}">
                </div>

                <div class="col-md-2">
                    <input type="date"
                           name="end_date"
                           class="form-control"
                           value="{{ request('end_date') }}">
                </div>

                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>
                            Selesai
                        </option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                            Pending
                        </option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>
                            Dibatalkan
                        </option>
                    </select>
                </div>

                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search"></i> Cari
                    </button>

                    <a href="{{ route('history.index') }}" class="btn btn-light border">
                        Reset
                    </a>
                </div>

            </form>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>No. Invoice</th>
                            <th>Tanggal</th>
                            <th>Pelanggan</th>
                            <th>Kasir</th>
                            <th>Total</th>
                            <th>Pembayaran</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($transaksi as $index => $item)
                            <tr>
                                <td>{{ $transaksi->firstItem() + $index }}</td>

                                <td class="fw-semibold">
                                    {{ $item->invoice_number }}
                                </td>

                                <td>
                                    {{ \Carbon\Carbon::parse($item->sale_date)->format('d/m/Y') }}
                                </td>

                                <td>{{ $item->customer_name ?? 'Pelanggan Umum' }}</td>

                                <td>{{ $item->cashier_name ?? '-' }}</td>

                                <td class="fw-semibold">
                                    Rp {{ number_format($item->total, 0, ',', '.') }}
                                </td>

                                <td>
                                    {{ strtoupper($item->payment_method) }}
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

                                <td>
                                    <a href="{{ route('sales.show', $item->id) }}"
                                       class="btn btn-sm btn-outline-primary"
                                       title="Lihat Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4 text-muted">
                                    Belum ada riwayat transaksi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $transaksi->links('pagination::bootstrap-5') }}
            </div>

        </div>
    </div>

</div>
@endsection
