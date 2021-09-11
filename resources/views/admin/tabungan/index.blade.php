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
            
            <div class="container">

                <h1>Tagihan Setoran Tabungan Anggota</h1>
                <table class="table table-bordered data-table-tagihan">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Kelamon</th>
                            <th>Pekerjaan</th>
                            <th>No Hp</th>
                            <th>Tagihan</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <div class="card my-4">
        <div class="card-body">
            <div class="container">

                <h1>Riwayat Tabungan</h1>
                <a href="{{ route('tabungan.create') }}" class="btn btn-dark mb-2">Setoran Baru</a>
                
                <table class="table table-bordered data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Jenis</th>
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

                let tableTagihan = $('.data-table-tagihan').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('tabungan.tagihan') }}",
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'nama', name: 'nama', 
                            render: function( data, _type, _full ) {
                                let routeShow = "{{route('anggota.show', ':id')}}";
                                return `<a href="${routeShow.replace(':id', data.id)}">${data.nama}</a>`;
                        }},
                        {data: 'jk', name: 'jk'},
                        {data: 'pekerjaan', name: 'pekerjaan'},
                        {data: 'no_hp', name: 'no_hp'},
                        {data: 'tagihan', name: 'tagihan'},
                        {data: 'action', name: 'action', orderable: false, searchable: false,
                            render: function( data, _type, _full ) {
                                let routeShow = "{{route('tabungan.show', ':id')}}";
                                let btn = `
                                    <a class="btn btn-info" href="${routeShow.replace(':id', data)}">Lihat</a>`;
                                return btn;
                        }},
                    ]
                });
    
                let table = $('.data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('tabungan.index') }}",
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'nama', name: 'nama', 
                            render: function( data, _type, _full ) {
                                let routeShow = "{{route('anggota.show', ':id')}}";
                                return `<a href="${routeShow.replace(':id', data.id)}">${data.nama}</a>`;
                        }},
                        {data: 'jenis_tabungan', name: 'jenis_tabungan'},
                        {data: 'jml_tabungan', name: 'jml_tabungan'},
                        {data: 'created_at', name: 'created_at'},
                    ]
                });

                

            });
        </script>
    </x-slot>
</x-app-layout>