<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = DB::table('customers')
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_code' => 'required|string|max:50|unique:customers,customer_code',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:255|unique:customers,email',
            'address' => 'nullable|string',
        ]);

        DB::table('customers')->insert([
            ...$validated,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('customers.index')
            ->with('success', 'Pelanggan berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $customer = DB::table('customers')->where('id', $id)->first();

        abort_if(!$customer, 404);

        $sales = DB::table('sales')
            ->where('customer_id', $id)
            ->orderByDesc('sale_date')
            ->get();

        return view('customers.show', compact('customer', 'sales'));
    }

    public function edit(string $id)
    {
        $customer = DB::table('customers')->where('id', $id)->first();

        abort_if(!$customer, 404);

        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, string $id)
    {
        $customer = DB::table('customers')->where('id', $id)->first();

        abort_if(!$customer, 404);

        $validated = $request->validate([
            'customer_code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('customers', 'customer_code')->ignore($id),
            ],
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:30',
            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('customers', 'email')->ignore($id),
            ],
            'address' => 'nullable|string',
        ]);

        DB::table('customers')->where('id', $id)->update([
            ...$validated,
            'updated_at' => now(),
        ]);

        return redirect()->route('customers.index')
            ->with('success', 'Data pelanggan berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $customer = DB::table('customers')->where('id', $id)->first();

        abort_if(!$customer, 404);

        $jumlahTransaksi = DB::table('sales')
            ->where('customer_id', $id)
            ->count();

        if ($jumlahTransaksi > 0) {
            return redirect()->route('customers.index')
                ->with('error', 'Pelanggan tidak dapat dihapus karena sudah memiliki transaksi.');
        }

        DB::table('customers')->where('id', $id)->delete();

        return redirect()->route('customers.index')
            ->with('success', 'Pelanggan berhasil dihapus.');
    }
}
