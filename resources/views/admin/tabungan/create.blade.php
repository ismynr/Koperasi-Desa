<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Setor Tabungan') }}
        </h2>
    </x-slot>

    <div class="card my-4">
        <div class="card-body">
            
            <!-- Session Status -->
            <x-auth-session-status class="mb-3" :status="session('success')" />

            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-3" :errors="$errors" />

            <form method="POST" action="{{ route('tabungan.store') }}">
                @csrf

                <!-- Anggota -->
                <div class="mb-3">
                    <x-label for="user_id" :value="__('Anggota')" />

                    <select name="user_id" class="form-control">
                        <option selected disabled>Pilih Anggota</option>
                        @foreach ($user as $item)
                            <option value="{{$item->id}}">{{$item->anggota->nama}}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Jenis Tabungan -->
                <div class="mb-3">
                    <x-label for="nama" :value="__('Jenis Tabungan')" />

                    <select name="jenis_tabungan_id" class="form-control">
                        <option disabled selected>Pilih Jenis Setoran</option>
                        @foreach ($jenisTabungan as $item)
                            @if ($item->jenis_tabungan == 'Simpanan Sukarela')
                                <option value="{{$item->id}}">{{$item->jenis_tabungan}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <!-- Email Address -->
                <div class="mb-3">
                    <x-label for="jml_tabungan" :value="__('Jumlah Setoran')" />

                    <x-input id="jml_tabungan" type="jml_tabungan" name="jml_tabungan" :value="old('jml_tabungan')" required />
                </div>

                <div class="mb-0">
                    <div class="d-flex justify-content-end align-items-baseline">

                        <x-button>
                            {{ __('Simpan') }}
                        </x-button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <x-slot name="js">
    </x-slot>
</x-app-layout>