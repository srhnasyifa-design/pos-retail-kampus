
@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <h3 class="fw-bold mb-1">Pengaturan Toko</h3>
        <p class="text-muted mb-0">
            Kelola informasi identitas POS Retail Kampus.
        </p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">

                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="rounded-3 p-3 bg-primary bg-opacity-10 text-primary">
                            <i class="bi bi-shop fs-3"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">Identitas Toko</h5>
                            <small class="text-muted">
                                Informasi utama toko atau usaha.
                            </small>
                        </div>
                    </div>

                    <form action="{{ route('settings.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Toko</label>
                            <input type="text"
                                   name="store_name"
                                   class="form-control"
                                   value="{{ old('store_name', $setting->store_name) }}"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Alamat Toko</label>
                            <textarea name="store_address"
                                      class="form-control"
                                      rows="3"
                                      placeholder="Masukkan alamat toko">{{ old('store_address', $setting->store_address) }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Nomor Telepon</label>
                                <input type="text"
                                       name="store_phone"
                                       class="form-control"
                                       value="{{ old('store_phone', $setting->store_phone) }}"
                                       placeholder="08xxxxxxxxxx">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Email Toko</label>
                                <input type="email"
                                       name="store_email"
                                       class="form-control"
                                       value="{{ old('store_email', $setting->store_email) }}"
                                       placeholder="email@toko.com">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Pesan pada Struk</label>
                            <textarea name="receipt_footer"
                                      class="form-control"
                                      rows="3"
                                      placeholder="Contoh: Terima kasih telah berbelanja.">{{ old('receipt_footer', $setting->receipt_footer) }}</textarea>
                            <small class="text-muted">
                                Pesan ini dapat digunakan pada bagian bawah struk transaksi.
                            </small>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-save me-1"></i>
                                Simpan Pengaturan
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>

        <div class="col-lg-4 mt-3 mt-lg-0">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="text-primary mb-3">
                        <i class="bi bi-info-circle fs-3"></i>
                    </div>

                    <h5 class="fw-bold">Informasi Sistem</h5>
                    <p class="text-muted small">
                        POS Retail Kampus merupakan sistem manajemen retail
                        untuk membantu pengelolaan produk, persediaan,
                        pelanggan, transaksi, dan laporan penjualan.
                    </p>

                    <hr>

                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Nama Aplikasi</span>
                        <strong>POS Retail</strong>
                    </div>

                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Versi</span>
                        <strong>1.0.0</strong>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
