
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Kode Pelanggan</label>
        <input type="text" name="customer_code" class="form-control"
               value="{{ old('customer_code', $customer->customer_code ?? '') }}"
               placeholder="Contoh: CUS-006" required>
        @error('customer_code')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Nama Pelanggan</label>
        <input type="text" name="name" class="form-control"
               value="{{ old('name', $customer->name ?? '') }}"
               placeholder="Masukkan nama pelanggan" required>
        @error('name')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Nomor Telepon</label>
        <input type="text" name="phone" class="form-control"
               value="{{ old('phone', $customer->phone ?? '') }}"
               placeholder="Contoh: 081234567890">
        @error('phone')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control"
               value="{{ old('email', $customer->email ?? '') }}"
               placeholder="pelanggan@email.com">
        @error('email')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="col-12 mb-3">
        <label class="form-label">Alamat</label>
        <textarea name="address" class="form-control" rows="4"
                  placeholder="Masukkan alamat pelanggan">{{ old('address', $customer->address ?? '') }}</textarea>
        @error('address')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
</div>
