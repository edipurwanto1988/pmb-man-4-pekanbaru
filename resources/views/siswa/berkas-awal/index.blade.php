<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <i class="ri-folder-upload-line mr-2"></i> Upload Berkas Pendaftaran
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            {{-- Alert success / error --}}
            @if(session('success'))
                <div id="alert-success" class="mb-4 p-4 bg-green-50 dark:bg-green-900/50 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 rounded-lg flex items-center gap-2">
                    <i class="ri-checkbox-circle-line text-lg"></i>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 p-4 bg-red-50 dark:bg-red-900/50 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 rounded-lg flex items-center gap-2">
                    <i class="ri-error-warning-line text-lg"></i>
                    {{ session('error') }}
                </div>
            @endif

            {{-- Info --}}
            <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4 mb-6 flex items-start gap-2">
                <i class="ri-information-line text-blue-500 text-lg mt-0.5 flex-shrink-0"></i>
                <p class="text-sm text-blue-800 dark:text-blue-200">
                    <strong>Petunjuk:</strong> Upload semua berkas yang ditandai <span class="text-red-500">*wajib</span>.
                    Format file yang diterima: JPG, JPEG, PNG, PDF. Maksimal <strong>5MB</strong> per file.
                </p>
            </div>

            {{-- Berkas Cards --}}
            <div class="space-y-4">
                @foreach($jenisBerkas as $key => $info)
                    @php $uploaded = $uploadedBerkas[$key] ?? null; @endphp

                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                        {{-- Header card --}}
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">
                                    {{ $info['label'] }}
                                    @if($info['required'])
                                        <span class="text-red-500 text-xs ml-1">*wajib</span>
                                    @else
                                        <span class="text-gray-400 text-xs ml-1">(opsional)</span>
                                    @endif
                                </h3>
                            </div>
                            @if($uploaded)
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold
                                    {{ $uploaded->status == 'pending'         ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' : '' }}
                                    {{ $uploaded->status == 'diterima'        ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : '' }}
                                    {{ $uploaded->status == 'ditolak'         ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : '' }}
                                    {{ $uploaded->status == 'perlu_perbaikan' ? 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200' : '' }}
                                ">
                                    {{ ucfirst(str_replace('_', ' ', $uploaded->status)) }}
                                </span>
                            @endif
                        </div>

                        {{-- Berkas sudah diupload --}}
                        @if($uploaded)
                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg mb-3">
                                <div class="flex items-center gap-3">
                                    {{-- Icon sesuai tipe file --}}
                                    @php
                                        $ext = strtolower(pathinfo($uploaded->nama_file, PATHINFO_EXTENSION));
                                    @endphp
                                    @if($ext === 'pdf')
                                        <i class="ri-file-pdf-2-line text-3xl text-red-400"></i>
                                    @else
                                        <i class="ri-image-line text-3xl text-blue-400"></i>
                                    @endif
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate max-w-xs">{{ $uploaded->nama_file }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $uploaded->created_at->format('d M Y, H:i') }}</p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-2">
                                    {{-- Tombol Lihat --}}
                                    <a href="{{ Storage::url($uploaded->path) }}"
                                       target="_blank"
                                       class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md text-xs font-semibold bg-indigo-100 text-indigo-700 hover:bg-indigo-200 dark:bg-indigo-900/50 dark:text-indigo-300 dark:hover:bg-indigo-800 transition">
                                        <i class="ri-eye-line text-sm"></i> Lihat
                                    </a>

                                    {{-- Tombol Hapus --}}
                                    @if($uploaded->status != 'diterima')
                                        <form action="{{ route('siswa.berkas-awal.destroy', $uploaded->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus berkas ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md text-xs font-semibold bg-red-100 text-red-700 hover:bg-red-200 dark:bg-red-900/50 dark:text-red-300 dark:hover:bg-red-800 transition">
                                                <i class="ri-delete-bin-line text-sm"></i> Hapus
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>

                            @if($uploaded->keterangan)
                                <div class="p-2 bg-yellow-50 dark:bg-yellow-900/20 rounded flex items-start gap-2">
                                    <i class="ri-chat-quote-line text-yellow-500 text-sm mt-0.5"></i>
                                    <p class="text-sm text-yellow-800 dark:text-yellow-200">
                                        <strong>Keterangan:</strong> {{ $uploaded->keterangan }}
                                    </p>
                                </div>
                            @endif
                        @endif

                        {{-- Form Upload --}}
                        @if(!$uploaded || $uploaded->status != 'diterima')
                            <form class="upload-form mt-3"
                                  action="{{ route('siswa.berkas-awal.store') }}"
                                  method="POST"
                                  enctype="multipart/form-data"
                                  data-key="{{ $key }}">
                                @csrf
                                <input type="hidden" name="jenis_berkas" value="{{ $key }}">

                                <div class="flex flex-col gap-3">
                                    {{-- File input --}}
                                    <div class="flex gap-3 items-center">
                                        <div class="flex-1">
                                            <input type="file"
                                                   name="file"
                                                   accept=".jpg,.jpeg,.png,.pdf"
                                                   required
                                                   class="w-full text-sm text-gray-500
                                                          file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0
                                                          file:text-sm file:font-semibold
                                                          file:bg-indigo-50 file:text-indigo-600
                                                          hover:file:bg-indigo-100
                                                          dark:file:bg-indigo-900 dark:file:text-indigo-300">
                                        </div>
                                        <button type="submit"
                                                class="upload-btn"
                                                style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:6px;font-size:14px;font-weight:600;background:#4f46e5;color:#fff;border:none;cursor:pointer;transition:background .2s;"
                                                onmouseover="if(!this.disabled)this.style.background='#4338ca'"
                                                onmouseout="if(!this.disabled)this.style.background='#4f46e5'">
                                            <i class="ri-upload-cloud-line"></i>
                                            {{ $uploaded ? 'Ganti' : 'Upload' }}
                                        </button>
                                    </div>

                                    {{-- Progress Bar (hidden by default) --}}
                                    <div class="progress-wrapper hidden">
                                        <div class="flex items-center justify-between mb-1">
                                            <span class="text-xs text-gray-500 dark:text-gray-400">Mengupload...</span>
                                            <span class="progress-text text-xs font-semibold text-indigo-600 dark:text-indigo-400">0%</span>
                                        </div>
                                        <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-2.5 overflow-hidden">
                                            <div class="progress-bar h-2.5 rounded-full bg-indigo-600 transition-all duration-300 ease-out" style="width:0%"></div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        @endif
                    </div>
                @endforeach
            </div><!-- /space-y-4 -->
        </div>
    </div>

    {{-- Upload via AJAX with simulated + real progress --}}
    <style>
        @keyframes uploading-spin { to { transform: rotate(360deg); } }
        .upload-spin { display:inline-block; animation: uploading-spin 0.8s linear infinite; }
    </style>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.upload-form').forEach(function (form) {
            form.addEventListener('submit', function (e) {
                e.preventDefault();

                const fileInput = form.querySelector('input[type="file"]');
                if (!fileInput || !fileInput.files.length) {
                    alert('Pilih file terlebih dahulu.');
                    return;
                }

                const progressWrapper = form.querySelector('.progress-wrapper');
                const progressBar     = form.querySelector('.progress-bar');
                const progressText    = form.querySelector('.progress-text');
                const uploadBtn       = form.querySelector('.upload-btn');
                const originalBtnHtml = uploadBtn.innerHTML;

                // ── Tampilkan progress bar SEGERA ────────────────────
                progressWrapper.classList.remove('hidden');
                uploadBtn.disabled = true;
                uploadBtn.innerHTML = '<i class="ri-loader-4-line upload-spin"></i> Mengupload...';

                let currentPct = 0;
                let realPct    = 0;
                let done       = false;

                // Smooth setter
                function setProgress(pct) {
                    pct = Math.min(100, Math.max(0, pct));
                    progressBar.style.width  = pct.toFixed(1) + '%';
                    progressText.textContent = Math.round(pct) + '%';
                    currentPct = pct;
                }

                // Force tampil 5% langsung agar bar langsung muncul
                setTimeout(function () { if (!done) setProgress(5); }, 30);

                // ── Simulasi animasi easing 0→88% (penting di localhost) ──
                const simInterval = setInterval(function () {
                    if (done) { clearInterval(simInterval); return; }
                    const cap = Math.max(realPct, 88);
                    if (currentPct < cap) {
                        // Semakin lambat mendekati batas
                        const step = (cap - currentPct) * 0.06 + 0.3;
                        setProgress(currentPct + step);
                    }
                }, 60);

                // ── XHR ─────────────────────────────────────────────
                const formData = new FormData(form);
                const xhr      = new XMLHttpRequest();

                // Progress asli dari browser (aktif bila file besar / jaringan lambat)
                xhr.upload.addEventListener('progress', function (evt) {
                    if (evt.lengthComputable) {
                        realPct = (evt.loaded / evt.total) * 100;
                        if (realPct > currentPct) setProgress(realPct);
                    }
                });

                // Selesai → cek status
                xhr.addEventListener('load', function () {
                    done = true;
                    clearInterval(simInterval);

                    if (xhr.status === 200 || xhr.status === 302 || (xhr.status >= 200 && xhr.status < 400)) {
                        // Sukses → animasi 100% hijau → redirect
                        progressBar.style.transition = 'width 0.3s ease';
                        progressBar.style.background = '#22c55e';
                        setProgress(100);
                        progressText.textContent = '100% ✓';
                        setTimeout(function () {
                            window.location.href = xhr.responseURL || window.location.href;
                        }, 700);
                    } else if (xhr.status === 422) {
                        // Validasi gagal
                        progressWrapper.classList.add('hidden');
                        uploadBtn.disabled = false;
                        uploadBtn.style.background = '#4f46e5';
                        uploadBtn.innerHTML = originalBtnHtml;
                        try {
                            const errData = JSON.parse(xhr.responseText);
                            const messages = errData.errors
                                ? Object.values(errData.errors).flat().join('\n')
                                : (errData.message || 'Validasi gagal.');
                            alert('Gagal upload:\n' + messages);
                        } catch(e) {
                            alert('Gagal upload: validasi tidak lolos. Pastikan format file JPG/PNG/PDF dan ukuran max 5MB.');
                        }
                    } else {
                        // Error lainnya
                        progressWrapper.classList.add('hidden');
                        uploadBtn.disabled = false;
                        uploadBtn.style.background = '#4f46e5';
                        uploadBtn.innerHTML = originalBtnHtml;
                        alert('Gagal mengupload berkas (HTTP ' + xhr.status + '). Silakan coba lagi.');
                    }
                });

                // Network Error
                xhr.addEventListener('error', function () {
                    done = true;
                    clearInterval(simInterval);
                    progressWrapper.classList.add('hidden');
                    uploadBtn.disabled = false;
                    uploadBtn.style.background = '#4f46e5';
                    uploadBtn.innerHTML = originalBtnHtml;
                    alert('Koneksi gagal. Silakan coba lagi.');
                });

                xhr.open('POST', form.action, true);
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                // Kirim CSRF token via header
                const csrfMeta = document.querySelector('meta[name="csrf-token"]');
                if (csrfMeta) {
                    xhr.setRequestHeader('X-CSRF-TOKEN', csrfMeta.getAttribute('content'));
                }
                xhr.send(formData);
            });
        });
    });
    </script>
</x-app-layout>
