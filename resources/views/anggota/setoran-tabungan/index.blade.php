<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Tagihan Setoran Tabungan Anda') }}
        </h2>
    </x-slot>

    <div class="card my-4">
        <div class="card-body">

            <!-- Session Status -->
            <x-auth-session-status class="mb-3" :status="session('success')" />

            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-3" :errors="$errors" />
            
            <div class="container">

                <h1>Tagihan Setoran Tabungan Anda</h1>

                <table class="table table-bordered data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal Seharusnya</th>
                            <th>Jenis</th>
                            <th>Jumlah yg Harus Dibayar</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <x-slot name="js">
        <script>
            $(function () {
                let table = $('.data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('setoran-tabungan.index') }}",
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'tgl_seharusnya', name: 'tgl_seharusnya'},
                        {data: 'jenis_tabungan', name: 'jenis_tabungan'},
                        {data: 'jml_yg_hrs_dibayar', name: 'jml_yg_hrs_dibayar'},
                    ]
                });
            });
        </script>
    </x-slot>
</x-app-layout>