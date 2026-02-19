<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Berkas;
use App\Models\CalonSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BerkasAwalController extends Controller
{
    /**
     * Show the upload berkas awal page for current user.
     */
    public function index()
    {
        $user = Auth::user();
        $calonSiswa = CalonSiswa::where('user_id', $user->id)->first();

        if (!$calonSiswa) {
            return redirect()->route('siswa.dashboard')
                ->with('error', 'Data calon siswa tidak ditemukan.');
        }

        $jenisBerkas = [
            'ijazah' => ['label' => 'Ijazah / SKHUN', 'required' => true],
            'kk' => ['label' => 'Kartu Keluarga', 'required' => true],
            'akta' => ['label' => 'Akta Kelahiran', 'required' => true],
            'foto' => ['label' => 'Pas Foto 3x4', 'required' => true],
            'raport' => ['label' => 'Raport Terakhir', 'required' => false],
        ];

        $uploadedBerkas = Berkas::where('calon_siswa_id', $calonSiswa->id)
            ->get()
            ->keyBy('jenis_berkas');

        return view('siswa.berkas-awal.index', compact('calonSiswa', 'jenisBerkas', 'uploadedBerkas'));
    }

    /**
     * Upload a file for a specific jenis berkas.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $calonSiswa = CalonSiswa::where('user_id', $user->id)->firstOrFail();

        $request->validate([
            'jenis_berkas' => 'required|in:ijazah,kk,akta,foto,raport',
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        // Check if already uploaded — replace
        $existing = Berkas::where('calon_siswa_id', $calonSiswa->id)
            ->where('jenis_berkas', $request->jenis_berkas)
            ->first();

        if ($existing) {
            Storage::disk('public')->delete($existing->path);
            $existing->delete();
        }

        $file = $request->file('file');
        $path = $file->store('berkas-awal/' . $calonSiswa->id, 'public');

        Berkas::create([
            'calon_siswa_id' => $calonSiswa->id,
            'jenis_berkas' => $request->jenis_berkas,
            'nama_file' => $file->getClientOriginalName(),
            'path' => $path,
            'status' => 'pending',
        ]);

        // Update status to menunggu_verifikasi if all required berkas are uploaded
        $requiredTypes = ['ijazah', 'kk', 'akta', 'foto'];
        $uploadedCount = Berkas::where('calon_siswa_id', $calonSiswa->id)
            ->whereIn('jenis_berkas', $requiredTypes)
            ->count();

        if ($uploadedCount >= count($requiredTypes) && $calonSiswa->status === 'terdaftar') {
            $calonSiswa->update(['status' => 'menunggu_verifikasi']);
        }

        return redirect()->back()->with('success', 'Berkas berhasil diupload.');
    }

    /**
     * Delete an uploaded berkas.
     */
    public function destroy(string $id)
    {
        $user = Auth::user();
        $calonSiswa = CalonSiswa::where('user_id', $user->id)->firstOrFail();

        $berkas = Berkas::where('id', $id)
            ->where('calon_siswa_id', $calonSiswa->id)
            ->firstOrFail();

        if ($berkas->status === 'diterima') {
            return redirect()->back()->with('error', 'Berkas yang sudah diterima tidak bisa dihapus.');
        }

        Storage::disk('public')->delete($berkas->path);
        $berkas->delete();

        return redirect()->back()->with('success', 'Berkas berhasil dihapus.');
    }
}
