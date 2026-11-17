
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h3 class="fw-bold mb-1">Edit Pelanggan</h3>
        <p class="text-muted mb-0">Perbarui informasi pelanggan.</p>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('customers.update', $customer->id) }}" method="POST">
                @csrf
                @method('PUT')

                @include('customers._form')

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Simpan Perubahan
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
