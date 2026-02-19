<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CalonSiswa;
use App\Models\HasilTes;
use Illuminate\Http\Request;

class PenilaianController extends Controller
{
    public function index(Request $request)
    {
        $query = CalonSiswa::with(['user', 'hasilTes'])
            ->whereIn('status', ['lulus_administrasi', 'lulus_tes', 'tidak_lulus_tes']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        $peserta = $query->latest()->paginate(15);

        return view('admin.penilaian.index', compact('peserta'));
    }

    public function show(string $id)
    {
        $pendaftar = CalonSiswa::with(['user', 'hasilTes'])->findOrFail($id);
        
        // Get or initialize results
        $akademik = $pendaftar->hasilTes()->where('jenis_tes', 'akademik')->first();
        $ibadah = $pendaftar->hasilTes()->where('jenis_tes', 'ibadah')->first();

        return view('admin.penilaian.show', compact('pendaftar', 'akademik', 'ibadah'));
    }

    public function store(Request $request, string $id)
    {
        $request->validate([
            'jenis_tes' => 'required|in:akademik,ibadah',
            'nilai' => 'required|numeric|min:0|max:100',
            'status' => 'required|in:lulus,tidak_lulus,belum_dinilai',
            'catatan' => 'nullable|string',
            'tanggal_tes' => 'nullable|date',
        ]);

        $pendaftar = CalonSiswa::findOrFail($id);

        HasilTes::updateOrCreate(
            [
                'calon_siswa_id' => $pendaftar->id,
                'jenis_tes' => $request->jenis_tes,
            ],
            [
                'nilai' => $request->nilai,
                'status' => $request->status,
                'catatan' => $request->catatan,
                'tanggal_tes' => $request->tanggal_tes,
            ]
        );

        // Auto-update student status based on test results
        $this->updateStudentTestStatus($pendaftar);

        return redirect()->back()->with('success', 'Nilai tes berhasil disimpan.');
    }

    private function updateStudentTestStatus(CalonSiswa $pendaftar)
    {
        $akademik = $pendaftar->hasilTes()->where('jenis_tes', 'akademik')->first();
        $ibadah = $pendaftar->hasilTes()->where('jenis_tes', 'ibadah')->first();

        if ($akademik && $ibadah) {
            if ($akademik->status === 'lulus' && $ibadah->status === 'lulus') {
                $pendaftar->update(['status' => 'lulus_tes']);
            } elseif ($akademik->status === 'tidak_lulus' || $ibadah->status === 'tidak_lulus') {
                $pendaftar->update(['status' => 'tidak_lulus_tes']);
            }
        }
    }
}
