<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = DB::table('sales');

        if ($startDate) {
            $query->whereDate('sale_date', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('sale_date', '<=', $endDate);
        }

        $totalTransaksi = (clone $query)->count();

        $totalPendapatan = (clone $query)
            ->where('status', 'completed')
            ->sum('total');

        $rataRata = $totalTransaksi > 0
            ? $totalPendapatan / $totalTransaksi
            : 0;

        $transaksiSelesai = (clone $query)
            ->where('status', 'completed')
            ->count();

        $transaksiDibatalkan = (clone $query)
            ->where('status', 'cancelled')
            ->count();

        $daftarTransaksi = (clone $query)
            ->leftJoin('customers', 'sales.customer_id', '=', 'customers.id')
            ->leftJoin('users', 'sales.user_id', '=', 'users.id')
            ->select(
                'sales.*',
                'customers.name as customer_name',
                'users.name as cashier_name'
            )
            ->orderByDesc('sales.sale_date')
            ->paginate(10)
            ->withQueryString();

        $produkTerlarisQuery = DB::table('sale_items')
            ->join('sales', 'sale_items.sale_id', '=', 'sales.id')
            ->join('products', 'sale_items.product_id', '=', 'products.id')
            ->select(
                'products.name',
                DB::raw('SUM(sale_items.quantity) as total_terjual'),
                DB::raw('SUM(sale_items.subtotal) as total_pendapatan')
            );

        if ($startDate) {
            $produkTerlarisQuery->whereDate('sales.sale_date', '>=', $startDate);
        }

        if ($endDate) {
            $produkTerlarisQuery->whereDate('sales.sale_date', '<=', $endDate);
        }

        $produkTerlaris = $produkTerlarisQuery
            ->where('sales.status', 'completed')
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_terjual')
            ->take(5)
            ->get();

        return view('reports.index', compact(
            'startDate',
            'endDate',
            'totalTransaksi',
            'totalPendapatan',
            'rataRata',
            'transaksiSelesai',
            'transaksiDibatalkan',
            'daftarTransaksi',
            'produkTerlaris'
        ));
    }
}
