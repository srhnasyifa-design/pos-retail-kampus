
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Detail Supplier</h3>
            <p class="text-muted mb-0">Informasi lengkap pemasok produk.</p>
        </div>
        <a href="{{ route('suppliers.index') }}" class="btn btn-light">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <h5 class="fw-bold">{{ $supplier->name }}</h5>
            <p class="text-muted mb-3">{{ $supplier->company ?: 'Nama perusahaan belum diisi' }}</p>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <small class="text-muted">Nomor Telepon</small>
                    <div>{{ $supplier->phone ?: '-' }}</div>
                </div>
                <div class="col-md-6 mb-3">
                    <small class="text-muted">Email</small>
                    <div>{{ $supplier->email ?: '-' }}</div>
                </div>
                <div class="col-12">
                    <small class="text-muted">Alamat</small>
                    <div>{{ $supplier->address ?: '-' }}</div>
                </div>
            </div>

            <a href="{{ route('suppliers.edit', $supplier->id) }}"
               class="btn btn-primary mt-3">
                <i class="bi bi-pencil"></i> Edit Supplier
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <h5 class="fw-bold mb-3">Produk dari Supplier Ini</h5>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Kode Produk</th>
                            <th>Nama Produk</th>
                            <th>Harga Jual</th>
                            <th>Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td>{{ $product->code }}</td>
                                <td>{{ $product->name }}</td>
                                <td>Rp {{ number_format($product->selling_price, 0, ',', '.') }}</td>
                                <td>{{ $product->stock }} {{ $product->unit }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3">
                                    Belum ada produk dari supplier ini.
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
