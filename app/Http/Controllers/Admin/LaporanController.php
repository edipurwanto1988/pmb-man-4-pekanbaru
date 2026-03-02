<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Exports\CalonSiswaExport;
use App\Models\CalonSiswa;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function pendaftar(Request $request)
    {
        $query = CalonSiswa::with('user');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->filled('dari_tanggal')) {
            $query->whereDate('created_at', '>=', $request->dari_tanggal);
        }
        if ($request->filled('sampai_tanggal')) {
            $query->whereDate('created_at', '<=', $request->sampai_tanggal);
        }

        // Filter by gender
        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        // Filter by jurusan
        if ($request->filled('jurusan')) {
            $query->where('jurusan_pilihan', $request->jurusan);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%")
                  ->orWhere('asal_sekolah', 'like', "%{$search}%");
            });
        }

        // Statistics
        $allQuery = CalonSiswa::query();

        // Apply same filters to stats (except status)
        if ($request->filled('dari_tanggal')) {
            $allQuery->whereDate('created_at', '>=', $request->dari_tanggal);
        }
        if ($request->filled('sampai_tanggal')) {
            $allQuery->whereDate('created_at', '<=', $request->sampai_tanggal);
        }
        if ($request->filled('jenis_kelamin')) {
            $allQuery->where('jenis_kelamin', $request->jenis_kelamin);
        }
        if ($request->filled('jurusan')) {
            $allQuery->where('jurusan_pilihan', $request->jurusan);
        }

        $stats = [
            'total' => (clone $allQuery)->count(),
            'laki' => (clone $allQuery)->where('jenis_kelamin', 'L')->count(),
            'perempuan' => (clone $allQuery)->where('jenis_kelamin', 'P')->count(),
            'terdaftar' => (clone $allQuery)->where('status', 'terdaftar')->count(),
            'menunggu_verifikasi' => (clone $allQuery)->where('status', 'menunggu_verifikasi')->count(),
            'lulus_administrasi' => (clone $allQuery)->where('status', 'lulus_administrasi')->count(),
            'lulus_tes' => (clone $allQuery)->where('status', 'lulus_tes')->count(),
            'lulus_pnbm' => (clone $allQuery)->where('status', 'lulus_pnbm')->count(),
            'daftar_ulang' => (clone $allQuery)->where('status', 'daftar_ulang')->count(),
            'resmi_terdaftar' => (clone $allQuery)->where('status', 'resmi_terdaftar')->count(),
        ];

        // Get available jurusan for filter
        $jurusanList = CalonSiswa::select('jurusan_pilihan')->distinct()->whereNotNull('jurusan_pilihan')->pluck('jurusan_pilihan');

        $pendaftars = $query->latest()->paginate(20);

        return view('admin.laporan.pendaftar', compact('pendaftars', 'stats', 'jurusanList'));
    }

    public function exportPendaftar(Request $request)
    {
        $filename = 'laporan-pendaftar-' . now()->format('Ymd-His') . '.xlsx';
        return Excel::download(new CalonSiswaExport($request), $filename);
    }
}
