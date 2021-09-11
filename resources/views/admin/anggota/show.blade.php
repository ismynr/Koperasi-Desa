<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Detail Anggota') }}
        </h2>
    </x-slot>

    <div class="card my-4">
        <div class="card-body">
            <h4>Edit Anggota</h4>
            
            <!-- Session Status -->
            <x-auth-session-status class="mb-3" :status="session('status')" />

            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-3" :errors="$errors" />

            <form method="POST" action="{{ route('anggota.update', $anggota->id) }}">
                @method('PUT')
                @csrf

                <!-- Name -->
                <div class="mb-3">
                    <x-label for="nama" :value="__('Nama')" />

                    <x-input id="nama" type="text" name="nama" :value="$anggota->nama" required disabled="disabled" autofocus />
                </div>

                <!-- Email Address -->
                <div class="mb-3">
                    <x-label for="email" :value="__('Email')" />

                    <x-input id="email" type="email" name="email" :value="$anggota->user->email" required disabled="disabled" />
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <x-label for="password" :value="__('Password')" />

                    <x-input id="password" type="password"
                                    name="password"
                                    autocomplete="new-password" disabled="disabled"/>
                </div>

                <!-- Confirm Password -->
                <div class="mb-3">
                    <x-label for="password_confirmation" :value="__('Confirm Password')" />

                    <x-input id="password_confirmation" type="password"
                                    name="password_confirmation" disabled="disabled"/>
                </div>

                <!-- Jenis Kelamin -->
                <div class="mb-3">
                    <x-label for="jk" :value="__('Jenis Kelamin')" />

                    
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="jk" id="L" value="L" {{$anggota->jk == 'L' ?'checked':''}} disabled="disabled">
                        <label class="form-check-label" for="L">
                          L
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="jk" id="P" value="P" {{$anggota->jk == 'P' ?'checked':''}} disabled="disabled">
                        <label class="form-check-label" for="P">
                          P
                        </label>
                    </div>
                </div>

                <!-- Pekerjaan -->
                <div class="mb-3">
                    <x-label for="pekerjaan" :value="__('Pekerjaan')" />

                    <x-input id="pekerjaan" type="text" name="pekerjaan" :value="$anggota->pekerjaan" required disabled="disabled" autofocus />
                </div>

                <!-- No Hp -->
                <div class="mb-3">
                    <x-label for="no_hp" :value="__('No Hp')" />

                    <x-input id="no_hp" type="text" name="no_hp" :value="$anggota->no_hp" required disabled="disabled" autofocus />
                </div>

                <!-- Alamat -->
                <div class="mb-3">
                    <x-label for="alamat" :value="__('Alamat')" />

                    <x-input id="alamat" type="text" name="alamat" :value="$anggota->alamat" required disabled="disabled" autofocus />
                </div>

                <!-- Narek -->
                <div class="mb-3">
                    <x-label for="narek" :value="__('Nama Rekening')" />

                    <x-input id="narek" type="text" name="narek" :value="$anggota->narek" required disabled="disabled" autofocus />
                </div>

                <!-- Norek -->
                <div class="mb-3">
                    <x-label for="norek" :value="__('Nomor Rekening')" />

                    <x-input id="norek" type="text" name="norek" :value="$anggota->norek" required disabled="disabled" autofocus />
                </div>

                <div class="mb-0">
                    <div class="d-flex justify-content-end align-items-baseline">

                        <x-button id="edit-btn" style="display: block">
                            {{ __('Edit') }}
                        </x-button>

                        <x-button id="simpan-btn" style="display: none">
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

                $('#edit-btn').click((e) => {
                    e.preventDefault();
                    $("form :input").removeAttr('disabled','disabled');
                    $('#edit-btn').hide();
                    $('#simpan-btn').show();
                })
            })
        </script>
    </x-slot>
</x-app-layout>