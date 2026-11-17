<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $tahun = now()->year;

        // STATISTIK UTAMA
        $totalProduk = DB::table('products')->count();
        $totalKategori = DB::table('categories')->count();
        $totalSupplier = DB::table('suppliers')->count();
        $totalPelanggan = DB::table('customers')->count();
        $totalTransaksi = DB::table('sales')->count();

        $totalPendapatan = DB::table('sales')
            ->where('status', 'completed')
            ->sum('total');

        // PENJUALAN HARI INI
        $transaksiHariIni = DB::table('sales')
            ->where('status', 'completed')
            ->whereDate('sale_date', today())
            ->count();

        $pendapatanHariIni = DB::table('sales')
            ->where('status', 'completed')
            ->whereDate('sale_date', today())
            ->sum('total');

        // PERINGATAN STOK
        $stokHabis = DB::table('products')
            ->where('stock', '<=', 0)
            ->count();

        $stokMenipis = DB::table('products')
            ->whereColumn('stock', '<=', 'minimum_stock')
            ->where('stock', '>', 0)
            ->count();

        $produkStokMenipis = DB::table('products')
            ->whereColumn('stock', '<=', 'minimum_stock')
            ->orderBy('stock', 'asc')
            ->take(6)
            ->get();

        // PRODUK TERBARU
        $produkTerbaru = DB::table('products')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->select(
                'products.*',
                'categories.name as category_name'
            )
            ->latest('products.created_at')
            ->take(5)
            ->get();

        // PRODUK TERLARIS
        $produkTerlaris = DB::table('sale_items')
            ->join('sales', 'sale_items.sale_id', '=', 'sales.id')
            ->join('products', 'sale_items.product_id', '=', 'products.id')
            ->select(
                'products.id',
                'products.code',
                'products.name',
                DB::raw('SUM(sale_items.quantity) as jumlah_terjual'),
                DB::raw('SUM(sale_items.subtotal) as total_penjualan')
            )
            ->where('sales.status', 'completed')
            ->groupBy(
                'products.id',
                'products.code',
                'products.name'
            )
            ->orderByDesc('jumlah_terjual')
            ->take(5)
            ->get();

        // TRANSAKSI TERBARU
        $transaksiTerbaru = DB::table('sales')
            ->leftJoin('customers', 'sales.customer_id', '=', 'customers.id')
            ->leftJoin('users', 'sales.user_id', '=', 'users.id')
            ->select(
                'sales.id',
                'sales.invoice_number',
                'sales.sale_date',
                'sales.total',
                'sales.payment_method',
                'sales.status',
                'customers.name as customer_name',
                'users.name as cashier_name'
            )
            ->orderByDesc('sales.created_at')
            ->take(5)
            ->get();

        // GRAFIK PENJUALAN BULANAN
        $penjualanBulanan = DB::table('sales')
            ->selectRaw('MONTH(sale_date) as bulan, SUM(total) as total')
            ->where('status', 'completed')
            ->whereYear('sale_date', $tahun)
            ->groupByRaw('MONTH(sale_date)')
            ->pluck('total', 'bulan');

        $namaBulan = [
            'Jan', 'Feb', 'Mar', 'Apr',
            'Mei', 'Jun', 'Jul', 'Agu',
            'Sep', 'Okt', 'Nov', 'Des'
        ];

        $dataPenjualan = [];

        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $dataPenjualan[] = (float) ($penjualanBulanan[$bulan] ?? 0);
        }

        // GRAFIK PENJUALAN PER KATEGORI
        $penjualanKategori = DB::table('sale_items')
            ->join('sales', 'sale_items.sale_id', '=', 'sales.id')
            ->join('products', 'sale_items.product_id', '=', 'products.id')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->selectRaw("
                COALESCE(categories.name, 'Tanpa Kategori') as kategori,
                SUM(sale_items.subtotal) as total
            ")
            ->where('sales.status', 'completed')
            ->whereYear('sales.sale_date', $tahun)
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('total')
            ->get();

        $labelKategori = $penjualanKategori
            ->pluck('kategori')
            ->values();

        $dataKategori = $penjualanKategori
            ->pluck('total')
            ->map(fn ($nilai) => (float) $nilai)
            ->values();

        return view('dashboard.index', compact(
            'tahun',
            'totalProduk',
            'totalKategori',
            'totalSupplier',
            'totalPelanggan',
            'totalTransaksi',
            'totalPendapatan',
            'transaksiHariIni',
            'pendapatanHariIni',
            'stokHabis',
            'stokMenipis',
            'produkStokMenipis',
            'produkTerbaru',
            'produkTerlaris',
            'transaksiTerbaru',
            'namaBulan',
            'dataPenjualan',
            'labelKategori',
            'dataKategori'
        ));
    }
}
