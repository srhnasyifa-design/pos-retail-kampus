<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    public function index()
    {
        $setting = DB::table('settings')->first();

        if (!$setting) {
            DB::table('settings')->insert([
                'store_name' => 'POS Retail Kampus',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $setting = DB::table('settings')->first();
        }

        return view('settings.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'store_name' => 'required|string|max:255',
            'store_address' => 'nullable|string',
            'store_phone' => 'nullable|string|max:30',
            'store_email' => 'nullable|email|max:255',
            'receipt_footer' => 'nullable|string',
        ]);

        DB::table('settings')->updateOrInsert(
            ['id' => 1],
            array_merge($validated, [
                'updated_at' => now(),
            ])
        );

        return redirect()
            ->route('settings.index')
            ->with('success', 'Pengaturan toko berhasil disimpan.');
    }
}
