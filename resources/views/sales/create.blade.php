
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h3 class="fw-bold mb-1">Transaksi Penjualan Baru</h3>
        <p class="text-muted mb-0">Masukkan produk yang dibeli pelanggan.</p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Transaksi belum dapat disimpan:</strong>
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form action="{{ route('sales.store') }}" method="POST" id="saleForm">
        @csrf

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3">Informasi Transaksi</h5>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Pelanggan</label>
                        <select name="customer_id" class="form-select">
                            <option value="">Pelanggan Umum</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}"
                                    @selected(old('customer_id') == $customer->id)>
                                    {{ $customer->customer_code }} - {{ $customer->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Transaksi</label>
                        <input type="date" name="sale_date" class="form-control"
                               value="{{ old('sale_date', date('Y-m-d')) }}" required>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0">Daftar Produk</h5>
                    <button type="button" class="btn btn-sm btn-outline-primary" id="addProduct">
                        <i class="bi bi-plus-lg"></i> Tambah Produk
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="min-width:230px">Produk</th>
                                <th style="min-width:130px">Harga</th>
                                <th style="min-width:110px">Jumlah</th>
                                <th style="min-width:140px">Subtotal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="productRows"></tbody>
                    </table>
                </div>

                <template id="productTemplate">
                    <tr class="product-row">
                        <td>
                            <select class="form-select product-select" required>
                                <option value="">Pilih Produk</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}"
                                            data-price="{{ $product->selling_price }}"
                                            data-stock="{{ $product->stock }}">
                                        {{ $product->code }} - {{ $product->name }}
                                        (Stok: {{ $product->stock }})
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td class="price-text">Rp 0</td>
                        <td>
                            <input type="number" class="form-control quantity-input"
                                   min="1" value="1" required>
                        </td>
                        <td class="subtotal-text fw-semibold">Rp 0</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-outline-danger remove-row">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                </template>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3">Pembayaran</h5>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Diskon (Rp)</label>
                            <input type="number" name="discount" id="discount"
                                   class="form-control" min="0"
                                   value="{{ old('discount', 0) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Pajak (Rp)</label>
                            <input type="number" name="tax" id="tax"
                                   class="form-control" min="0"
                                   value="{{ old('tax', 0) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Metode Pembayaran</label>
                            <select name="payment_method" class="form-select" required>
                                <option value="cash">Tunai</option>
                                <option value="transfer">Transfer</option>
                                <option value="qris">QRIS</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Catatan</label>
                            <textarea name="notes" class="form-control" rows="2"
                                      placeholder="Catatan transaksi (opsional)">{{ old('notes') }}</textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="bg-light rounded p-4">
                            <div class="d-flex justify-content-between mb-3">
                                <span>Subtotal</span>
                                <strong id="subtotalDisplay">Rp 0</strong>
                            </div>

                            <div class="d-flex justify-content-between mb-3">
                                <span>Diskon</span>
                                <strong id="discountDisplay">Rp 0</strong>
                            </div>

                            <div class="d-flex justify-content-between mb-3">
                                <span>Pajak</span>
                                <strong id="taxDisplay">Rp 0</strong>
                            </div>

                            <hr>

                            <div class="d-flex justify-content-between mb-3">
                                <span class="fw-bold">Total Bayar</span>
                                <h4 class="fw-bold text-primary mb-0" id="totalDisplay">Rp 0</h4>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Uang Dibayar (Rp)</label>
                                <input type="number" name="paid_amount" id="paidAmount"
                                       class="form-control form-control-lg"
                                       min="0" value="{{ old('paid_amount', 0) }}" required>
                            </div>

                            <div class="d-flex justify-content-between">
                                <span>Kembalian</span>
                                <strong class="text-success" id="changeDisplay">Rp 0</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('sales.index') }}" class="btn btn-light">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Simpan Transaksi
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const rows = document.getElementById('productRows');
    const template = document.getElementById('productTemplate');
    const addButton = document.getElementById('addProduct');
    let rowIndex = 0;

    const rupiah = value => 'Rp ' + Number(value || 0).toLocaleString('id-ID');

    function updateTotals() {
        let subtotal = 0;

        rows.querySelectorAll('.product-row').forEach(row => {
            const select = row.querySelector('.product-select');
            const quantity = row.querySelector('.quantity-input');
            const option = select.options[select.selectedIndex];

            const price = Number(option?.dataset.price || 0);
            const stock = Number(option?.dataset.stock || 0);
            const qty = Number(quantity.value || 0);

            row.querySelector('.price-text').textContent = rupiah(price);
            row.querySelector('.subtotal-text').textContent = rupiah(price * qty);

            if (select.value && qty > stock) {
                quantity.setCustomValidity('Jumlah melebihi stok tersedia (' + stock + ').');
            } else {
                quantity.setCustomValidity('');
            }

            subtotal += price * qty;
        });

        const discount = Number(document.getElementById('discount').value || 0);
        const tax = Number(document.getElementById('tax').value || 0);
        const total = Math.max(0, subtotal - discount + tax);
        const paid = Number(document.getElementById('paidAmount').value || 0);

        document.getElementById('subtotalDisplay').textContent = rupiah(subtotal);
        document.getElementById('discountDisplay').textContent = rupiah(discount);
        document.getElementById('taxDisplay').textContent = rupiah(tax);
        document.getElementById('totalDisplay').textContent = rupiah(total);
        document.getElementById('changeDisplay').textContent = rupiah(Math.max(0, paid - total));
        document.getElementById('paidAmount').min = total;
    }

    function addRow() {
        const fragment = template.content.cloneNode(true);
        const row = fragment.querySelector('.product-row');

        row.querySelector('.product-select').name =
            `items[${rowIndex}][product_id]`;

        row.querySelector('.quantity-input').name =
            `items[${rowIndex}][quantity]`;

        rowIndex++;
        rows.appendChild(fragment);
        updateTotals();
    }

    addButton.addEventListener('click', addRow);

    rows.addEventListener('change', updateTotals);
    rows.addEventListener('input', updateTotals);

    rows.addEventListener('click', function (event) {
        const button = event.target.closest('.remove-row');

        if (button) {
            button.closest('.product-row').remove();
            updateTotals();
        }
    });

    document.getElementById('discount').addEventListener('input', updateTotals);
    document.getElementById('tax').addEventListener('input', updateTotals);
    document.getElementById('paidAmount').addEventListener('input', updateTotals);

    document.getElementById('saleForm').addEventListener('submit', function (event) {
        if (rows.querySelectorAll('.product-row').length === 0) {
            event.preventDefault();
            alert('Tambahkan minimal satu produk terlebih dahulu.');
        }
    });

    addRow();
});
</script>
@endsection
