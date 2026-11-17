<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SaleController extends Controller
{
    public function index()
    {
        $sales = DB::table('sales')
            ->leftJoin('customers', 'sales.customer_id', '=', 'customers.id')
            ->leftJoin('users', 'sales.user_id', '=', 'users.id')
            ->select(
                'sales.*',
                'customers.name as customer_name',
                'users.name as cashier_name'
            )
            ->orderByDesc('sales.sale_date')
            ->paginate(10);

        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $products = DB::table('products')
            ->where('stock', '>', 0)
            ->orderBy('name')
            ->get();

        $customers = DB::table('customers')
            ->orderBy('name')
            ->get();

        return view('sales.create', compact('products', 'customers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'sale_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'discount' => 'nullable|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'paid_amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,transfer,qris',
            'notes' => 'nullable|string',
        ]);

        $userId = DB::table('users')->value('id');

        if (!$userId) {
            throw ValidationException::withMessages([
                'payment_method' => 'Buat akun pengguna terlebih dahulu sebelum menyimpan transaksi.',
            ]);
        }

        DB::transaction(function () use ($validated, $userId) {
            $subtotal = 0;
            $saleItems = [];

            foreach ($validated['items'] as $item) {
                $product = DB::table('products')
                    ->where('id', $item['product_id'])
                    ->lockForUpdate()
                    ->first();

                if (!$product || $product->stock < $item['quantity']) {
                    throw ValidationException::withMessages([
                        'items' => 'Stok produk ' . ($product->name ?? '') . ' tidak mencukupi.',
                    ]);
                }

                $itemSubtotal = $product->selling_price * $item['quantity'];
                $subtotal += $itemSubtotal;

                $saleItems[] = [
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->selling_price,
                    'subtotal' => $itemSubtotal,
                ];
            }

            $discount = $validated['discount'] ?? 0;
            $tax = $validated['tax'] ?? 0;
            $total = max(0, $subtotal - $discount + $tax);
            $paidAmount = $validated['paid_amount'];

            if ($paidAmount < $total) {
                throw ValidationException::withMessages([
                    'paid_amount' => 'Jumlah pembayaran masih kurang dari total transaksi.',
                ]);
            }

            $invoiceNumber = 'INV-' . now()->format('YmdHis') . '-' .
                strtoupper(substr(uniqid(), -4));

            $saleId = DB::table('sales')->insertGetId([
                'invoice_number' => $invoiceNumber,
                'customer_id' => $validated['customer_id'] ?? null,
                'user_id' => $userId,
                'sale_date' => $validated['sale_date'],
                'subtotal' => $subtotal,
                'discount' => $discount,
                'tax' => $tax,
                'total' => $total,
                'paid_amount' => $paidAmount,
                'change_amount' => $paidAmount - $total,
                'payment_method' => $validated['payment_method'],
                'status' => 'completed',
                'notes' => $validated['notes'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach ($saleItems as $item) {
                DB::table('sale_items')->insert([
                    'sale_id' => $saleId,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['subtotal'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                DB::table('products')
                    ->where('id', $item['product_id'])
                    ->decrement('stock', $item['quantity']);
            }
        });

        return redirect()->route('sales.index')
            ->with('success', 'Transaksi berhasil disimpan dan stok produk telah diperbarui.');
    }

    public function show(string $id)
    {
        $sale = DB::table('sales')
            ->leftJoin('customers', 'sales.customer_id', '=', 'customers.id')
            ->leftJoin('users', 'sales.user_id', '=', 'users.id')
            ->where('sales.id', $id)
            ->select(
                'sales.*',
                'customers.name as customer_name',
                'users.name as cashier_name'
            )
            ->first();

        abort_if(!$sale, 404);

        $items = DB::table('sale_items')
            ->join('products', 'sale_items.product_id', '=', 'products.id')
            ->where('sale_items.sale_id', $id)
            ->select(
                'sale_items.*',
                'products.code',
                'products.name as product_name',
                'products.unit'
            )
            ->get();

        return view('sales.show', compact('sale', 'items'));
    }
}
