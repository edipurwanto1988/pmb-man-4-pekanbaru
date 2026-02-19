<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index()
    {
        $jadwals = Jadwal::orderBy('waktu_mulai', 'desc')->get();
        return view('admin.jadwal.index', compact('jadwals'));
    }

    public function create()
    {
        return view('admin.jadwal.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'jenis' => 'required|in:pendaftaran,verifikasi,tes_akademik,tes_ibadah,pengumuman,daftar_ulang',
            'waktu_mulai' => 'required|date',
            'waktu_selesai' => 'required|date|after:waktu_mulai',
            'keterangan' => 'nullable|string',
        ]);

        Jadwal::create([
            'nama_kegiatan' => $request->nama_kegiatan,
            'jenis' => $request->jenis,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'keterangan' => $request->keterangan,
            'aktif' => $request->boolean('aktif', true),
        ]);

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $jadwal = Jadwal::findOrFail($id);
        return view('admin.jadwal.edit', compact('jadwal'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'jenis' => 'required|in:pendaftaran,verifikasi,tes_akademik,tes_ibadah,pengumuman,daftar_ulang',
            'waktu_mulai' => 'required|date',
            'waktu_selesai' => 'required|date|after:waktu_mulai',
            'keterangan' => 'nullable|string',
        ]);

        $jadwal = Jadwal::findOrFail($id);
        $jadwal->update([
            'nama_kegiatan' => $request->nama_kegiatan,
            'jenis' => $request->jenis,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'keterangan' => $request->keterangan,
            'aktif' => $request->boolean('aktif'),
        ]);

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        Jadwal::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Jadwal berhasil dihapus.');
    }

    public function toggleAktif(string $id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $jadwal->update(['aktif' => !$jadwal->aktif]);
        return redirect()->back()->with('success', 'Status jadwal berhasil diubah.');
    }
}
