<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun administrator
        User::updateOrCreate(
            ['email' => 'admin@posretailkampus.test'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password123'),
            ]
        );

        // 2. Akun kasir
        User::updateOrCreate(
            ['email' => 'kasir@posretailkampus.test'],
            [
                'name' => 'Kasir',
                'password' => Hash::make('password123'),
            ]
        );

        // 3. Kategori
        $categories = [
            'Makanan',
            'Minuman',
            'Perawatan',
            'Perlengkapan',
            'Elektronik',
        ];

        foreach ($categories as $category) {
            DB::table('categories')->updateOrInsert(
                ['name' => $category],
                ['description' => 'Kategori ' . $category]
            );
        }

        // 4. Supplier
        $suppliers = [
            ['name' => 'PT Sumber Makmur', 'company' => 'PT Sumber Makmur'],
            ['name' => 'CV Berkah Jaya', 'company' => 'CV Berkah Jaya'],
            ['name' => 'PT Mitra Sejahtera', 'company' => 'PT Mitra Sejahtera'],
        ];

        foreach ($suppliers as $supplier) {
            DB::table('suppliers')->updateOrInsert(
                ['name' => $supplier['name']],
                $supplier
            );
        }

        // 5. Pelanggan
        $customers = [
            ['customer_code' => 'CUS-001', 'name' => 'Sarah Nasyifa'],
            ['customer_code' => 'CUS-002', 'name' => 'Fajira Putri'],
            ['customer_code' => 'CUS-003', 'name' => 'Muhammad Rizki'],
            ['customer_code' => 'CUS-004', 'name' => 'Andika Pratama'],
            ['customer_code' => 'CUS-005', 'name' => 'Ahmad Fauzan'],
        ];

        foreach ($customers as $customer) {
            DB::table('customers')->updateOrInsert(
                ['customer_code' => $customer['customer_code']],
                $customer
            );
        }

        // 6. Produk
        $categoryIds = DB::table('categories')->pluck('id', 'name');
        $supplierIds = DB::table('suppliers')->pluck('id', 'name');

        $products = [
            ['PRD-001', 'Buku Tulis', 'Perlengkapan', 'PT Sumber Makmur', 3500, 5000, 30, 5, 'pcs'],
            ['PRD-002', 'Pulpen', 'Perlengkapan', 'CV Berkah Jaya', 2000, 3500, 3, 5, 'pcs'],
            ['PRD-003', 'Pensil 2B', 'Perlengkapan', 'CV Berkah Jaya', 1500, 2500, 20, 5, 'pcs'],
            ['PRD-004', 'Air Mineral', 'Minuman', 'PT Mitra Sejahtera', 2500, 4000, 25, 5, 'botol'],
            ['PRD-005', 'Teh Botol', 'Minuman', 'PT Mitra Sejahtera', 3500, 5000, 18, 5, 'botol'],
            ['PRD-006', 'Roti Cokelat', 'Makanan', 'PT Sumber Makmur', 4000, 6000, 15, 5, 'pcs'],
            ['PRD-007', 'Mi Instan', 'Makanan', 'PT Sumber Makmur', 2500, 4000, 40, 5, 'pcs'],
            ['PRD-008', 'Sampo Sachet', 'Perawatan', 'CV Berkah Jaya', 1000, 2000, 4, 5, 'sachet'],
            ['PRD-009', 'Sabun Mandi', 'Perawatan', 'CV Berkah Jaya', 3000, 4500, 12, 5, 'pcs'],
            ['PRD-010', 'Flashdisk 16GB', 'Elektronik', 'PT Mitra Sejahtera', 45000, 60000, 10, 3, 'pcs'],
            ['PRD-011', 'Penghapus', 'Perlengkapan', 'PT Sumber Makmur', 1000, 2000, 22, 5, 'pcs'],
        ];

        foreach ($products as $product) {
            DB::table('products')->updateOrInsert(
                ['code' => $product[0]],
                [
                    'name' => $product[1],
                    'category_id' => $categoryIds[$product[2]],
                    'supplier_id' => $supplierIds[$product[3]],
                    'purchase_price' => $product[4],
                    'selling_price' => $product[5],
                    'stock' => $product[6],
                    'minimum_stock' => $product[7],
                    'unit' => $product[8],
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }

        $this->command->info('Data awal POS Retail Kampus berhasil dimasukkan!');
    }
}
