
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Kode Produk</label>
        <input type="text" name="code" class="form-control"
            value="{{ old('code', $product->code ?? '') }}"
            placeholder="Contoh: PRD-012" required>
        @error('code')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Nama Produk</label>
        <input type="text" name="name" class="form-control"
            value="{{ old('name', $product->name ?? '') }}"
            placeholder="Masukkan nama produk" required>
        @error('name')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Kategori</label>
        <select name="category_id" class="form-select" required>
            <option value="">Pilih Kategori</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}"
                    @selected(old('category_id', $product->category_id ?? '') == $category->id)>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        @error('category_id')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Supplier</label>
        <select name="supplier_id" class="form-select">
            <option value="">Pilih Supplier</option>
            @foreach($suppliers as $supplier)
                <option value="{{ $supplier->id }}"
                    @selected(old('supplier_id', $product->supplier_id ?? '') == $supplier->id)>
                    {{ $supplier->name }}
                </option>
            @endforeach
        </select>
        @error('supplier_id')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Harga Beli</label>
        <input type="number" name="purchase_price" class="form-control"
            value="{{ old('purchase_price', $product->purchase_price ?? '') }}"
            min="0" required>
        @error('purchase_price')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Harga Jual</label>
        <input type="number" name="selling_price" class="form-control"
            value="{{ old('selling_price', $product->selling_price ?? '') }}"
            min="0" required>
        @error('selling_price')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Stok</label>
        <input type="number" name="stock" class="form-control"
            value="{{ old('stock', $product->stock ?? 0) }}"
            min="0" required>
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Minimal Stok</label>
        <input type="number" name="minimum_stock" class="form-control"
            value="{{ old('minimum_stock', $product->minimum_stock ?? 5) }}"
            min="0" required>
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Satuan</label>
        <select name="unit" class="form-select" required>
            @foreach(['pcs', 'botol', 'sachet', 'pack', 'dus', 'kg', 'liter'] as $unit)
                <option value="{{ $unit }}"
                    @selected(old('unit', $product->unit ?? 'pcs') == $unit)>
                    {{ ucfirst($unit) }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-12 mb-3">
        <label class="form-label">Deskripsi</label>
        <textarea name="description" class="form-control" rows="3"
            placeholder="Masukkan deskripsi produk">{{ old('description', $product->description ?? '') }}</textarea>
    </div>
</div>
