
@extends('layouts.app')

@section('title', 'Data Produk')
@section('page-title', 'Data Produk')

@section('content')
<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <h3 class="fw-bold mb-1">Data Produk</h3>
            <p class="text-muted mb-0">
                Lihat dan kelola seluruh produk POS Retail Kampus.
            </p>
        </div>

        @if(auth()->user()->role === 'admin')
            <a href="{{ route('products.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Tambah Produk
            </a>
        @endif
    </div>

    {{-- NOTIFIKASI --}}
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

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- TABEL PRODUK --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body">

            {{-- FILTER PENCARIAN --}}
            <form action="{{ route('products.index') }}" method="GET"
                  class="row g-2 mb-4">

                <div class="col-md-6">
                    <input type="text"
                           name="search"
                           class="form-control"
                           placeholder="Cari nama atau kode produk..."
                           value="{{ request('search') }}">
                </div>

                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">Semua Stok</option>
                        <option value="low" {{ request('status') == 'low' ? 'selected' : '' }}>
                            Stok Menipis
                        </option>
                    </select>
                </div>

                <div class="col-md-3 d-flex gap-2">
                    <button class="btn btn-primary" type="submit">
                        <i class="bi bi-search"></i> Cari
                    </button>

                    <a href="{{ route('products.index') }}" class="btn btn-light">
                        Reset
                    </a>
                </div>

            </form>

            {{-- TABEL --}}
            <div class="table-responsive">
                <table class="table table-hover align-middle">

                    <thead class="table-light">
                        <tr>
                            <th>No.</th>
                            <th>Kode</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Supplier</th>
                            <th>Harga Jual</th>
                            <th>Stok</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($products as $index => $product)
                            <tr>
                                <td>{{ $products->firstItem() + $index }}</td>

                                <td>
                                    <span class="fw-semibold">
                                        {{ $product->code }}
                                    </span>
                                </td>

                                <td class="fw-semibold">
                                    {{ $product->name }}
                                </td>

                                <td>{{ $product->category_name ?? '-' }}</td>

                                <td>{{ $product->supplier_name ?? '-' }}</td>

                                <td>
                                    Rp {{ number_format($product->selling_price, 0, ',', '.') }}
                                </td>

                                <td>
                                    {{ $product->stock }} {{ $product->unit }}
                                </td>

                                <td>
                                    @if($product->stock <= $product->minimum_stock)
                                        <span class="badge bg-danger">
                                            Stok Menipis
                                        </span>
                                    @else
                                        <span class="badge bg-success">
                                            Tersedia
                                        </span>
                                    @endif
                                </td>

                                {{-- AKSI --}}
                                <td>
                                    <div class="d-flex gap-1">

                                        {{-- DETAIL: ADMIN DAN KASIR --}}
                                        <a href="{{ route('products.show', $product->id) }}"
                                           class="btn btn-sm btn-outline-info"
                                           title="Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        {{-- EDIT DAN HAPUS: ADMIN --}}
                                        @if(auth()->user()->role === 'admin')

                                            <a href="{{ route('products.edit', $product->id) }}"
                                               class="btn btn-sm btn-outline-primary"
                                               title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>

                                            <form action="{{ route('products.destroy', $product->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Yakin ingin menghapus produk ini?')">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="btn btn-sm btn-outline-danger"
                                                        title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>

                                        @endif

                                    </div>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                    Data produk belum ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

            {{-- PAGINATION --}}
            <div class="mt-3">
                {{ $products->links('pagination::bootstrap-5') }}
            </div>

        </div>
    </div>

</div>
@endsection
