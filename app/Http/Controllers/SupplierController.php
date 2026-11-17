<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = DB::table('suppliers')
            ->leftJoin('products', 'suppliers.id', '=', 'products.supplier_id')
            ->select(
                'suppliers.*',
                DB::raw('COUNT(products.id) as products_count')
            )
            ->groupBy(
                'suppliers.id',
                'suppliers.name',
                'suppliers.company',
                'suppliers.phone',
                'suppliers.email',
                'suppliers.address',
                'suppliers.created_at',
                'suppliers.updated_at'
            )
            ->orderBy('suppliers.name')
            ->paginate(10);

        return view('suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('suppliers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:255|unique:suppliers,email',
            'address' => 'nullable|string',
        ]);

        DB::table('suppliers')->insert([
            ...$validated,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('suppliers.index')
            ->with('success', 'Supplier berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $supplier = DB::table('suppliers')->where('id', $id)->first();

        abort_if(!$supplier, 404);

        $products = DB::table('products')
            ->where('supplier_id', $id)
            ->orderBy('name')
            ->get();

        return view('suppliers.show', compact('supplier', 'products'));
    }

    public function edit(string $id)
    {
        $supplier = DB::table('suppliers')->where('id', $id)->first();

        abort_if(!$supplier, 404);

        return view('suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, string $id)
    {
        $supplier = DB::table('suppliers')->where('id', $id)->first();

        abort_if(!$supplier, 404);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:30',
            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('suppliers', 'email')->ignore($id),
            ],
            'address' => 'nullable|string',
        ]);

        DB::table('suppliers')->where('id', $id)->update([
            ...$validated,
            'updated_at' => now(),
        ]);

        return redirect()->route('suppliers.index')
            ->with('success', 'Data supplier berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $supplier = DB::table('suppliers')->where('id', $id)->first();

        abort_if(!$supplier, 404);

        DB::table('suppliers')->where('id', $id)->delete();

        return redirect()->route('suppliers.index')
            ->with('success', 'Supplier berhasil dihapus.');
    }
}
