
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h3 class="fw-bold">Tambah Produk</h3>
        <p class="text-muted">Masukkan informasi produk baru.</p>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('products.store') }}" method="POST">
                @csrf

                @include('products._form')

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Simpan Produk
                    </button>
                    <a href="{{ route('products.index') }}" class="btn btn-light">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
