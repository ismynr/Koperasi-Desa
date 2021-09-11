<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Pinjaman Anda') }}
        </h2>
    </x-slot>

    <div class="card my-4">
        <div class="card-body">

            <!-- Session Status -->
            <x-auth-session-status class="mb-3" :status="session('success')" />

            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-3" :errors="$errors" />
            
            <div class="container">

                <h1>Pinjaman Anda</h1>
                <a href="{{ route('pengajuan-pinjaman.create') }}" class="btn btn-dark mb-2">Ajukan Pinjaman</a>

                <table class="table table-bordered data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Jumlah</th>
                            <th>Tenor</th>
                            <th>Total</th>
                            <th>Disetujui</th>
                            <th>Sisa Angsuran</th>
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
    
                let permintaan = $('.data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('pengajuan-pinjaman.index') }}",
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'jml_pinjaman', name: 'jml_pinjaman'},
                        {data: 'tenor', name: 'tenor'},
                        {data: 'total_pinjaman', name: 'total_pinjaman'},
                        {data: 'disetujui', name: 'disetujui'},
                        {data: 'sisa_angsuran', name: 'sisa_angsuran'},
                        {data: 'action', name: 'action', orderable: false, searchable: false,
                            render: function( data, _type, _full ) {
                                if(data){
                                    let routeShow = "{{route('pengajuan-pinjaman.show', ':id')}}";
                                    return `<a class="btn btn-warning" href="${routeShow.replace(':id', data)}">Angsuran Pinjaman</a>`;
                                }

                                return '';
                        }},
                    ]
                });

            });
        </script>
    </x-slot>
</x-app-layout>