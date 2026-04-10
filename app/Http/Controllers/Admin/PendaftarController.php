<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Exports\CalonSiswaExport;
use App\Models\CalonSiswa;
use App\Models\Berkas;
use App\Models\TahunPmb;
use App\Models\Gelombang;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PendaftarController extends Controller
{
    public function index(Request $request)
    {
        $query = CalonSiswa::with('user')->where('is_arsip', false);

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
        $tahunPmbs = TahunPmb::where('is_active', true)->get();
        $gelombangs = Gelombang::where('is_active', true)->get();

        return view('admin.pendaftar.index', compact('pendaftars', 'tahunPmbs', 'gelombangs'));
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

    public function export(Request $request)
    {
        $filename = 'data-calon-siswa-' . now()->format('Ymd-His') . '.xlsx';
        return Excel::download(new CalonSiswaExport($request), $filename);
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

    public function archive(Request $request)
    {
        $request->validate([
            'pendaftar_ids' => 'required|array',
            'pendaftar_ids.*' => 'exists:calon_siswa,id',
            'tahun_pmb_id' => 'required|exists:tahun_pmb,id',
            'gelombang_id' => 'required|exists:gelombang,id',
        ]);

        CalonSiswa::whereIn('id', $request->pendaftar_ids)->update([
            'tahun_pmb_id' => $request->tahun_pmb_id,
            'gelombang_id' => $request->gelombang_id,
            'is_arsip' => true,
        ]);

        return redirect()->back()->with('success', count($request->pendaftar_ids) . ' data pendaftar berhasil diarsipkan.');
    }

    public function arsip(Request $request)
    {
        $query = CalonSiswa::with(['user', 'tahunPmb', 'gelombang'])->where('is_arsip', true);

        // Filter by tahun PMB
        if ($request->filled('tahun_pmb_id')) {
            $query->where('tahun_pmb_id', $request->tahun_pmb_id);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        $pendaftars = $query->latest('updated_at')->paginate(15);
        $tahunPmbs = TahunPmb::all();
        $gelombangs = Gelombang::all();

        return view('admin.arsip.index', compact('pendaftars', 'tahunPmbs', 'gelombangs'));
    }
    public function updatePassword(Request $request, string $id)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        $pendaftar = CalonSiswa::with('user')->findOrFail($id);
        
        if ($pendaftar->user) {
            $pendaftar->user->update([
                'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            ]);
            return redirect()->back()->with('success', 'Password peserta berhasil diubah.');
        }

        return redirect()->back()->withErrors(['error' => 'Peserta ini belum memiliki akun user.']);
    }
}
