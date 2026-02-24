<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Input Nilai: {{ $pendaftar->nama_lengkap }}</h2>
            <a href="{{ route('admin.penilaian.index') }}" class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline">← Kembali</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-50 dark:bg-green-900/50 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 rounded-lg">{{ session('success') }}</div>
            @endif

            <!-- Info Siswa -->
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg mb-6 p-6">
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Nama</p>
                        <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $pendaftar->nama_lengkap }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">NISN</p>
                        <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $pendaftar->nisn ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Status Saat Ini</p>
                        @php
                            $statusColor = match($pendaftar->status) {
                                'lulus_administrasi'  => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                                'lulus_tes'           => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                'tidak_lulus_tes'     => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                                default               => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200',
                            };
                        @endphp
                        <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $statusColor }}">
                            {{ ucfirst(str_replace('_', ' ', $pendaftar->status)) }}
                        </span>
                    </div>
                </div>

                {{-- Ringkasan --}}
                @if($akademik || $ibadah)
                <div class="mt-5 pt-5 border-t border-gray-200 dark:border-gray-700">
                    <p class="text-sm font-semibold text-gray-600 dark:text-gray-400 mb-3">Ringkasan Nilai</p>
                    <div class="grid grid-cols-2 gap-4">
                        @php
                            $akColor = $akademik ? ($akademik->status === 'lulus' ? 'bg-green-50 dark:bg-green-900/30 border-green-200' : ($akademik->status === 'tidak_lulus' ? 'bg-red-50 dark:bg-red-900/30 border-red-200' : 'bg-gray-50 dark:bg-gray-700 border-gray-200')) : 'bg-gray-50 dark:bg-gray-700 border-gray-200';
                            $ibColor = $ibadah ? ($ibadah->status === 'lulus' ? 'bg-green-50 dark:bg-green-900/30 border-green-200' : ($ibadah->status === 'tidak_lulus' ? 'bg-red-50 dark:bg-red-900/30 border-red-200' : 'bg-gray-50 dark:bg-gray-700 border-gray-200')) : 'bg-gray-50 dark:bg-gray-700 border-gray-200';
                        @endphp
                        <div class="flex items-center gap-3 p-3 rounded-lg border {{ $akColor }}">
                            <span class="text-2xl">📝</span>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Akademik</p>
                                @if($akademik)
                                    <p class="text-xl font-bold {{ $akademik->status === 'lulus' ? 'text-green-600' : ($akademik->status === 'tidak_lulus' ? 'text-red-600' : 'text-gray-500') }}">
                                        {{ $akademik->nilai ?? '-' }}
                                    </p>
                                    <span class="text-xs font-semibold {{ $akademik->status === 'lulus' ? 'text-green-600' : ($akademik->status === 'tidak_lulus' ? 'text-red-600' : 'text-gray-500') }}">
                                        {{ $akademik->status === 'lulus' ? '✓ Lulus' : ($akademik->status === 'tidak_lulus' ? '✗ Tidak Lulus' : '⏳ Belum Dinilai') }}
                                    </span>
                                @else
                                    <p class="text-sm text-gray-400">Belum ada nilai</p>
                                @endif
                            </div>
                        </div>
                        <div class="flex items-center gap-3 p-3 rounded-lg border {{ $ibColor }}">
                            <span class="text-2xl">🕌</span>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Ibadah</p>
                                @if($ibadah)
                                    <p class="text-xl font-bold {{ $ibadah->status === 'lulus' ? 'text-green-600' : ($ibadah->status === 'tidak_lulus' ? 'text-red-600' : 'text-gray-500') }}">
                                        {{ $ibadah->nilai ?? '-' }}
                                    </p>
                                    <span class="text-xs font-semibold {{ $ibadah->status === 'lulus' ? 'text-green-600' : ($ibadah->status === 'tidak_lulus' ? 'text-red-600' : 'text-gray-500') }}">
                                        {{ $ibadah->status === 'lulus' ? '✓ Lulus' : ($ibadah->status === 'tidak_lulus' ? '✗ Tidak Lulus' : '⏳ Belum Dinilai') }}
                                    </span>
                                @else
                                    <p class="text-sm text-gray-400">Belum ada nilai</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Tes Akademik -->
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">📝 Tes Akademik</h3>
                    <form action="{{ route('admin.penilaian.store', $pendaftar->id) }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="jenis_tes" value="akademik">
                        <input type="hidden" name="status" id="status_akademik" value="{{ $akademik?->status ?? 'belum_dinilai' }}">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nilai (0-100)</label>
                            <input type="number" name="nilai" value="{{ $akademik?->nilai ?? '' }}" min="0" max="100" step="0.01"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="Masukkan nilai...">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Tes</label>
                            <input type="date" name="tanggal_tes" value="{{ $akademik?->tanggal_tes?->format('Y-m-d') ?? '' }}"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Catatan</label>
                            <textarea name="catatan" rows="2"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="Catatan tambahan...">{{ $akademik?->catatan ?? '' }}</textarea>
                        </div>

                        <!-- Keputusan Lulus / Tidak Lulus -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Keputusan</label>
                            <div style="display:flex; gap:8px;">
                                <button type="button"
                                    onclick="setStatus('akademik','belum_dinilai', this)"
                                    id="ak_pending"
                                    style="flex:1; padding:10px 6px; border-radius:8px; border:2px solid; font-size:12px; font-weight:600; cursor:pointer; transition:all 0.15s;
                                        {{ ($akademik?->status ?? 'belum_dinilai') === 'belum_dinilai' ? 'border-color:#9ca3af; background:#f3f4f6; color:#374151;' : 'border-color:#e5e7eb; background:#fff; color:#6b7280;' }}">
                                    ⏳ Pending
                                </button>
                                <button type="button"
                                    onclick="setStatus('akademik','lulus', this)"
                                    id="ak_lulus"
                                    style="flex:1; padding:10px 6px; border-radius:8px; border:2px solid; font-size:12px; font-weight:700; cursor:pointer; transition:all 0.15s;
                                        {{ ($akademik?->status ?? '') === 'lulus' ? 'border-color:#16a34a; background:#f0fdf4; color:#15803d;' : 'border-color:#e5e7eb; background:#fff; color:#6b7280;' }}">
                                    ✓ Lulus
                                </button>
                                <button type="button"
                                    onclick="setStatus('akademik','tidak_lulus', this)"
                                    id="ak_tidak_lulus"
                                    style="flex:1; padding:10px 6px; border-radius:8px; border:2px solid; font-size:12px; font-weight:700; cursor:pointer; transition:all 0.15s;
                                        {{ ($akademik?->status ?? '') === 'tidak_lulus' ? 'border-color:#dc2626; background:#fef2f2; color:#dc2626;' : 'border-color:#e5e7eb; background:#fff; color:#6b7280;' }}">
                                    ✗ Tidak Lulus
                                </button>
                            </div>
                        </div>

                        <button type="submit"
                            style="width:100%; padding:10px; background:#4f46e5; color:#fff; border:none; border-radius:8px; font-weight:600; font-size:14px; cursor:pointer;"
                            onmouseover="this.style.background='#4338ca'" onmouseout="this.style.background='#4f46e5'">
                            💾 Simpan Nilai Akademik
                        </button>
                    </form>
                </div>

                <!-- Tes Ibadah -->
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">🕌 Tes Ibadah</h3>
                    <form action="{{ route('admin.penilaian.store', $pendaftar->id) }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="jenis_tes" value="ibadah">
                        <input type="hidden" name="status" id="status_ibadah" value="{{ $ibadah?->status ?? 'belum_dinilai' }}">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nilai (0-100)</label>
                            <input type="number" name="nilai" value="{{ $ibadah?->nilai ?? '' }}" min="0" max="100" step="0.01"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="Masukkan nilai...">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Tes</label>
                            <input type="date" name="tanggal_tes" value="{{ $ibadah?->tanggal_tes?->format('Y-m-d') ?? '' }}"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Catatan</label>
                            <textarea name="catatan" rows="2"
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="Catatan tambahan...">{{ $ibadah?->catatan ?? '' }}</textarea>
                        </div>

                        <!-- Keputusan Lulus / Tidak Lulus -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Keputusan</label>
                            <div style="display:flex; gap:8px;">
                                <button type="button"
                                    onclick="setStatus('ibadah','belum_dinilai', this)"
                                    id="ib_pending"
                                    style="flex:1; padding:10px 6px; border-radius:8px; border:2px solid; font-size:12px; font-weight:600; cursor:pointer; transition:all 0.15s;
                                        {{ ($ibadah?->status ?? 'belum_dinilai') === 'belum_dinilai' ? 'border-color:#9ca3af; background:#f3f4f6; color:#374151;' : 'border-color:#e5e7eb; background:#fff; color:#6b7280;' }}">
                                    ⏳ Pending
                                </button>
                                <button type="button"
                                    onclick="setStatus('ibadah','lulus', this)"
                                    id="ib_lulus"
                                    style="flex:1; padding:10px 6px; border-radius:8px; border:2px solid; font-size:12px; font-weight:700; cursor:pointer; transition:all 0.15s;
                                        {{ ($ibadah?->status ?? '') === 'lulus' ? 'border-color:#16a34a; background:#f0fdf4; color:#15803d;' : 'border-color:#e5e7eb; background:#fff; color:#6b7280;' }}">
                                    ✓ Lulus
                                </button>
                                <button type="button"
                                    onclick="setStatus('ibadah','tidak_lulus', this)"
                                    id="ib_tidak_lulus"
                                    style="flex:1; padding:10px 6px; border-radius:8px; border:2px solid; font-size:12px; font-weight:700; cursor:pointer; transition:all 0.15s;
                                        {{ ($ibadah?->status ?? '') === 'tidak_lulus' ? 'border-color:#dc2626; background:#fef2f2; color:#dc2626;' : 'border-color:#e5e7eb; background:#fff; color:#6b7280;' }}">
                                    ✗ Tidak Lulus
                                </button>
                            </div>
                        </div>

                        <button type="submit"
                            style="width:100%; padding:10px; background:#4f46e5; color:#fff; border:none; border-radius:8px; font-weight:600; font-size:14px; cursor:pointer;"
                            onmouseover="this.style.background='#4338ca'" onmouseout="this.style.background='#4f46e5'">
                            💾 Simpan Nilai Ibadah
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function setStatus(jenis, nilai, btn) {
            // Update hidden input
            document.getElementById('status_' + jenis).value = nilai;

            // Reset all buttons in this group
            const prefix = jenis === 'akademik' ? 'ak' : 'ib';
            const btns = {
                pending: document.getElementById(prefix + '_pending'),
                lulus:   document.getElementById(prefix + '_lulus'),
                tidak:   document.getElementById(prefix + '_tidak_lulus'),
            };

            // Reset styles
            btns.pending.style.borderColor = '#e5e7eb';
            btns.pending.style.background  = '#fff';
            btns.pending.style.color       = '#6b7280';

            btns.lulus.style.borderColor   = '#e5e7eb';
            btns.lulus.style.background    = '#fff';
            btns.lulus.style.color         = '#6b7280';

            btns.tidak.style.borderColor   = '#e5e7eb';
            btns.tidak.style.background    = '#fff';
            btns.tidak.style.color         = '#6b7280';

            // Apply active style
            if (nilai === 'belum_dinilai') {
                btns.pending.style.borderColor = '#9ca3af';
                btns.pending.style.background  = '#f3f4f6';
                btns.pending.style.color       = '#374151';
            } else if (nilai === 'lulus') {
                btns.lulus.style.borderColor   = '#16a34a';
                btns.lulus.style.background    = '#f0fdf4';
                btns.lulus.style.color         = '#15803d';
            } else if (nilai === 'tidak_lulus') {
                btns.tidak.style.borderColor   = '#dc2626';
                btns.tidak.style.background    = '#fef2f2';
                btns.tidak.style.color         = '#dc2626';
            }
        }
    </script>
</x-app-layout>
