<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Input Penilaian Tes</h2>
    </x-slot>

    {{-- Toast Notification --}}
    <div id="toast" style="
        position:fixed; top:20px; right:20px; z-index:9999;
        display:none; align-items:center; gap:10px;
        padding:12px 20px; border-radius:10px;
        font-size:14px; font-weight:600;
        box-shadow:0 4px 20px rgba(0,0,0,0.15);
        transition:all 0.3s ease;
        max-width:360px;
    " id="toast">
        <span id="toast-icon" style="font-size:18px;"></span>
        <span id="toast-msg"></span>
    </div>

    <div class="py-8">
        <div class="w-full px-4 sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-50 dark:bg-green-900/50 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 rounded-lg">
                    {{ session('success') }}
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
                                <th class="px-2 py-2 text-center text-xs text-gray-400 font-medium">Nilai</th>
                                <th class="px-2 py-2 text-center text-xs text-gray-400 font-medium">Tanggal</th>
                                <th class="px-2 py-2 text-center text-xs text-gray-400 font-medium">Keputusan</th>
                                <th class="px-2 py-2 text-center text-xs text-gray-400 font-medium">Nilai</th>
                                <th class="px-2 py-2 text-center text-xs text-gray-400 font-medium">Tanggal</th>
                                <th class="px-2 py-2 text-center text-xs text-gray-400 font-medium">Keputusan</th>
                                <th class="px-4 py-2"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($peserta as $i => $p)
                            @php
                                $akademik = $p->hasilTes->where('jenis_tes', 'akademik')->first();
                                $ibadah   = $p->hasilTes->where('jenis_tes', 'ibadah')->first();
                                $sc = match($p->status) {
                                    'lulus_administrasi' => 'background:#dbeafe;color:#1e40af',
                                    'lulus_tes'          => 'background:#dcfce7;color:#15803d',
                                    'tidak_lulus_tes'    => 'background:#fee2e2;color:#dc2626',
                                    default              => 'background:#f3f4f6;color:#374151',
                                };
                                $stLabel = ucfirst(str_replace('_', ' ', $p->status));
                            @endphp
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-750 align-middle" id="row-{{ $p->id }}">

                                <td class="px-4 py-3 text-gray-400 text-xs">{{ $peserta->firstItem() + $i }}</td>

                                <td class="px-4 py-3">
                                    <p class="font-semibold text-gray-900 dark:text-gray-100 text-sm">{{ $p->nama_lengkap }}</p>
                                    <p class="text-xs text-gray-400">{{ $p->nisn }}</p>
                                </td>

                                {{-- ======= AKADEMIK ======= --}}
                                {{-- Nilai Akademik --}}
                                <td class="px-2 py-2 text-center">
                                    <input type="number"
                                        id="nilai-ak-{{ $p->id }}"
                                        value="{{ $akademik?->nilai ?? '' }}"
                                        min="0" max="100" step="0.01"
                                        placeholder="—"
                                        onchange="autoSave('{{ $p->id }}','akademik')"
                                        class="w-16 text-center rounded border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm py-1 px-1 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-400">
                                </td>

                                {{-- Tanggal Akademik --}}
                                <td class="px-2 py-2 text-center">
                                    <input type="date"
                                        id="tgl-ak-{{ $p->id }}"
                                        value="{{ $akademik?->tanggal_tes?->format('Y-m-d') ?? '' }}"
                                        onchange="autoSave('{{ $p->id }}','akademik')"
                                        class="rounded border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-xs py-1 px-1 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-400"
                                        style="width:130px;">
                                </td>

                                {{-- Keputusan Akademik --}}
                                <td class="px-2 py-2 text-center">
                                    <input type="hidden" id="status-ak-{{ $p->id }}" value="{{ $akademik?->status ?? 'belum_dinilai' }}">
                                    <div style="display:inline-flex; gap:4px;">
                                        <button type="button"
                                            id="ak-pending-{{ $p->id }}"
                                            onclick="setKeputusan('ak','{{ $p->id }}','belum_dinilai')"
                                            style="padding:5px 9px; border-radius:6px; border:2px solid; font-size:11px; font-weight:600; cursor:pointer; transition:all 0.15s;
                                                {{ ($akademik?->status ?? 'belum_dinilai') === 'belum_dinilai' ? 'border-color:#9ca3af;background:#f3f4f6;color:#374151;' : 'border-color:#e5e7eb;background:#fff;color:#d1d5db;' }}">
                                            ⏳
                                        </button>
                                        <button type="button"
                                            id="ak-lulus-{{ $p->id }}"
                                            onclick="setKeputusan('ak','{{ $p->id }}','lulus')"
                                            style="padding:5px 9px; border-radius:6px; border:2px solid; font-size:11px; font-weight:700; cursor:pointer; transition:all 0.15s;
                                                {{ ($akademik?->status ?? '') === 'lulus' ? 'border-color:#16a34a;background:#f0fdf4;color:#15803d;' : 'border-color:#e5e7eb;background:#fff;color:#d1d5db;' }}">
                                            ✓ Lulus
                                        </button>
                                        <button type="button"
                                            id="ak-gagal-{{ $p->id }}"
                                            onclick="setKeputusan('ak','{{ $p->id }}','tidak_lulus')"
                                            style="padding:5px 9px; border-radius:6px; border:2px solid; font-size:11px; font-weight:700; cursor:pointer; transition:all 0.15s;
                                                {{ ($akademik?->status ?? '') === 'tidak_lulus' ? 'border-color:#dc2626;background:#fef2f2;color:#dc2626;' : 'border-color:#e5e7eb;background:#fff;color:#d1d5db;' }}">
                                            ✗ Gagal
                                        </button>
                                    </div>
                                </td>

                                {{-- ======= IBADAH ======= --}}
                                {{-- Nilai Ibadah --}}
                                <td class="px-2 py-2 text-center">
                                    <input type="number"
                                        id="nilai-ib-{{ $p->id }}"
                                        value="{{ $ibadah?->nilai ?? '' }}"
                                        min="0" max="100" step="0.01"
                                        placeholder="—"
                                        onchange="autoSave('{{ $p->id }}','ibadah')"
                                        class="w-16 text-center rounded border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm py-1 px-1 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-400">
                                </td>

                                {{-- Tanggal Ibadah --}}
                                <td class="px-2 py-2 text-center">
                                    <input type="date"
                                        id="tgl-ib-{{ $p->id }}"
                                        value="{{ $ibadah?->tanggal_tes?->format('Y-m-d') ?? '' }}"
                                        onchange="autoSave('{{ $p->id }}','ibadah')"
                                        class="rounded border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-xs py-1 px-1 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-400"
                                        style="width:130px;">
                                </td>

                                {{-- Keputusan Ibadah --}}
                                <td class="px-2 py-2 text-center">
                                    <input type="hidden" id="status-ib-{{ $p->id }}" value="{{ $ibadah?->status ?? 'belum_dinilai' }}">
                                    <div style="display:inline-flex; gap:4px;">
                                        <button type="button"
                                            id="ib-pending-{{ $p->id }}"
                                            onclick="setKeputusan('ib','{{ $p->id }}','belum_dinilai')"
                                            style="padding:5px 9px; border-radius:6px; border:2px solid; font-size:11px; font-weight:600; cursor:pointer; transition:all 0.15s;
                                                {{ ($ibadah?->status ?? 'belum_dinilai') === 'belum_dinilai' ? 'border-color:#9ca3af;background:#f3f4f6;color:#374151;' : 'border-color:#e5e7eb;background:#fff;color:#d1d5db;' }}">
                                            ⏳
                                        </button>
                                        <button type="button"
                                            id="ib-lulus-{{ $p->id }}"
                                            onclick="setKeputusan('ib','{{ $p->id }}','lulus')"
                                            style="padding:5px 9px; border-radius:6px; border:2px solid; font-size:11px; font-weight:700; cursor:pointer; transition:all 0.15s;
                                                {{ ($ibadah?->status ?? '') === 'lulus' ? 'border-color:#16a34a;background:#f0fdf4;color:#15803d;' : 'border-color:#e5e7eb;background:#fff;color:#d1d5db;' }}">
                                            ✓ Lulus
                                        </button>
                                        <button type="button"
                                            id="ib-gagal-{{ $p->id }}"
                                            onclick="setKeputusan('ib','{{ $p->id }}','tidak_lulus')"
                                            style="padding:5px 9px; border-radius:6px; border:2px solid; font-size:11px; font-weight:700; cursor:pointer; transition:all 0.15s;
                                                {{ ($ibadah?->status ?? '') === 'tidak_lulus' ? 'border-color:#dc2626;background:#fef2f2;color:#dc2626;' : 'border-color:#e5e7eb;background:#fff;color:#d1d5db;' }}">
                                            ✗ Gagal
                                        </button>
                                    </div>
                                </td>

                                {{-- Status badge --}}
                                <td class="px-4 py-3 text-center">
                                    <span id="badge-{{ $p->id }}"
                                        style="padding:4px 12px; border-radius:20px; font-size:11px; font-weight:700; white-space:nowrap; {{ $sc }}">
                                        {{ $stLabel }}
                                    </span>
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
                💡 Klik tombol <strong>Lulus / Gagal</strong> atau ubah nilai/tanggal — data langsung tersimpan otomatis.
            </p>
        </div>
    </div>

    <script>
        const CSRF = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';

        // ─── Toast ───────────────────────────────────────────
        let toastTimer = null;
        function showToast(message, type = 'success') {
            const toast = document.getElementById('toast');
            const icon  = document.getElementById('toast-icon');
            const msg   = document.getElementById('toast-msg');

            if (type === 'success') {
                toast.style.background = '#f0fdf4';
                toast.style.color      = '#15803d';
                toast.style.border     = '1px solid #bbf7d0';
                icon.textContent       = '✅';
            } else {
                toast.style.background = '#fef2f2';
                toast.style.color      = '#dc2626';
                toast.style.border     = '1px solid #fecaca';
                icon.textContent       = '❌';
            }

            msg.textContent        = message;
            toast.style.display    = 'flex';
            toast.style.opacity    = '1';

            clearTimeout(toastTimer);
            toastTimer = setTimeout(() => {
                toast.style.opacity = '0';
                setTimeout(() => { toast.style.display = 'none'; }, 300);
            }, 3000);
        }

        // ─── Update badge status siswa ──────────────────────
        function updateBadge(siswaId, status, label) {
            const badge = document.getElementById('badge-' + siswaId);
            if (!badge) return;
            badge.textContent = label;
            const colors = {
                'lulus_administrasi': ['#dbeafe', '#1e40af'],
                'lulus_tes':          ['#dcfce7', '#15803d'],
                'tidak_lulus_tes':    ['#fee2e2', '#dc2626'],
            };
            const [bg, color] = colors[status] || ['#f3f4f6', '#374151'];
            badge.style.background = bg;
            badge.style.color      = color;
        }

        // ─── Highlight tombol keputusan ──────────────────────
        function highlightBtn(prefix, siswaId, val) {
            const map = { 'belum_dinilai': 'pending', 'lulus': 'lulus', 'tidak_lulus': 'gagal' };
            ['pending', 'lulus', 'gagal'].forEach(k => {
                const btn = document.getElementById(prefix + '-' + k + '-' + siswaId);
                if (!btn) return;
                btn.style.borderColor = '#e5e7eb';
                btn.style.background  = '#fff';
                btn.style.color       = '#d1d5db';
            });
            const activeKey = map[val] || 'pending';
            const active = document.getElementById(prefix + '-' + activeKey + '-' + siswaId);
            if (!active) return;
            if (val === 'belum_dinilai') {
                active.style.borderColor = '#9ca3af';
                active.style.background  = '#f3f4f6';
                active.style.color       = '#374151';
            } else if (val === 'lulus') {
                active.style.borderColor = '#16a34a';
                active.style.background  = '#f0fdf4';
                active.style.color       = '#15803d';
            } else if (val === 'tidak_lulus') {
                active.style.borderColor = '#dc2626';
                active.style.background  = '#fef2f2';
                active.style.color       = '#dc2626';
            }
        }

        // ─── Set keputusan dan langsung simpan ───────────────
        function setKeputusan(prefix, siswaId, val) {
            // Update hidden status
            document.getElementById('status-' + prefix + '-' + siswaId).value = val;
            // Highlight button
            highlightBtn(prefix, siswaId, val);
            // Auto-save ke server
            const jenis = prefix === 'ak' ? 'akademik' : 'ibadah';
            autoSave(siswaId, jenis);
        }

        // ─── AJAX auto-save ───────────────────────────────────
        function autoSave(siswaId, jenis) {
            const prefix  = jenis === 'akademik' ? 'ak' : 'ib';
            const nilai    = document.getElementById('nilai-' + prefix + '-' + siswaId)?.value ?? '';
            const tanggal  = document.getElementById('tgl-' + prefix + '-' + siswaId)?.value ?? '';
            const status   = document.getElementById('status-' + prefix + '-' + siswaId)?.value ?? 'belum_dinilai';

            const formData = new FormData();
            formData.append('_token',      CSRF);
            formData.append('jenis_tes',   jenis);
            formData.append('status',      status);
            if (nilai)   formData.append('nilai',       nilai);
            if (tanggal) formData.append('tanggal_tes', tanggal);

            fetch('/admin/penilaian/' + siswaId, {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
                body: formData,
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    showToast(data.message, 'success');
                    updateBadge(siswaId, data.siswa_status, data.status_label);
                } else {
                    showToast('Gagal menyimpan data.', 'error');
                }
            })
            .catch(() => showToast('Terjadi kesalahan koneksi.', 'error'));
        }
    </script>
</x-app-layout>
