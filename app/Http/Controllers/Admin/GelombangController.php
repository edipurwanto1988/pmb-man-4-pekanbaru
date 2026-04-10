<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gelombang;
use Illuminate\Http\Request;

class GelombangController extends Controller
{
    public function index()
    {
        $items = Gelombang::orderBy('id', 'desc')->get();
        return view('admin.gelombang.index', compact('items'));
    }

    public function store(Request $request)
    {
        $request->validate(['nama' => 'required|string|max:255']);
        Gelombang::create([
            'nama' => $request->nama,
            'is_active' => $request->has('is_active') ? true : false,
        ]);
        return back()->with('success', 'Gelombang berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate(['nama' => 'required|string|max:255']);
        $item = Gelombang::findOrFail($id);
        $item->update([
            'nama' => $request->nama,
            'is_active' => $request->has('is_active') ? true : false,
        ]);
        return back()->with('success', 'Gelombang berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $item = Gelombang::findOrFail($id);
        $item->delete();
        return back()->with('success', 'Gelombang berhasil dihapus.');
    }
}
