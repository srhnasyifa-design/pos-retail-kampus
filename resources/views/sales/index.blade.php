
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Penjualan</h3>
            <p class="text-muted mb-0">Kelola dan lihat transaksi penjualan.</p>
        </div>
        <a href="{{ route('sales.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Transaksi Baru
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No.</th>
                            <th>Invoice</th>
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
                        @forelse($sales as $sale)
                            <tr>
                                <td>{{ $sales->firstItem() + $loop->index }}</td>
                                <td class="fw-semibold">{{ $sale->invoice_number }}</td>
                                <td>{{ \Carbon\Carbon::parse($sale->sale_date)->format('d/m/Y') }}</td>
                                <td>{{ $sale->customer_name ?: 'Umum' }}</td>
                                <td>{{ $sale->cashier_name ?: '-' }}</td>
                                <td>Rp {{ number_format($sale->total, 0, ',', '.') }}</td>
                                <td>{{ strtoupper($sale->payment_method) }}</td>
                                <td>
                                    <span class="badge bg-success">
                                        {{ ucfirst($sale->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('sales.show', $sale->id) }}"
                                       class="btn btn-sm btn-outline-info">
                                        <i class="bi bi-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">
                                    Belum ada transaksi penjualan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $sales->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
