{{-- Partial: ortu-edit-fields.blade.php --}}
{{-- Variables: $prefix (ayah|ibu|wali), $label, $data (CalonSiswa model) --}}

@php $full = 'grid-column:span 2'; @endphp

<div style="{{ $full }}">
    <x-input-label for="nama_{{ $prefix }}" :value="__('Nama ' . $label)" />
    <x-text-input id="nama_{{ $prefix }}" class="block mt-1 w-full" type="text"
        name="nama_{{ $prefix }}" :value="old('nama_' . $prefix, $data->{'nama_' . $prefix})" placeholder="Nama lengkap {{ $label }}" />
</div>
<div>
    <x-input-label for="nik_{{ $prefix }}" :value="__('NIK')" />
    <x-text-input id="nik_{{ $prefix }}" class="block mt-1 w-full" type="text"
        name="nik_{{ $prefix }}" :value="old('nik_' . $prefix, $data->{'nik_' . $prefix})" maxlength="16" />
</div>
<div>
    <x-input-label for="tempat_lahir_{{ $prefix }}" :value="__('Tempat Lahir')" />
    <x-text-input id="tempat_lahir_{{ $prefix }}" class="block mt-1 w-full" type="text"
        name="tempat_lahir_{{ $prefix }}" :value="old('tempat_lahir_' . $prefix, $data->{'tempat_lahir_' . $prefix})" />
</div>
<div>
    <x-input-label for="tanggal_lahir_{{ $prefix }}" :value="__('Tanggal Lahir')" />
    <x-text-input id="tanggal_lahir_{{ $prefix }}" class="block mt-1 w-full" type="date"
        name="tanggal_lahir_{{ $prefix }}" :value="old('tanggal_lahir_' . $prefix, $data->{'tanggal_lahir_' . $prefix})" />
</div>
<div>
    <x-input-label for="pendidikan_{{ $prefix }}" :value="__('Pendidikan Terakhir')" />
    <select id="pendidikan_{{ $prefix }}" name="pendidikan_{{ $prefix }}"
        style="border:1px solid #d1d5db; border-radius:6px; padding:8px 12px; width:100%; margin-top:4px; font-size:14px;">
        <option value="">-- Pilih --</option>
        @foreach(['SD/MI','SMP/MTs','SMA/MA/SMK','D1/D2/D3','S1/D4','S2','S3','Tidak Sekolah'] as $p)
        <option value="{{ $p }}" {{ old('pendidikan_' . $prefix, $data->{'pendidikan_' . $prefix}) == $p ? 'selected' : '' }}>{{ $p }}</option>
        @endforeach
    </select>
</div>
<div>
    <x-input-label for="pekerjaan_{{ $prefix }}" :value="__('Pekerjaan')" />
    <x-text-input id="pekerjaan_{{ $prefix }}" class="block mt-1 w-full" type="text"
        name="pekerjaan_{{ $prefix }}" :value="old('pekerjaan_' . $prefix, $data->{'pekerjaan_' . $prefix})" />
</div>
<div>
    <x-input-label for="penghasilan_{{ $prefix }}" :value="__('Penghasilan Perbulan')" />
    <select id="penghasilan_{{ $prefix }}" name="penghasilan_{{ $prefix }}"
        style="border:1px solid #d1d5db; border-radius:6px; padding:8px 12px; width:100%; margin-top:4px; font-size:14px;">
        <option value="">-- Pilih --</option>
        @foreach(['< Rp 1.000.000','Rp 1.000.000 – Rp 2.500.000','Rp 2.500.000 – Rp 5.000.000','Rp 5.000.000 – Rp 10.000.000','> Rp 10.000.000','Tidak Berpenghasilan'] as $pg)
        <option value="{{ $pg }}" {{ old('penghasilan_' . $prefix, $data->{'penghasilan_' . $prefix}) == $pg ? 'selected' : '' }}>{{ $pg }}</option>
        @endforeach
    </select>
</div>
<div style="{{ $full }}">
    <x-input-label for="alamat_{{ $prefix }}" :value="__('Alamat')" />
    <textarea id="alamat_{{ $prefix }}" name="alamat_{{ $prefix }}" rows="2"
        style="border:1px solid #d1d5db; border-radius:6px; padding:8px 12px; width:100%; margin-top:4px; font-size:14px;">{{ old('alamat_' . $prefix, $data->{'alamat_' . $prefix}) }}</textarea>
</div>
<div>
    <x-input-label for="rt_rw_{{ $prefix }}" :value="__('RT/RW')" />
    <x-text-input id="rt_rw_{{ $prefix }}" class="block mt-1 w-full" type="text"
        name="rt_rw_{{ $prefix }}" :value="old('rt_rw_' . $prefix, $data->{'rt_rw_' . $prefix})" placeholder="000/000" />
</div>
<div>
    <x-input-label for="kode_pos_{{ $prefix }}" :value="__('Kode Pos')" />
    <x-text-input id="kode_pos_{{ $prefix }}" class="block mt-1 w-full" type="text"
        name="kode_pos_{{ $prefix }}" :value="old('kode_pos_' . $prefix, $data->{'kode_pos_' . $prefix})" />
</div>
<div>
    <x-input-label for="kota_{{ $prefix }}" :value="__('Kota/Kabupaten')" />
    <x-text-input id="kota_{{ $prefix }}" class="block mt-1 w-full" type="text"
        name="kota_{{ $prefix }}" :value="old('kota_' . $prefix, $data->{'kota_' . $prefix})" />
</div>
<div>
    <x-input-label for="no_hp_{{ $prefix }}" :value="__('No. HP/WA Aktif')" />
    <x-text-input id="no_hp_{{ $prefix }}" class="block mt-1 w-full" type="text"
        name="no_hp_{{ $prefix }}" :value="old('no_hp_' . $prefix, $data->{'no_hp_' . $prefix})" placeholder="08xxxxxxxxxx" />
</div>
