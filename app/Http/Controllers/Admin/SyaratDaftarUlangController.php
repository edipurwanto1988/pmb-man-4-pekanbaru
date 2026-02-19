<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SyaratDaftarUlang;
use Illuminate\Http\Request;

class SyaratDaftarUlangController extends Controller
{
    public function index()
    {
        $syarats = SyaratDaftarUlang::latest()->get();
        return view('admin.syarat.index', compact('syarats'));
    }

    public function create()
    {
        return view('admin.syarat.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_syarat' => 'required|string|max:255',
            'tipe_file' => 'required|in:image,pdf,image_pdf',
            'keterangan' => 'nullable|string',
        ]);

        SyaratDaftarUlang::create([
            'nama_syarat' => $request->nama_syarat,
            'tipe_file' => $request->tipe_file,
            'is_wajib' => $request->boolean('is_wajib', true),
            'is_multiple' => $request->boolean('is_multiple', false),
            'keterangan' => $request->keterangan,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.syarat.index')->with('success', 'Syarat daftar ulang berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $syarat = SyaratDaftarUlang::findOrFail($id);
        return view('admin.syarat.edit', compact('syarat'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_syarat' => 'required|string|max:255',
            'tipe_file' => 'required|in:image,pdf,image_pdf',
            'keterangan' => 'nullable|string',
        ]);

        $syarat = SyaratDaftarUlang::findOrFail($id);
        $syarat->update([
            'nama_syarat' => $request->nama_syarat,
            'tipe_file' => $request->tipe_file,
            'is_wajib' => $request->boolean('is_wajib'),
            'is_multiple' => $request->boolean('is_multiple'),
            'keterangan' => $request->keterangan,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.syarat.index')->with('success', 'Syarat daftar ulang berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $syarat = SyaratDaftarUlang::findOrFail($id);
        
        // Check if there are related berkas
        if ($syarat->berkas()->count() > 0) {
            return redirect()->back()->with('error', 'Tidak bisa menghapus syarat yang sudah memiliki berkas terupload.');
        }

        $syarat->delete();
        return redirect()->back()->with('success', 'Syarat daftar ulang berhasil dihapus.');
    }
}
