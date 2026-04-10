<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengaturanPmb;
use Illuminate\Http\Request;

class PengaturanPmbController extends Controller
{
    public function index()
    {
        $pengaturan = PengaturanPmb::first();
        return view('admin.pengaturan-pmb.index', compact('pengaturan'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'is_tutup' => 'nullable',
            'pesan_tutup' => 'required|string',
        ]);

        $pengaturan = PengaturanPmb::first();
        $pengaturan->update([
            'is_tutup' => $request->has('is_tutup'),
            'pesan_tutup' => $request->pesan_tutup,
        ]);

        return redirect()->back()->with('success', 'Pengaturan PMB berhasil diperbarui.');
    }
}
