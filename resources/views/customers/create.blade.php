
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h3 class="fw-bold mb-1">Tambah Pelanggan</h3>
        <p class="text-muted mb-0">Masukkan informasi pelanggan baru.</p>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('customers.store') }}" method="POST">
                @csrf

                @include('customers._form')

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Simpan Pelanggan
                    </button>
                    <a href="{{ route('customers.index') }}" class="btn btn-light">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
