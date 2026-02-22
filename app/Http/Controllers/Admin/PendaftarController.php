<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CalonSiswa;
use App\Models\Berkas;
use Illuminate\Http\Request;

class PendaftarController extends Controller
{
    public function index(Request $request)
    {
        $query = CalonSiswa::with('user');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        $pendaftars = $query->latest()->paginate(15);

        return view('admin.pendaftar.index', compact('pendaftars'));
    }

    public function show(string $id)
    {
        $pendaftar = CalonSiswa::with(['user', 'berkas', 'berkasDaftarUlang.syarat', 'hasilTes'])->findOrFail($id);
        return view('admin.pendaftar.show', compact('pendaftar'));
    }

    public function updateStatus(Request $request, string $id)
    {
        $request->validate([
            'status' => 'required|in:terdaftar,menunggu_verifikasi,lulus_administrasi,tidak_lulus_administrasi,lulus_tes,tidak_lulus_tes,lulus_pnbm,tidak_lulus_pnbm,daftar_ulang,resmi_terdaftar',
            'catatan_panitia' => 'nullable|string',
        ]);

        $pendaftar = CalonSiswa::findOrFail($id);
        $pendaftar->update([
            'status' => $request->status,
            'catatan_panitia' => $request->catatan_panitia,
        ]);

        return redirect()->back()->with('success', 'Status pendaftar berhasil diperbarui.');
    }

    public function updateBerkas(Request $request, string $id)
    {
        $request->validate([
            'status'     => 'required|in:pending,diterima,ditolak,perlu_perbaikan',
            'keterangan' => 'nullable|string|max:500',
        ]);

        $berkas = Berkas::findOrFail($id);
        $berkas->update([
            'status'     => $request->status,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->back()->with('success', 'Status berkas berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $pendaftar = CalonSiswa::findOrFail($id);
        
        // Delete user as well (cascade will handle related data)
        if ($pendaftar->user) {
            $pendaftar->user->delete();
        }

        return redirect()->route('admin.pendaftar.index')->with('success', 'Data pendaftar berhasil dihapus.');
    }
}
