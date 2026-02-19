<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\BerkasDaftarUlang;
use App\Models\CalonSiswa;
use App\Models\SyaratDaftarUlang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BerkasDaftarUlangController extends Controller
{
    /**
     * Show the upload berkas page for current user (calon siswa).
     */
    public function index()
    {
        $user = Auth::user();
        $calonSiswa = CalonSiswa::where('user_id', $user->id)->first();

        if (!$calonSiswa) {
            return redirect()->route('siswa.dashboard')
                ->with('error', 'Data calon siswa tidak ditemukan. Silakan lengkapi data diri terlebih dahulu.');
        }

        $syarats = SyaratDaftarUlang::where('is_active', true)->get();

        // Get uploaded files for this student
        $uploadedBerkas = BerkasDaftarUlang::where('calon_siswa_id', $calonSiswa->id)
            ->get()
            ->groupBy('syarat_daftar_ulang_id');

        return view('siswa.berkas.index', compact('calonSiswa', 'syarats', 'uploadedBerkas'));
    }

    /**
     * Upload a file for a specific syarat.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $calonSiswa = CalonSiswa::where('user_id', $user->id)->firstOrFail();

        $syarat = SyaratDaftarUlang::findOrFail($request->syarat_id);

        // Determine allowed mimes based on tipe_file
        $mimes = match($syarat->tipe_file) {
            'image' => 'image/jpeg,image/png,image/jpg',
            'pdf' => 'application/pdf',
            'image_pdf' => 'image/jpeg,image/png,image/jpg,application/pdf',
        };

        $mimeRules = match($syarat->tipe_file) {
            'image' => 'mimes:jpg,jpeg,png',
            'pdf' => 'mimes:pdf',
            'image_pdf' => 'mimes:jpg,jpeg,png,pdf',
        };

        $request->validate([
            'file' => 'required|file|' . $mimeRules . '|max:5120', // 5MB
            'syarat_id' => 'required|exists:syarat_daftar_ulang,id',
        ]);

        // If not multiple, check if already uploaded
        if (!$syarat->is_multiple) {
            $existing = BerkasDaftarUlang::where('calon_siswa_id', $calonSiswa->id)
                ->where('syarat_daftar_ulang_id', $syarat->id)
                ->first();
            
            if ($existing) {
                // Replace: delete old file
                Storage::disk('public')->delete($existing->path);
                $existing->delete();
            }
        }

        // Store file
        $file = $request->file('file');
        $path = $file->store('berkas/' . $calonSiswa->id, 'public');

        BerkasDaftarUlang::create([
            'calon_siswa_id' => $calonSiswa->id,
            'syarat_daftar_ulang_id' => $syarat->id,
            'nama_file' => $file->getClientOriginalName(),
            'path' => $path,
            'mime_type' => $file->getMimeType(),
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Berkas "' . $syarat->nama_syarat . '" berhasil diupload.');
    }

    /**
     * Delete an uploaded berkas.
     */
    public function destroy(string $id)
    {
        $user = Auth::user();
        $calonSiswa = CalonSiswa::where('user_id', $user->id)->firstOrFail();

        $berkas = BerkasDaftarUlang::where('id', $id)
            ->where('calon_siswa_id', $calonSiswa->id)
            ->firstOrFail();

        // Only allow delete if status is pending or rejected
        if ($berkas->status === 'verified') {
            return redirect()->back()->with('error', 'Berkas yang sudah diverifikasi tidak bisa dihapus.');
        }

        Storage::disk('public')->delete($berkas->path);
        $berkas->delete();

        return redirect()->back()->with('success', 'Berkas berhasil dihapus.');
    }
}
