@extends('layouts.landing')

@section('content')
    @foreach ($sections as $section)
        <section id="{{ $section->module->kode_modul }}" class="w-full">
            @includeIf($section->module->view_path, ['data' => json_decode($section->konten)])
        </section>
    @endforeach
@endsection
