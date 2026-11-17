
<div class="mb-3">
    <label class="form-label">Nama Kategori</label>
    <input type="text" name="name" class="form-control"
           value="{{ old('name', $category->name ?? '') }}"
           placeholder="Contoh: Makanan" required>
    @error('name')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Deskripsi</label>
    <textarea name="description" class="form-control" rows="4"
              placeholder="Masukkan deskripsi kategori">{{ old('description', $category->description ?? '') }}</textarea>
    @error('description')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>
