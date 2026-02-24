<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    @if(Auth::user()->hasRole('admin'))
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                            <img src="{{ asset('logo_man.png') }}" class="h-8" alt="Logo MAN 4">
                            <span class="text-lg font-bold text-green-600 dark:text-green-400">PMB MAN 4</span>
                        </a>
                    @else
                        <a href="{{ route('siswa.dashboard') }}" class="flex items-center gap-2">
                            <img src="{{ asset('logo_man.png') }}" class="h-8" alt="Logo MAN 4">
                            <span class="text-lg font-bold text-green-600 dark:text-green-400">PMB MAN 4</span>
                        </a>
                    @endif
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @if(Auth::user()->hasRole('admin'))
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.pendaftar.index')" :active="request()->routeIs('admin.pendaftar.*')">
                            {{ __('Pendaftar') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.verifikasi.index')" :active="request()->routeIs('admin.verifikasi.*')">
                            {{ __('Verifikasi') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.penilaian.index')" :active="request()->routeIs('admin.penilaian.*')">
                            {{ __('Penilaian') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.jadwal.index')" :active="request()->routeIs('admin.jadwal.*')">
                            {{ __('Jadwal') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.pengumuman.index')" :active="request()->routeIs('admin.pengumuman.*')">
                            {{ __('Pengumuman') }}
                        </x-nav-link>

                        <!-- More Dropdown -->
                        <div class="hidden sm:flex sm:items-center" x-data="{ openMore: false }">
                            <div class="relative">
                                <button @click="openMore = !openMore" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-700 focus:outline-none transition duration-150 ease-in-out">
                                    Lainnya
                                    <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                </button>
                                <div x-show="openMore" @click.away="openMore = false" x-transition class="absolute z-50 mt-2 w-48 rounded-md shadow-lg bg-white dark:bg-gray-700 ring-1 ring-black ring-opacity-5">
                                    <div class="py-1">
                                        <a href="{{ route('admin.daftar-ulang.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600">Daftar Ulang</a>
                                        <a href="{{ route('admin.landing-page.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600">Landing Page</a>
                                        <a href="{{ route('admin.syarat.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600">Syarat Daftar Ulang</a>
                                        <a href="{{ route('admin.pengaturan-berkas.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600 {{ request()->routeIs('admin.pengaturan-berkas.*') ? 'bg-gray-100 dark:bg-gray-600 font-semibold' : '' }}">Pengaturan Berkas</a>
                                        <a href="{{ route('admin.roles.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600">Roles & Permission</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <x-nav-link :href="route('siswa.dashboard')" :active="request()->routeIs('siswa.dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                        <x-nav-link :href="route('siswa.berkas-awal.index')" :active="request()->routeIs('siswa.berkas-awal.*')">
                            {{ __('Berkas Pendaftaran') }}
                        </x-nav-link>
                        <x-nav-link :href="route('siswa.jadwal')" :active="request()->routeIs('siswa.jadwal')">
                            {{ __('Jadwal') }}
                        </x-nav-link>
                        <x-nav-link :href="route('siswa.hasil-tes')" :active="request()->routeIs('siswa.hasil-tes')">
                            {{ __('Hasil Tes') }}
                        </x-nav-link>
                        <x-nav-link :href="route('siswa.pengumuman')" :active="request()->routeIs('siswa.pengumuman')">
                            {{ __('Pengumuman') }}
                        </x-nav-link>
                        <x-nav-link :href="route('siswa.daftar-ulang')" :active="request()->routeIs('siswa.daftar-ulang')">
                            {{ __('Daftar Ulang') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <a href="{{ route('home') }}" class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 mr-4" target="_blank">
                    <svg class="w-5 h-5 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    Website
                </a>
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @if(Auth::user()->hasRole('admin'))
                <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.pendaftar.index')" :active="request()->routeIs('admin.pendaftar.*')">
                    {{ __('Pendaftar') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.verifikasi.index')" :active="request()->routeIs('admin.verifikasi.*')">
                    {{ __('Verifikasi') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.penilaian.index')" :active="request()->routeIs('admin.penilaian.*')">
                    {{ __('Penilaian') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.jadwal.index')" :active="request()->routeIs('admin.jadwal.*')">
                    {{ __('Jadwal') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.pengumuman.index')" :active="request()->routeIs('admin.pengumuman.*')">
                    {{ __('Pengumuman') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.daftar-ulang.index')" :active="request()->routeIs('admin.daftar-ulang.*')">
                    {{ __('Daftar Ulang') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.landing-page.index')" :active="request()->routeIs('admin.landing-page.*')">
                    {{ __('Landing Page') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.syarat.index')" :active="request()->routeIs('admin.syarat.*')">
                    {{ __('Syarat DU') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.pengaturan-berkas.index')" :active="request()->routeIs('admin.pengaturan-berkas.*')">
                    {{ __('Pengaturan Berkas') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.roles.index')" :active="request()->routeIs('admin.roles.*')">
                    {{ __('Roles & Permission') }}
                </x-responsive-nav-link>
            @else
                <x-responsive-nav-link :href="route('siswa.dashboard')" :active="request()->routeIs('siswa.dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('siswa.berkas-awal.index')" :active="request()->routeIs('siswa.berkas-awal.*')">
                    {{ __('Berkas Pendaftaran') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('siswa.jadwal')" :active="request()->routeIs('siswa.jadwal')">
                    {{ __('Jadwal') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('siswa.hasil-tes')" :active="request()->routeIs('siswa.hasil-tes')">
                    {{ __('Hasil Tes') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('siswa.pengumuman')" :active="request()->routeIs('siswa.pengumuman')">
                    {{ __('Pengumuman') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('siswa.daftar-ulang')" :active="request()->routeIs('siswa.daftar-ulang')">
                    {{ __('Daftar Ulang') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
