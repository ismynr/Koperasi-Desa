<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Mutasi Anda') }}
        </h2>
    </x-slot>

    <div class="card my-4">
        <div class="card-body">

            <!-- Session Status -->
            <x-auth-session-status class="mb-3" :status="session('success')" />

            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-3" :errors="$errors" />
            
            <div class="container">

                <h1>Mutasi Anda</h1>
                <table class="mb-3">
                    <tr>
                        <th>Total Simpanan Wajib :</th>
                        <td>{{$wajib}}</td>
                    </tr>
                    <tr>
                        <th>Total Simpanan Sukarela :</th>
                        <td>{{$sukarela}}</td>
                    </tr>
                    <tr>
                        <th>Total Penarikan :</th>
                        <td>{{$penarikan}}</td>
                    </tr>
                </table>
                <table class="table table-bordered data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Jenis</th>
                            <th>Penarikan</th>
                            <th>Setoran</th>
                            <th>Saldo</th>
                            <th>Dibuat</th>
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
                    ajax: "{{ route('mutasi-anggota.index') }}",
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'jenis_tabungan', name: 'jenis_tabungan'},
                        {data: 'penarikan', name: 'penarikan'},
                        {data: 'setoran', name: 'setoran'},
                        {data: 'saldo', name: 'saldo'},
                        {data: 'created_at', name: 'created_at'},
                    ]
                });

                

            });
        </script>
    </x-slot>
</x-app-layout>