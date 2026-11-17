
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Detail Kategori</h3>
            <p class="text-muted mb-0">Informasi kategori dan produk di dalamnya.</p>
        </div>
        <a href="{{ route('categories.index') }}" class="btn btn-light">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <h5 class="fw-bold">{{ $category->name }}</h5>
            <p class="text-muted mb-2">
                {{ $category->description ?: 'Tidak ada deskripsi.' }}
            </p>
            <span class="badge bg-info text-dark">
                {{ $products->count() }} Produk
            </span>

            <div class="mt-3">
                <a href="{{ route('categories.edit', $category->id) }}"
                   class="btn btn-primary">
                    <i class="bi bi-pencil"></i> Edit Kategori
                </a>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <h5 class="fw-bold mb-3">Daftar Produk</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Kode</th>
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
                                    Belum ada produk dalam kategori ini.
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
