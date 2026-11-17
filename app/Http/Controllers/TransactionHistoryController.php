<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionHistoryController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('sales')
            ->leftJoin('customers', 'sales.customer_id', '=', 'customers.id')
            ->leftJoin('users', 'sales.user_id', '=', 'users.id')
            ->select(
                'sales.*',
                'customers.name as customer_name',
                'users.name as cashier_name'
            );

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('sales.invoice_number', 'like', "%{$search}%")
                    ->orWhere('customers.name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('start_date')) {
            $query->whereDate('sales.sale_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('sales.sale_date', '<=', $request->end_date);
        }

        if ($request->filled('status')) {
            $query->where('sales.status', $request->status);
        }

        $transaksi = $query
            ->orderByDesc('sales.sale_date')
            ->paginate(10)
            ->withQueryString();

        $totalTransaksi = DB::table('sales')->count();

        $totalPendapatan = DB::table('sales')
            ->where('status', 'completed')
            ->sum('total');

        $jumlahHariIni = DB::table('sales')
            ->whereDate('sale_date', today())
            ->count();

        return view('history.index', compact(
            'transaksi',
            'totalTransaksi',
            'totalPendapatan',
            'jumlahHariIni'
        ));
    }
}
