<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Permintaan Pinjaman') }}
        </h2>
    </x-slot>

    <div class="card my-4">
        <div class="card-body">
            
            <!-- Session Status -->
            <x-auth-session-status class="mb-3" :status="session('success')" />

            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-3" :errors="$errors" />

            <div class="container">
                <h1>Permintaan Pengajuan</h1>
                <table class="table table-bordered data-table-permintaan">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Jumlah</th>
                            <th>Tenor</th>
                            <th>Total</th>
                            <th>Action</th>
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
    
                let permintaan = $('.data-table-permintaan').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('permintaan-pinjaman.index') }}",
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'nama', name: 'nama',
                            render: function( data, _type, _full ) {
                                let routeShow = "{{route('anggota.show', ':id')}}";
                                return `<a href="${routeShow.replace(':id', data.id)}">${data.nama}</a>`;
                        }},
                        {data: 'jml_pinjaman', name: 'jml_pinjaman'},
                        {data: 'tenor', name: 'tenor'},
                        {data: 'total_pinjaman', name: 'total_pinjaman'},
                        {data: 'action', name: 'action', orderable: false, searchable: false,
                            render: function( data, _type, _full ) {
                                let routeUpdate = "{{route('permintaan-pinjaman.update', ':id')}}";
                                let routeDestroy = "{{route('permintaan-pinjaman.destroy', ':id')}}";
                                return `
                                    <form method="POST" action="${routeUpdate.replace(':id', data)}">
                                        {{ csrf_field() }}
                                        {{ method_field('PUT') }}
                                        <div class="form-group">
                                            <input type="submit" onclick="return confirm('Are you sure?')" class="btn btn-success" value="Setujui">
                                        </div>
                                    </form>
                                    <form method="POST" action="${routeDestroy.replace(':id', data)}">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <div class="form-group">
                                            <input type="submit" onclick="return confirm('Are you sure?')" class="btn btn-danger" value="Tolak">
                                        </div>
                                    </form>`;
                        }},
                    ]
                });

            });
        </script>
    </x-slot>
</x-app-layout>