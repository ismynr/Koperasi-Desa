<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Pinjaman') }}
        </h2>
    </x-slot>

    <div class="card my-4">
        <div class="card-body">
            
            <div class="container">
                <h1>Pinjaman</h1></h1>
                <table class="table table-bordered data-table-pinjaman">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Jumlah</th>
                            <th>Tenor</th>
                            <th>Total</th>
                            <th>Status</th>
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
                let pinjaman = $('.data-table-pinjaman').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('pinjaman.index') }}",
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
                        {data: 'status', name: 'status'},
                        {data: 'action', name: 'action', orderable: false, searchable: false,
                            render: function( data, _type, _full ) {
                                let routeShow = "{{route('pinjaman.show', ':id')}}";
                                return `<a class="btn btn-warning" href="${routeShow.replace(':id', data)}">Lihat Angsuran</a>`;
                        }},
                    ]
                });
            });
        </script>
    </x-slot>
</x-app-layout>