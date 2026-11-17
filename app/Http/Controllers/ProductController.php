<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('products')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->leftJoin('suppliers', 'products.supplier_id', '=', 'suppliers.id')
            ->select(
                'products.*',
                'categories.name as category_name',
                'suppliers.name as supplier_name'
            );

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('products.name', 'like', "%{$search}%")
                  ->orWhere('products.code', 'like', "%{$search}%");
            });
        }

        if ($request->status === 'low') {
            $query->whereColumn(
                'products.stock',
                '<=',
                'products.minimum_stock'
            );
        }

        $products = $query
            ->orderByDesc('products.created_at')
            ->paginate(10)
            ->withQueryString();

        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = DB::table('categories')->orderBy('name')->get();
        $suppliers = DB::table('suppliers')->orderBy('name')->get();

        return view('products.create', compact('categories', 'suppliers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:products,code',
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'minimum_stock' => 'required|integer|min:0',
            'unit' => 'required|string|max:30',
            'description' => 'nullable|string',
        ]);

        $validated['created_at'] = now();
        $validated['updated_at'] = now();

        $id = DB::table('products')->insertGetId($validated);

        return redirect()
            ->route('products.show', $id)
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $product = DB::table('products')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->leftJoin('suppliers', 'products.supplier_id', '=', 'suppliers.id')
            ->select(
                'products.*',
                'categories.name as category_name',
                'suppliers.name as supplier_name'
            )
            ->where('products.id', $id)
            ->first();

        abort_if(!$product, 404);

        return view('products.show', compact('product'));
    }

    public function edit(string $id)
    {
        $product = DB::table('products')->where('id', $id)->first();

        abort_if(!$product, 404);

        $categories = DB::table('categories')->orderBy('name')->get();
        $suppliers = DB::table('suppliers')->orderBy('name')->get();

        return view('products.edit', compact(
            'product',
            'categories',
            'suppliers'
        ));
    }

    public function update(Request $request, string $id)
    {
        $product = DB::table('products')->where('id', $id)->first();

        abort_if(!$product, 404);

        $validated = $request->validate([
            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('products', 'code')->ignore($id),
            ],
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'minimum_stock' => 'required|integer|min:0',
            'unit' => 'required|string|max:30',
            'description' => 'nullable|string',
        ]);

        $validated['updated_at'] = now();

        DB::table('products')->where('id', $id)->update($validated);

        return redirect()
            ->route('products.show', $id)
            ->with('success', 'Data produk berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $product = DB::table('products')->where('id', $id)->first();

        abort_if(!$product, 404);

        try {
            DB::table('products')->where('id', $id)->delete();

            return redirect()
                ->route('products.index')
                ->with('success', 'Produk berhasil dihapus.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()
                ->route('products.index')
                ->with('error', 'Produk tidak dapat dihapus karena sudah digunakan dalam transaksi.');
        }
    }
}
