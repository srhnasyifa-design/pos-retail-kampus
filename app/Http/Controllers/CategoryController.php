<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = DB::table('categories')
            ->leftJoin('products', 'categories.id', '=', 'products.category_id')
            ->select(
                'categories.*',
                DB::raw('COUNT(products.id) as products_count')
            )
            ->groupBy(
                'categories.id',
                'categories.name',
                'categories.description',
                'categories.created_at',
                'categories.updated_at'
            )
            ->orderBy('categories.name')
            ->paginate(10);

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
        ]);

        DB::table('categories')->insert([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $category = DB::table('categories')->where('id', $id)->first();

        abort_if(!$category, 404);

        $products = DB::table('products')
            ->where('category_id', $id)
            ->orderBy('name')
            ->get();

        return view('categories.show', compact('category', 'products'));
    }

    public function edit(string $id)
    {
        $category = DB::table('categories')->where('id', $id)->first();

        abort_if(!$category, 404);

        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, string $id)
    {
        $category = DB::table('categories')->where('id', $id)->first();

        abort_if(!$category, 404);

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'name')->ignore($id),
            ],
            'description' => 'nullable|string',
        ]);

        DB::table('categories')->where('id', $id)->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'updated_at' => now(),
        ]);

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $category = DB::table('categories')->where('id', $id)->first();

        abort_if(!$category, 404);

        $jumlahProduk = DB::table('products')
            ->where('category_id', $id)
            ->count();

        if ($jumlahProduk > 0) {
            return redirect()->route('categories.index')
                ->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh produk.');
        }

        DB::table('categories')->where('id', $id)->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
