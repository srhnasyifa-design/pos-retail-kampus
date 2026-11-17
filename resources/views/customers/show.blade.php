
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Detail Pelanggan</h3>
            <p class="text-muted mb-0">Informasi pelanggan dan riwayat transaksi.</p>
        </div>
        <a href="{{ route('customers.index') }}" class="btn btn-light">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <h5 class="fw-bold">{{ $customer->name }}</h5>
            <span class="badge bg-info text-dark mb-3">
                {{ $customer->customer_code }}
            </span>

            <div class="row mt-2">
                <div class="col-md-6 mb-3">
                    <small class="text-muted">Nomor Telepon</small>
                    <div>{{ $customer->phone ?: '-' }}</div>
                </div>
                <div class="col-md-6 mb-3">
                    <small class="text-muted">Email</small>
                    <div>{{ $customer->email ?: '-' }}</div>
                </div>
                <div class="col-12">
                    <small class="text-muted">Alamat</small>
                    <div>{{ $customer->address ?: '-' }}</div>
                </div>
            </div>

            <a href="{{ route('customers.edit', $customer->id) }}"
               class="btn btn-primary mt-3">
                <i class="bi bi-pencil"></i> Edit Pelanggan
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <h5 class="fw-bold mb-3">Riwayat Transaksi</h5>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No. Invoice</th>
                            <th>Tanggal</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sales as $sale)
                            <tr>
                                <td>{{ $sale->invoice_number }}</td>
                                <td>{{ $sale->sale_date }}</td>
                                <td>Rp {{ number_format($sale->total, 0, ',', '.') }}</td>
                                <td>{{ ucfirst($sale->status) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3">
                                    Pelanggan ini belum memiliki transaksi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
