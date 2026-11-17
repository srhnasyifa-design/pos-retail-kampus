
@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h3 class="fw-bold mb-1">Detail Produk</h3>
            <p class="text-muted mb-0">Informasi lengkap produk.</p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('products.edit', $product->id) }}"
               class="btn btn-primary">
                <i class="bi bi-pencil"></i> Edit Produk
            </a>
            <a href="{{ route('products.index') }}" class="btn btn-light">
                Kembali
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <div class="row g-4">

                <div class="col-md-6">
                    <small class="text-muted">Kode Produk</small>
                    <h5>{{ $product->code }}</h5>
                </div>

                <div class="col-md-6">
                    <small class="text-muted">Nama Produk</small>
                    <h5>{{ $product->name }}</h5>
                </div>

                <div class="col-md-6">
                    <small class="text-muted">Kategori</small>
                    <h5>{{ $product->category_name ?? '-' }}</h5>
                </div>

                <div class="col-md-6">
                    <small class="text-muted">Supplier</small>
                    <h5>{{ $product->supplier_name ?? '-' }}</h5>
                </div>

                <div class="col-md-6">
                    <small class="text-muted">Harga Beli</small>
                    <h5>Rp {{ number_format($product->purchase_price, 0, ',', '.') }}</h5>
                </div>

                <div class="col-md-6">
                    <small class="text-muted">Harga Jual</small>
                    <h5>Rp {{ number_format($product->selling_price, 0, ',', '.') }}</h5>
                </div>

                <div class="col-md-6">
                    <small class="text-muted">Stok</small>
                    <h5>{{ $product->stock }} {{ $product->unit }}</h5>
                </div>

                <div class="col-md-6">
                    <small class="text-muted">Minimal Stok</small>
                    <h5>{{ $product->minimum_stock }} {{ $product->unit }}</h5>
                </div>

                <div class="col-12">
                    <small class="text-muted">Status Stok</small>
                    <div>
                        @if($product->stock <= $product->minimum_stock)
                            <span class="badge bg-danger">Stok Menipis</span>
                        @else
                            <span class="badge bg-success">Tersedia</span>
                        @endif
                    </div>
                </div>

                <div class="col-12">
                    <small class="text-muted">Deskripsi</small>
                    <p class="mb-0">{{ $product->description ?: 'Tidak ada deskripsi.' }}</p>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
