<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Create Pengajuan Pinjaman') }}
        </h2>
    </x-slot>

    <div class="card my-4">
        <div class="card-body">
            
            <!-- Session Status -->
            <x-auth-session-status class="mb-3" :status="session('success')" />

            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-3" :errors="$errors" />

            <form method="POST" action="{{ route('pengajuan-pinjaman.store') }}">
                @csrf

                <!-- Jumlah Pinjaman -->
                <div class="mb-3">
                    <x-label for="jml_pinjaman" :value="__('Jumlah Pinjam')" />

                    <x-input id="jml_pinjaman" type="number" name="jml_pinjaman" :value="old('jml_pinjaman')" autofocus />
                </div>

                <!-- Tenor -->
                <div class="mb-3">
                    <x-label for="tenor" :value="__('Tenor berapa bulan')" />

                    <x-input id="tenor" type="number" name="tenor" :value="old('tenor')" required />
                </div>

                <!-- Total Pinjaman -->
                <div class="mb-3">
                    <x-label for="total_pinjaman" :value="__('Total Pinjaman')" />

                    <x-input id="total_pinjaman" type="total_pinjaman" name="total_pinjaman" :value="old('total_pinjaman')" required readonly/>
                    <small>(Bunga Pinjam * Tenor) + Jumlah Pinjam</small>
                </div>

                <!-- Yang Dibayarkan -->
                <div class="mb-3">
                    <x-label for="mbuh" :value="__('Dibayar Perbulan')" />

                    <x-input id="mbuh" type="mbuh" name="mbuh" :value="old('mbuh')" required readonly/>
                </div>

                <!-- Tujuan Pinjaman -->
                <div class="mb-3">
                    <x-label for="tujuan_pinjaman" :value="__('Tujuan Anda Meminjam')" />

                    <x-input id="tujuan_pinjaman" type="text" name="tujuan_pinjaman" :value="old('tujuan_pinjaman')" required autofocus />
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
        <script>
            $(() => {
                $('form input[name=tenor]').on('keyup', (e) => {
                    $jml_pinjam = $('form input[name=jml_pinjaman]').val();
                    $tenor = $('form input[name=tenor]').val();
                    $bunga = parseFloat("{{$bunga}}");
                    $bungaDecimal = ($bunga / 100); //precent to decimal
                    $total_pinjam = parseInt($jml_pinjam) + Math.round((($jml_pinjam * $bungaDecimal) * $tenor));

                    $('form input[name=total_pinjaman]').val($total_pinjam);
                    $('form input[name=mbuh]').val(Math.round($total_pinjam / $tenor));
                });
            })
        </script>
    </x-slot>
</x-app-layout>