
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Detail Transaksi</h3>
            <p class="text-muted mb-0">Informasi lengkap transaksi penjualan.</p>
        </div>
        <a href="{{ route('sales.index') }}" class="btn btn-light">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <small class="text-muted">Nomor Invoice</small>
                    <h5 class="fw-bold">{{ $sale->invoice_number }}</h5>
                </div>
                <div class="col-md-6 mb-3">
                    <small class="text-muted">Tanggal Transaksi</small>
                    <h6>{{ \Carbon\Carbon::parse($sale->sale_date)->format('d/m/Y') }}</h6>
                </div>
                <div class="col-md-6 mb-3">
                    <small class="text-muted">Pelanggan</small>
                    <div>{{ $sale->customer_name ?: 'Pelanggan Umum' }}</div>
                </div>
                <div class="col-md-6 mb-3">
                    <small class="text-muted">Kasir</small>
                    <div>{{ $sale->cashier_name ?: '-' }}</div>
                </div>
                <div class="col-md-6 mb-3">
                    <small class="text-muted">Metode Pembayaran</small>
                    <div>{{ strtoupper($sale->payment_method) }}</div>
                </div>
                <div class="col-md-6 mb-3">
                    <small class="text-muted">Status</small>
                    <div><span class="badge bg-success">{{ ucfirst($sale->status) }}</span></div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <h5 class="fw-bold mb-3">Produk yang Dibeli</h5>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No.</th>
                            <th>Kode</th>
                            <th>Nama Produk</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->code }}</td>
                                <td>{{ $item->product_name }}</td>
                                <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                <td>{{ $item->quantity }} {{ $item->unit }}</td>
                                <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <div class="row justify-content-end">
                <div class="col-md-5">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal</span>
                        <strong>Rp {{ number_format($sale->subtotal, 0, ',', '.') }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Diskon</span>
                        <strong>Rp {{ number_format($sale->discount, 0, ',', '.') }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Pajak</span>
                        <strong>Rp {{ number_format($sale->tax, 0, ',', '.') }}</strong>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-2">
                        <h5 class="fw-bold">Total</h5>
                        <h5 class="fw-bold text-primary">
                            Rp {{ number_format($sale->total, 0, ',', '.') }}
                        </h5>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Uang Dibayar</span>
                        <strong>Rp {{ number_format($sale->paid_amount, 0, ',', '.') }}</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Kembalian</span>
                        <strong class="text-success">
                            Rp {{ number_format($sale->change_amount, 0, ',', '.') }}
                        </strong>
                    </div>
                </div>
            </div>

            @if($sale->notes)
                <hr>
                <strong>Catatan:</strong>
                <p class="mb-0">{{ $sale->notes }}</p>
            @endif
        </div>
    </div>
</div>
@endsection
