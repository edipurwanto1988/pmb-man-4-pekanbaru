<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Input Penilaian Tes</h2>
    </x-slot>

    <div class="py-8">
        <div class="w-full px-4 sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-50 dark:bg-green-900/50 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 rounded-lg flex items-center gap-2">
                    <i class="ri-checkbox-circle-line text-lg"></i> {{ session('success') }}
                </div>
            @endif

            <!-- Search -->
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg mb-4">
                <div class="p-4">
                    <form method="GET" class="flex gap-3">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari nama atau NISN..."
                            class="flex-1 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <x-primary-button>Cari</x-primary-button>
                        @if(request('search'))
                            <a href="{{ route('admin.penilaian.index') }}" class="inline-flex items-center px-3 py-2 bg-gray-200 dark:bg-gray-600 rounded-md text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-300">Reset</a>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Tabel Inline -->
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase w-8">No</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase">Nama / NISN</th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase" colspan="3">📝 Tes Akademik</th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase" colspan="3">🕌 Tes Ibadah</th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase">Status</th>
                            </tr>
                            <tr class="bg-gray-100 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
                                <th class="px-4 py-2"></th>
                                <th class="px-4 py-2"></th>
                                {{-- Akademik sub-headers --}}
                                <th class="px-2 py-2 text-center text-xs text-gray-400 dark:text-gray-400 font-medium">Nilai</th>
                                <th class="px-2 py-2 text-center text-xs text-gray-400 dark:text-gray-400 font-medium">Tanggal</th>
                                <th class="px-2 py-2 text-center text-xs text-gray-400 dark:text-gray-400 font-medium">Keputusan</th>
                                {{-- Ibadah sub-headers --}}
                                <th class="px-2 py-2 text-center text-xs text-gray-400 dark:text-gray-400 font-medium">Nilai</th>
                                <th class="px-2 py-2 text-center text-xs text-gray-400 dark:text-gray-400 font-medium">Tanggal</th>
                                <th class="px-2 py-2 text-center text-xs text-gray-400 dark:text-gray-400 font-medium">Keputusan</th>
                                <th class="px-4 py-2"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($peserta as $i => $p)
                            @php
                                $akademik = $p->hasilTes->where('jenis_tes', 'akademik')->first();
                                $ibadah   = $p->hasilTes->where('jenis_tes', 'ibadah')->first();
                                $statusColor = match($p->status) {
                                    'lulus_administrasi' => ['bg:#dbeafe','color:#1e40af'],
                                    'lulus_tes'          => ['bg:#dcfce7','color:#15803d'],
                                    'tidak_lulus_tes'    => ['bg:#fee2e2','color:#dc2626'],
                                    default              => ['bg:#f3f4f6','color:#374151'],
                                };
                            @endphp
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-750 align-middle" id="row-{{ $p->id }}">

                                {{-- No --}}
                                <td class="px-4 py-3 text-gray-400 text-xs">{{ $peserta->firstItem() + $i }}</td>

                                {{-- Nama --}}
                                <td class="px-4 py-3">
                                    <p class="font-semibold text-gray-900 dark:text-gray-100 text-sm">{{ $p->nama_lengkap }}</p>
                                    <p class="text-xs text-gray-400">{{ $p->nisn }}</p>
                                </td>

                                {{-- ======= AKADEMIK ======= --}}

                                {{-- Nilai Akademik --}}
                                <td class="px-2 py-2 text-center">
                                    <form action="{{ route('admin.penilaian.store', $p->id) }}" method="POST" class="inline-form" id="form-ak-{{ $p->id }}">
                                        @csrf
                                        <input type="hidden" name="jenis_tes" value="akademik">
                                        <input type="hidden" name="tanggal_tes" id="tgl-ak-{{ $p->id }}" value="{{ $akademik?->tanggal_tes?->format('Y-m-d') ?? '' }}">
                                        <input type="hidden" name="status" id="status-ak-{{ $p->id }}" value="{{ $akademik?->status ?? 'belum_dinilai' }}">
                                        <input type="hidden" name="catatan" value="{{ $akademik?->catatan ?? '' }}">
                                        <input type="number"
                                            name="nilai"
                                            value="{{ $akademik?->nilai ?? '' }}"
                                            min="0" max="100" step="0.01"
                                            placeholder="—"
                                            onchange="markDirty('ak','{{ $p->id }}')"
                                            class="w-16 text-center rounded border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm py-1 px-1 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-400">
                                    </form>
                                </td>

                                {{-- Tanggal Akademik --}}
                                <td class="px-2 py-2 text-center">
                                    <input type="date"
                                        value="{{ $akademik?->tanggal_tes?->format('Y-m-d') ?? '' }}"
                                        onchange="setHidden('tgl-ak-{{ $p->id }}', this.value); markDirty('ak','{{ $p->id }}')"
                                        class="rounded border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-xs py-1 px-1 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-400"
                                        style="width:130px;">
                                </td>

                                {{-- Keputusan Akademik --}}
                                <td class="px-2 py-2 text-center">
                                    <div style="display:inline-flex; gap:4px;">
                                        <button type="button"
                                            id="ak-pending-{{ $p->id }}"
                                            onclick="setKeputusan('ak','{{ $p->id }}','belum_dinilai')"
                                            title="Pending"
                                            style="padding:4px 8px; border-radius:6px; border:2px solid; font-size:11px; font-weight:600; cursor:pointer; transition:0.15s;
                                                {{ ($akademik?->status ?? 'belum_dinilai') === 'belum_dinilai' ? 'border-color:#9ca3af;background:#f3f4f6;color:#374151;' : 'border-color:#e5e7eb;background:#fff;color:#d1d5db;' }}">
                                            ⏳
                                        </button>
                                        <button type="button"
                                            id="ak-lulus-{{ $p->id }}"
                                            onclick="setKeputusan('ak','{{ $p->id }}','lulus')"
                                            title="Lulus"
                                            style="padding:4px 8px; border-radius:6px; border:2px solid; font-size:11px; font-weight:700; cursor:pointer; transition:0.15s;
                                                {{ ($akademik?->status ?? '') === 'lulus' ? 'border-color:#16a34a;background:#f0fdf4;color:#15803d;' : 'border-color:#e5e7eb;background:#fff;color:#d1d5db;' }}">
                                            ✓ Lulus
                                        </button>
                                        <button type="button"
                                            id="ak-gagal-{{ $p->id }}"
                                            onclick="setKeputusan('ak','{{ $p->id }}','tidak_lulus')"
                                            title="Tidak Lulus"
                                            style="padding:4px 8px; border-radius:6px; border:2px solid; font-size:11px; font-weight:700; cursor:pointer; transition:0.15s;
                                                {{ ($akademik?->status ?? '') === 'tidak_lulus' ? 'border-color:#dc2626;background:#fef2f2;color:#dc2626;' : 'border-color:#e5e7eb;background:#fff;color:#d1d5db;' }}">
                                            ✗ Gagal
                                        </button>
                                    </div>
                                </td>

                                {{-- ======= IBADAH ======= --}}

                                {{-- Nilai Ibadah --}}
                                <td class="px-2 py-2 text-center">
                                    <form action="{{ route('admin.penilaian.store', $p->id) }}" method="POST" class="inline-form" id="form-ib-{{ $p->id }}">
                                        @csrf
                                        <input type="hidden" name="jenis_tes" value="ibadah">
                                        <input type="hidden" name="tanggal_tes" id="tgl-ib-{{ $p->id }}" value="{{ $ibadah?->tanggal_tes?->format('Y-m-d') ?? '' }}">
                                        <input type="hidden" name="status" id="status-ib-{{ $p->id }}" value="{{ $ibadah?->status ?? 'belum_dinilai' }}">
                                        <input type="hidden" name="catatan" value="{{ $ibadah?->catatan ?? '' }}">
                                        <input type="number"
                                            name="nilai"
                                            value="{{ $ibadah?->nilai ?? '' }}"
                                            min="0" max="100" step="0.01"
                                            placeholder="—"
                                            onchange="markDirty('ib','{{ $p->id }}')"
                                            class="w-16 text-center rounded border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm py-1 px-1 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-400">
                                    </form>
                                </td>

                                {{-- Tanggal Ibadah --}}
                                <td class="px-2 py-2 text-center">
                                    <input type="date"
                                        value="{{ $ibadah?->tanggal_tes?->format('Y-m-d') ?? '' }}"
                                        onchange="setHidden('tgl-ib-{{ $p->id }}', this.value); markDirty('ib','{{ $p->id }}')"
                                        class="rounded border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-xs py-1 px-1 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-400"
                                        style="width:130px;">
                                </td>

                                {{-- Keputusan Ibadah --}}
                                <td class="px-2 py-2 text-center">
                                    <div style="display:inline-flex; gap:4px;">
                                        <button type="button"
                                            id="ib-pending-{{ $p->id }}"
                                            onclick="setKeputusan('ib','{{ $p->id }}','belum_dinilai')"
                                            title="Pending"
                                            style="padding:4px 8px; border-radius:6px; border:2px solid; font-size:11px; font-weight:600; cursor:pointer; transition:0.15s;
                                                {{ ($ibadah?->status ?? 'belum_dinilai') === 'belum_dinilai' ? 'border-color:#9ca3af;background:#f3f4f6;color:#374151;' : 'border-color:#e5e7eb;background:#fff;color:#d1d5db;' }}">
                                            ⏳
                                        </button>
                                        <button type="button"
                                            id="ib-lulus-{{ $p->id }}"
                                            onclick="setKeputusan('ib','{{ $p->id }}','lulus')"
                                            title="Lulus"
                                            style="padding:4px 8px; border-radius:6px; border:2px solid; font-size:11px; font-weight:700; cursor:pointer; transition:0.15s;
                                                {{ ($ibadah?->status ?? '') === 'lulus' ? 'border-color:#16a34a;background:#f0fdf4;color:#15803d;' : 'border-color:#e5e7eb;background:#fff;color:#d1d5db;' }}">
                                            ✓ Lulus
                                        </button>
                                        <button type="button"
                                            id="ib-gagal-{{ $p->id }}"
                                            onclick="setKeputusan('ib','{{ $p->id }}','tidak_lulus')"
                                            title="Tidak Lulus"
                                            style="padding:4px 8px; border-radius:6px; border:2px solid; font-size:11px; font-weight:700; cursor:pointer; transition:0.15s;
                                                {{ ($ibadah?->status ?? '') === 'tidak_lulus' ? 'border-color:#dc2626;background:#fef2f2;color:#dc2626;' : 'border-color:#e5e7eb;background:#fff;color:#d1d5db;' }}">
                                            ✗ Gagal
                                        </button>
                                    </div>
                                </td>

                                {{-- Status Calon Siswa --}}
                                <td class="px-4 py-3 text-center">
                                    @php
                                        $sc = match($p->status) {
                                            'lulus_administrasi' => 'background:#dbeafe;color:#1e40af',
                                            'lulus_tes'          => 'background:#dcfce7;color:#15803d',
                                            'tidak_lulus_tes'    => 'background:#fee2e2;color:#dc2626',
                                            default              => 'background:#f3f4f6;color:#374151',
                                        };
                                    @endphp
                                    <span style="padding:3px 10px; border-radius:20px; font-size:11px; font-weight:700; white-space:nowrap; {{ $sc }}">
                                        {{ ucfirst(str_replace('_', ' ', $p->status)) }}
                                    </span>

                                    {{-- Tombol Simpan: muncul saat ada perubahan --}}
                                    <div id="save-btns-{{ $p->id }}" style="display:none; margin-top:6px; display:flex; flex-direction:column; gap:4px; align-items:center;">
                                        <button type="button"
                                            onclick="submitForm('ak','{{ $p->id }}')"
                                            style="width:100%; padding:4px 8px; background:#4f46e5; color:#fff; border:none; border-radius:6px; font-size:11px; font-weight:600; cursor:pointer;">
                                            💾 Simpan Akademik
                                        </button>
                                        <button type="button"
                                            onclick="submitForm('ib','{{ $p->id }}')"
                                            style="width:100%; padding:4px 8px; background:#4f46e5; color:#fff; border:none; border-radius:6px; font-size:11px; font-weight:600; cursor:pointer;">
                                            💾 Simpan Ibadah
                                        </button>
                                    </div>
                                </td>

                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="px-6 py-10 text-center text-gray-400">
                                    <div class="text-4xl mb-2">📋</div>
                                    <p>Tidak ada peserta tes.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                    {{ $peserta->withQueryString()->links() }}
                </div>
            </div>

            <p class="mt-3 text-xs text-gray-400 text-center">
                💡 Edit nilai, tanggal, atau klik tombol keputusan — tombol <strong>Simpan</strong> akan muncul otomatis.
            </p>
        </div>
    </div>

    <script>
        // Update hidden input
        function setHidden(id, val) {
            document.getElementById(id).value = val;
        }

        // Tandai baris sudah diubah → tampilkan tombol simpan
        function markDirty(jenis, siswaId) {
            const saveBtns = document.getElementById('save-btns-' + siswaId);
            if (saveBtns) {
                saveBtns.style.display = 'flex';
            }
        }

        // Set keputusan lulus / tidak_lulus / belum_dinilai
        function setKeputusan(jenis, siswaId, val) {
            // Update hidden field
            document.getElementById('status-' + jenis + '-' + siswaId).value = val;

            // Reset semua tombol grup ini
            const keys = ['pending', 'lulus', 'gagal'];
            keys.forEach(function(k) {
                const btn = document.getElementById(jenis + '-' + k + '-' + siswaId);
                if (!btn) return;
                btn.style.borderColor = '#e5e7eb';
                btn.style.background  = '#fff';
                btn.style.color       = '#d1d5db';
            });

            // Aktifkan tombol yg dipilih
            if (val === 'belum_dinilai') {
                const btn = document.getElementById(jenis + '-pending-' + siswaId);
                btn.style.borderColor = '#9ca3af';
                btn.style.background  = '#f3f4f6';
                btn.style.color       = '#374151';
            } else if (val === 'lulus') {
                const btn = document.getElementById(jenis + '-lulus-' + siswaId);
                btn.style.borderColor = '#16a34a';
                btn.style.background  = '#f0fdf4';
                btn.style.color       = '#15803d';
            } else if (val === 'tidak_lulus') {
                const btn = document.getElementById(jenis + '-gagal-' + siswaId);
                btn.style.borderColor = '#dc2626';
                btn.style.background  = '#fef2f2';
                btn.style.color       = '#dc2626';
            }

            // Tampilkan tombol simpan
            markDirty(jenis, siswaId);
        }

        // Submit form (akademik atau ibadah)
        function submitForm(jenis, siswaId) {
            const form = document.getElementById('form-' + jenis + '-' + siswaId);
            if (form) form.submit();
        }
    </script>
</x-app-layout>
