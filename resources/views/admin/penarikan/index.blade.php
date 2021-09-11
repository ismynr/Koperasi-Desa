<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Penarikan') }}
        </h2>
    </x-slot>

    <div class="card my-4">
        <div class="card-body">

            <!-- Session Status -->
            <x-auth-session-status class="mb-3" :status="session('success')" />

            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-3" :errors="$errors" />
            
            <div class="container">

                <h1>Riwayat Penarikan</h1>
                <a href="{{ route('penarikan.create') }}" class="btn btn-dark mb-2">Tarik Tabungan</a>

                <table class="table table-bordered data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Jumlah</th>
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
                    ajax: "{{ route('penarikan.index') }}",
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'nama', name: 'nama',
                            render: function( data, _type, _full ) {
                                let routeShow = "{{route('anggota.show', ':id')}}";
                                return `<a href="${routeShow.replace(':id', data.id)}">${data.nama}</a>`;
                        }},
                        {data: 'jml_tabungan', name: 'jml_tabungan'},
                        {data: 'created_at', name: 'created_at'},
                    ]
                });

                

            });
        </script>
    </x-slot>
</x-app-layout>