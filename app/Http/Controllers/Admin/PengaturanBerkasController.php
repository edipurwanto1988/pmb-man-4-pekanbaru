<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengaturanBerkas;
use Illuminate\Http\Request;

class PengaturanBerkasController extends Controller
{
    public function index()
    {
        $pengaturan = PengaturanBerkas::orderBy('urutan')->get();
        return view('admin.pengaturan-berkas.index', compact('pengaturan'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'label'  => 'required|string|max:100',
            'wajib'  => 'required|in:0,1',
            'aktif'  => 'required|in:0,1',
            'urutan' => 'required|integer|min:0',
        ]);

        $item = PengaturanBerkas::findOrFail($id);
        $item->update([
            'label'  => $request->label,
            'wajib'  => $request->wajib,
            'aktif'  => $request->aktif,
            'urutan' => $request->urutan,
        ]);

        return redirect()->back()->with('success', 'Pengaturan berkas berhasil disimpan.');
    }
}
