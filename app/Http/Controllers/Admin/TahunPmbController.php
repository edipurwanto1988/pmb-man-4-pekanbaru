<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TahunPmb;
use Illuminate\Http\Request;

class TahunPmbController extends Controller
{
    public function index()
    {
        $items = TahunPmb::orderBy('id', 'desc')->get();
        return view('admin.tahun-pmb.index', compact('items'));
    }

    public function store(Request $request)
    {
        $request->validate(['nama' => 'required|string|max:255']);
        TahunPmb::create([
            'nama' => $request->nama,
            'is_active' => $request->has('is_active') ? true : false,
        ]);
        return back()->with('success', 'Tahun PMB berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate(['nama' => 'required|string|max:255']);
        $item = TahunPmb::findOrFail($id);
        $item->update([
            'nama' => $request->nama,
            'is_active' => $request->has('is_active') ? true : false,
        ]);
        return back()->with('success', 'Tahun PMB berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $item = TahunPmb::findOrFail($id);
        $item->delete();
        return back()->with('success', 'Tahun PMB berhasil dihapus.');
    }
}
