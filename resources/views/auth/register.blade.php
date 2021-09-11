<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo width="82" />
            </a>
        </x-slot>

        <div class="card-body">
            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-4" :errors="$errors" />

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="mb-3">
                    <x-label for="nama" :value="__('Nama')" />

                    <x-input id="nama" type="text" name="nama" :value="old('nama')" autofocus />
                </div>

                <!-- Email Address -->
                <div class="mb-3">
                    <x-label for="email" :value="__('Email')" />

                    <x-input id="email" type="email" name="email" :value="old('email')" required />
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <x-label for="password" :value="__('Password')" />

                    <x-input id="password" type="password"
                                    name="password"
                                    required autocomplete="new-password" />
                </div>

                <!-- Confirm Password -->
                <div class="mb-3">
                    <x-label for="password_confirmation" :value="__('Confirm Password')" />

                    <x-input id="password_confirmation" type="password"
                                    name="password_confirmation" required />
                </div>

                <!-- Jenis Kelamin -->
                <div class="mb-3">
                    <x-label for="jk" :value="__('Jenis Kelamin')" />

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="jk" id="L" value="L">
                        <label class="form-check-label" for="L">
                          L
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="jk" id="P" value="P">
                        <label class="form-check-label" for="P">
                          P
                        </label>
                      </div>
                </div>

                <!-- Pekerjaan -->
                <div class="mb-3">
                    <x-label for="pekerjaan" :value="__('Pekerjaan')" />

                    <x-input id="pekerjaan" type="text" name="pekerjaan" :value="old('pekerjaan')" required autofocus />
                </div>

                <!-- No Hp -->
                <div class="mb-3">
                    <x-label for="no_hp" :value="__('No Hp')" />

                    <x-input id="no_hp" type="text" name="no_hp" :value="old('no_hp')" required autofocus />
                </div>

                <!-- Alamat -->
                <div class="mb-3">
                    <x-label for="alamat" :value="__('Alamat')" />

                    <x-input id="alamat" type="text" name="alamat" :value="old('alamat')" required autofocus />
                </div>

                <!-- Narek -->
                <div class="mb-3">
                    <x-label for="narek" :value="__('Nama Rekening')" />

                    <x-input id="narek" type="text" name="narek" :value="old('narek')" required autofocus />
                </div>

                <!-- Norek -->
                <div class="mb-3">
                    <x-label for="norek" :value="__('Nomor Rekening')" />

                    <x-input id="norek" type="text" name="norek" :value="old('norek')" required autofocus />
                </div>

                <div class="mb-0">
                    <div class="d-flex justify-content-end align-items-baseline">
                        <a class="text-muted me-3 text-decoration-none" href="{{ route('login') }}">
                            {{ __('Already registered?') }}
                        </a>

                        <x-button>
                            {{ __('Register') }}
                        </x-button>
                    </div>
                </div>
            </form>
        </div>
    </x-auth-card>
</x-guest-layout>
