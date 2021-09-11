<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Tabungan') }}
        </h2>
    </x-slot>

    <div class="card my-4">
        <div class="card-body">
            
            <!-- Session Status -->
            <x-auth-session-status class="mb-3" :status="session('success')" />

            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-3" :errors="$errors" />

            <form method="POST" action="{{ route('pengaturan.update', 'BUNGA_PINJAMAN') }}">
                @method('POST')
                @csrf

                <div class="mb-3">
                    <x-label for="value" :value="__('Bunga Pinjaman')" />

                    <x-input id="value" type="value" name="value" :value="$pengaturan->where('key', 'BUNGA_PINJAMAN')->first()->value" required />
                </div>

                <div class="mb-0">
                    <div class="d-flex justify-content-end align-items-baseline">
                        <x-button id="pengaturan-submit-btn">
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