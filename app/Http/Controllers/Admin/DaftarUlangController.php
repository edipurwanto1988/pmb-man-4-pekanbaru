<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CalonSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DaftarUlangController extends Controller
{
    public function index(Request $request)
    {
        $query = CalonSiswa::with('user')
            ->whereIn('status', ['lulus_pnbm', 'daftar_ulang', 'resmi_terdaftar', 'tidak_lulus_pnbm']);

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

        $pendaftars = $query->latest()->paginate(20);

        // Ambil info barang bawaan dari settings
        $infoBawaan = DB::table('pengaturan_daftar_ulang')
            ->where('key', 'info_barang_bawaan')
            ->value('value');

        return view('admin.daftar-ulang.index', compact('pendaftars', 'infoBawaan'));
    }

    // Update status lulus/tidak lulus daftar ulang
    public function updateStatus(Request $request, string $id)
    {
        $request->validate([
            'status' => 'required|in:resmi_terdaftar,tidak_lulus_pnbm,daftar_ulang,lulus_pnbm',
        ]);

        $pendaftar = CalonSiswa::findOrFail($id);
        $pendaftar->update(['status' => $request->status]);

        $label = match($request->status) {
            'resmi_terdaftar'  => 'Resmi Terdaftar ✅',
            'tidak_lulus_pnbm' => 'Tidak Lulus ❌',
            'daftar_ulang'     => 'Proses Daftar Ulang',
            'lulus_pnbm'       => 'Lulus PMB',
            default            => ucfirst($request->status),
        };

        return redirect()->back()->with('success', $pendaftar->nama_lengkap . ' → ' . $label);
    }

    // Simpan pengaturan info barang bawaan
    public function saveInfo(Request $request)
    {
        $request->validate([
            'info_barang_bawaan' => 'required|string',
        ]);

        DB::table('pengaturan_daftar_ulang')
            ->updateOrInsert(
                ['key' => 'info_barang_bawaan'],
                ['value' => $request->info_barang_bawaan, 'updated_at' => now()]
            );

        return redirect()->back()->with('success', 'Info barang bawaan berhasil disimpan.');
    }
}
