<nav class="navbar navbar-expand-md navbar-light bg-white border-bottom sticky-top">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand" href="/">
            <x-application-logo width="36" />
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto">
                <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-nav-link>

                @if (Auth::user()->role == 1)

                    <x-nav-link href="{{ route('anggota.index') }}" :active="request()->routeIs('anggota.index')">
                        {{ __('Anggota') }}
                    </x-nav-link>

                    <x-nav-link href="{{ route('tabungan.index') }}" :active="request()->routeIs('tabungan.index')">
                        {{ __('Tabungan') }}
                    </x-nav-link>

                    <x-nav-link href="{{ route('penarikan.index') }}" :active="request()->routeIs('penarikan.index')">
                        {{ __('Penarikan') }}
                    </x-nav-link>

                    <x-nav-link href="{{ route('pinjaman.index') }}" :active="request()->routeIs('pinjaman.index')">
                        {{ __('Pinjaman') }}
                    </x-nav-link>

                    <x-nav-link href="{{ route('permintaan-pinjaman.index') }}" :active="request()->routeIs('permintaan-pinjaman.index')">
                        {{ __('Permintaan Pinjaman') }}
                    </x-nav-link>

                @else

                    <x-nav-link href="{{ route('pengajuan-pinjaman.index') }}" :active="request()->routeIs('pengajuan-pinjaman.index')">
                        {{ __('Ajukan Pinjaman') }}
                    </x-nav-link>

                    <x-nav-link href="{{ route('setoran-tabungan.index') }}" :active="request()->routeIs('setoran-tabungan.index')">
                        {{ __('Tagihan Setoran Anda') }}
                    </x-nav-link>

                    <x-nav-link href="{{ route('mutasi-anggota.index') }}" :active="request()->routeIs('mutasi-anggota.index')">
                        {{ __('Mutasi Anda') }}
                    </x-nav-link>

                @endif
                
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav">

                <!-- Settings Dropdown -->
                @auth
                    <x-dropdown id="settingsDropdown">
                        <x-slot name="trigger">
                            {{ Auth::user()->email }}
                        </x-slot>

                        <x-slot name="content">
                            @if (Auth::user()->role == 1)
                            <form>
                                <x-dropdown-link :href="route('pengaturan.index')">
                                    {{ __('Pengaturan') }}
                                </x-dropdown-link>
                            </form>
                            @endif

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
                @endauth
            </ul>
        </div>
    </div>
</nav>