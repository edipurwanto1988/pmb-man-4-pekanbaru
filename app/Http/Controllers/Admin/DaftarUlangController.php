<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CalonSiswa;
use App\Models\BerkasDaftarUlang;
use Illuminate\Http\Request;

class DaftarUlangController extends Controller
{
    public function index(Request $request)
    {
        $query = CalonSiswa::with(['user', 'berkasDaftarUlang.syarat'])
            ->whereIn('status', ['lulus_pnbm', 'daftar_ulang', 'resmi_terdaftar']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pendaftars = $query->latest()->paginate(15);

        return view('admin.daftar-ulang.index', compact('pendaftars'));
    }

    public function show(string $id)
    {
        $pendaftar = CalonSiswa::with(['user', 'berkasDaftarUlang.syarat'])->findOrFail($id);
        return view('admin.daftar-ulang.show', compact('pendaftar'));
    }

    public function verifyBerkas(Request $request, string $id)
    {
        $berkas = BerkasDaftarUlang::findOrFail($id);

        $request->validate([
            'status' => 'required|in:verified,rejected',
            'catatan' => 'nullable|string',
        ]);

        $berkas->update([
            'status' => $request->status,
            'catatan' => $request->catatan,
        ]);

        return redirect()->back()->with('success', 'Status berkas daftar ulang berhasil diperbarui.');
    }

    public function konfirmasi(string $id)
    {
        $pendaftar = CalonSiswa::findOrFail($id);
        $pendaftar->update(['status' => 'resmi_terdaftar']);
        return redirect()->back()->with('success', $pendaftar->nama_lengkap . ' resmi terdaftar sebagai siswa baru.');
    }
}
