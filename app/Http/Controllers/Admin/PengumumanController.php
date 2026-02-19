<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CalonSiswa;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    public function index(Request $request)
    {
        // Get students who have completed tests
        $query = CalonSiswa::with(['user', 'hasilTes'])
            ->whereIn('status', ['lulus_tes', 'tidak_lulus_tes', 'lulus_pnbm', 'tidak_lulus_pnbm']);

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

        // Stats
        $stats = [
            'lulus_tes' => CalonSiswa::where('status', 'lulus_tes')->count(),
            'lulus_pnbm' => CalonSiswa::where('status', 'lulus_pnbm')->count(),
            'tidak_lulus_pnbm' => CalonSiswa::where('status', 'tidak_lulus_pnbm')->count(),
        ];

        return view('admin.pengumuman.index', compact('pendaftars', 'stats'));
    }

    public function luluskan(string $id)
    {
        $pendaftar = CalonSiswa::findOrFail($id);
        $pendaftar->update(['status' => 'lulus_pnbm']);
        return redirect()->back()->with('success', $pendaftar->nama_lengkap . ' dinyatakan LULUS PMB.');
    }

    public function tidakLuluskan(Request $request, string $id)
    {
        $request->validate(['catatan_panitia' => 'nullable|string']);

        $pendaftar = CalonSiswa::findOrFail($id);
        $pendaftar->update([
            'status' => 'tidak_lulus_pnbm',
            'catatan_panitia' => $request->catatan_panitia,
        ]);

        return redirect()->back()->with('success', $pendaftar->nama_lengkap . ' dinyatakan TIDAK LULUS PMB.');
    }

    public function luluskanMassal(Request $request)
    {
        $request->validate(['ids' => 'required|array']);
        
        CalonSiswa::whereIn('id', $request->ids)
            ->where('status', 'lulus_tes')
            ->update(['status' => 'lulus_pnbm']);

        return redirect()->back()->with('success', 'Kelulusan massal berhasil diproses.');
    }
}
