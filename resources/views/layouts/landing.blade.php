<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @php
        $siteName    = 'PMBM MAN 4 Kota Pekanbaru';
        $siteUrl     = config('app.url');
        $title       = 'Penerimaan Murid Baru MAN 4 Kota Pekanbaru';
        $description = 'Daftarkan putra-putri Anda di MAN 4 Kota Pekanbaru. Madrasah Aliyah Negeri unggulan dengan program SAINTEK, SOSHUM, dan Keagamaan. Informasi pendaftaran, jadwal, dan syarat lengkap tersedia di sini.';
        $image       = asset('gedung_man_4.jpeg');
        $pageUrl     = url()->current();
    @endphp

    <title>{{ $title }}</title>
    <meta name="description" content="{{ $description }}">
    <meta name="keywords" content="MAN 4 Pekanbaru, Madrasah Aliyah, PMB, Pendaftaran Siswa Baru, Penerimaan Murid Baru, MAN 4 Kota Pekanbaru">
    <meta name="author" content="{{ $siteName }}">

    {{-- Open Graph (Facebook, WhatsApp, Telegram, dll) --}}
    <meta property="og:type"        content="website">
    <meta property="og:site_name"   content="{{ $siteName }}">
    <meta property="og:title"       content="{{ $title }}">
    <meta property="og:description" content="{{ $description }}">
    <meta property="og:image"       content="{{ $image }}">
    <meta property="og:image:width"  content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt"    content="MAN 4 Kota Pekanbaru">
    <meta property="og:url"         content="{{ $pageUrl }}">
    <meta property="og:locale"      content="id_ID">

    {{-- Twitter Card --}}
    <meta name="twitter:card"        content="summary_large_image">
    <meta name="twitter:title"       content="{{ $title }}">
    <meta name="twitter:description" content="{{ $description }}">
    <meta name="twitter:image"       content="{{ $image }}">

    <link rel="canonical" href="{{ $pageUrl }}">
    <link rel="icon" type="image/png" href="{{ asset('logo_man.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50 text-gray-800 font-sans">

    <!-- Navbar -->
    <nav class="bg-white shadow-sm fixed w-full z-50 top-0 start-0 border-b border-gray-200">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <a href="{{ route('home') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
                <img src="{{ asset('logo_man.png') }}" class="h-10" alt="Logo MAN 4">
                <span class="self-center text-xl font-bold whitespace-nowrap text-green-700">PMBM MAN 4 Kota Pekanbaru</span>
            </a>
            <div class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-4 py-2 text-center">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-4 py-2 text-center me-2">Masuk</a>
                    <a href="{{ route('register') }}" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-4 py-2 text-center">Daftar</a>
                @endauth
                <button data-collapse-toggle="navbar-sticky" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200" aria-controls="navbar-sticky" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
                    </svg>
                </button>
            </div>
            <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
                <ul class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white">
                    <li>
                        <a href="#hero" class="block py-2 px-3 text-white bg-green-700 rounded md:bg-transparent md:text-green-700 md:p-0" aria-current="page">Beranda</a>
                    </li>
                    <li>
                        <a href="#sambutan" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-green-700 md:p-0">Sambutan</a>
                    </li>
                    <li>
                        <a href="#jurusan" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-green-700 md:p-0">Jurusan</a>
                    </li>
                    <li>
                        <a href="#alur" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-green-700 md:p-0">Alur</a>
                    </li>
                     <li>
                        <a href="#kontak" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-green-700 md:p-0">Kontak</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="mt-16">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white rounded-lg shadow m-4">
        <div class="w-full max-w-screen-xl mx-auto p-4 md:py-8">
            <div class="sm:flex sm:items-center sm:justify-between">
                <a href="#" class="flex items-center mb-4 sm:mb-0 space-x-3 rtl:space-x-reverse">
                    <img src="{{ asset('logo_man.png') }}" class="h-8" alt="Logo MAN 4"/>
                    <span class="self-center text-2xl font-semibold whitespace-nowrap text-green-700">PMBM MAN 4 Kota Pekanbaru</span>
                </a>
                <ul class="flex flex-wrap items-center mb-6 text-sm font-medium text-gray-500 sm:mb-0">
                    <li><a href="#" class="hover:underline me-4 md:me-6">Profil</a></li>
                    <li><a href="#" class="hover:underline me-4 md:me-6">Visi Misi</a></li>
                    <li><a href="#" class="hover:underline me-4 md:me-6">Kontak</a></li>
                </ul>
            </div>
            <hr class="my-6 border-gray-200 sm:mx-auto lg:my-8" />
            <span class="block text-sm text-gray-500 sm:text-center">© 2026 <a href="#" class="hover:underline">MAN 4 Pekanbaru</a>. All Rights Reserved.</span>
        </div>
    </footer>

    <!-- Floating WhatsApp Button -->
    <div id="wa-float-btn" style="position:fixed; bottom:24px; right:24px; z-index:9999; display:flex; flex-direction:column; align-items:flex-end; gap:8px;">
        <!-- Tooltip -->
        <div id="wa-tooltip" style="display:none; background:#fff; color:#15803d; font-weight:600; font-size:13px; padding:8px 16px; border-radius:999px; box-shadow:0 4px 12px rgba(0,0,0,0.15); border:1px solid #bbf7d0; white-space:nowrap;">
            💬 Chat HUMAS
        </div>
        <!-- WA Button -->
        <a href="https://wa.me/6281268713026?text=Assalamu'alaikum,%20saya%20ingin%20menanyakan%20informasi%20tentang%20PMBM%20MAN%204%20Kota%20Pekanbaru."
           target="_blank"
           rel="noopener noreferrer"
           id="wa-btn"
           aria-label="Chat WhatsApp HUMAS"
           style="position:relative; display:flex; align-items:center; justify-content:center; width:60px; height:60px; background:#25d366; border-radius:50%; box-shadow:0 6px 20px rgba(37,211,102,0.5); text-decoration:none; transition:transform 0.2s; overflow:visible;">
            <!-- Pulse Ring -->
            <span id="wa-pulse" style="position:absolute; top:0; left:0; width:60px; height:60px; border-radius:50%; background:rgba(37,211,102,0.5); animation:wa-ping 1.5s ease-out infinite;"></span>
            <!-- WA Icon SVG -->
            <svg xmlns="http://www.w3.org/2000/svg" style="width:32px;height:32px;fill:#fff;position:relative;z-index:1;" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
            </svg>
        </a>
    </div>

    <style>
        @keyframes wa-ping {
            0%   { transform: scale(1); opacity: 0.7; }
            70%  { transform: scale(1.6); opacity: 0; }
            100% { transform: scale(1.6); opacity: 0; }
        }
        #wa-btn:hover { transform: scale(1.1); }
    </style>

    <script>
        const waBtn = document.getElementById('wa-btn');
        const waTooltip = document.getElementById('wa-tooltip');
        waBtn.addEventListener('mouseenter', function() { waTooltip.style.display = 'block'; });
        waBtn.addEventListener('mouseleave', function() { waTooltip.style.display = 'none'; });
    </script>

</body>
</html>
