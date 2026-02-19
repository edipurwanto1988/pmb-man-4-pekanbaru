<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berkas;
use App\Models\CalonSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VerifikasiController extends Controller
{
    public function index(Request $request)
    {
        $query = CalonSiswa::with('user')
            ->whereIn('status', ['menunggu_verifikasi', 'lulus_administrasi', 'tidak_lulus_administrasi']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        $pendaftars = $query->latest()->paginate(15);

        return view('admin.verifikasi.index', compact('pendaftars'));
    }

    public function show(string $id)
    {
        $pendaftar = CalonSiswa::with(['user', 'berkas'])->findOrFail($id);
        return view('admin.verifikasi.show', compact('pendaftar'));
    }

    public function updateBerkas(Request $request, string $id)
    {
        $berkas = Berkas::findOrFail($id);

        $request->validate([
            'status' => 'required|in:diterima,ditolak,perlu_perbaikan',
            'keterangan' => 'nullable|string',
        ]);

        $berkas->update([
            'status' => $request->status,
            'keterangan' => $request->keterangan,
        ]);

        // Check if all berkas are verified - auto update student status
        $calonSiswa = $berkas->calonSiswa;
        $totalBerkas = $calonSiswa->berkas()->count();
        $berkasAccepted = $calonSiswa->berkas()->where('status', 'diterima')->count();
        $berkasRejected = $calonSiswa->berkas()->where('status', 'ditolak')->count();

        if ($totalBerkas > 0 && $berkasAccepted == $totalBerkas) {
            $calonSiswa->update(['status' => 'lulus_administrasi']);
        } elseif ($berkasRejected > 0) {
            $calonSiswa->update(['status' => 'tidak_lulus_administrasi']);
        }

        return redirect()->back()->with('success', 'Status berkas berhasil diperbarui.');
    }

    public function luluskanAdministrasi(string $id)
    {
        $pendaftar = CalonSiswa::findOrFail($id);
        $pendaftar->update([
            'status' => 'lulus_administrasi',
        ]);

        return redirect()->back()->with('success', 'Pendaftar dinyatakan lulus administrasi.');
    }

    public function tolakAdministrasi(Request $request, string $id)
    {
        $request->validate(['catatan_panitia' => 'required|string']);

        $pendaftar = CalonSiswa::findOrFail($id);
        $pendaftar->update([
            'status' => 'tidak_lulus_administrasi',
            'catatan_panitia' => $request->catatan_panitia,
        ]);

        return redirect()->back()->with('success', 'Pendaftar dinyatakan tidak lulus administrasi.');
    }
}
