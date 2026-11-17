
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Nama Supplier</label>
        <input type="text" name="name" class="form-control"
               value="{{ old('name', $supplier->name ?? '') }}"
               placeholder="Masukkan nama supplier" required>
        @error('name')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Nama Perusahaan</label>
        <input type="text" name="company" class="form-control"
               value="{{ old('company', $supplier->company ?? '') }}"
               placeholder="Masukkan nama perusahaan">
        @error('company')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Nomor Telepon</label>
        <input type="text" name="phone" class="form-control"
               value="{{ old('phone', $supplier->phone ?? '') }}"
               placeholder="Contoh: 081234567890">
        @error('phone')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control"
               value="{{ old('email', $supplier->email ?? '') }}"
               placeholder="supplier@email.com">
        @error('email')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="col-12 mb-3">
        <label class="form-label">Alamat</label>
        <textarea name="address" class="form-control" rows="4"
                  placeholder="Masukkan alamat supplier">{{ old('address', $supplier->address ?? '') }}</textarea>
        @error('address')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
</div>
