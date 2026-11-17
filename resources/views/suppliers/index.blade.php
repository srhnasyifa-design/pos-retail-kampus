
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Data Supplier</h3>
            <p class="text-muted mb-0">Kelola data pemasok produk POS Retail Kampus.</p>
        </div>
        <a href="{{ route('suppliers.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Tambah Supplier
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No.</th>
                            <th>Nama Supplier</th>
                            <th>Nama Perusahaan</th>
                            <th>Telepon</th>
                            <th>Email</th>
                            <th>Jumlah Produk</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($suppliers as $supplier)
                            <tr>
                                <td>{{ $suppliers->firstItem() + $loop->index }}</td>
                                <td class="fw-semibold">{{ $supplier->name }}</td>
                                <td>{{ $supplier->company ?: '-' }}</td>
                                <td>{{ $supplier->phone ?: '-' }}</td>
                                <td>{{ $supplier->email ?: '-' }}</td>
                                <td>
                                    <span class="badge bg-info text-dark">
                                        {{ $supplier->products_count }} Produk
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('suppliers.show', $supplier->id) }}"
                                       class="btn btn-sm btn-outline-info" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('suppliers.edit', $supplier->id) }}"
                                       class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('suppliers.destroy', $supplier->id) }}"
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus supplier ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    Belum ada data supplier.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $suppliers->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
