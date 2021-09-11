<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="card my-4">
        <div class="card-body">

            <!-- Session Status -->
            <x-auth-session-status class="mb-3" :status="session('success')" />

            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-3" :errors="$errors" />
            
            <div class="container">
                
                <h1>Data Anggota</h1>
                <a href="{{ route('anggota.create') }}" class="btn btn-dark mb-2">Pendaftaran Anggota Baru</a>

                <table class="table table-bordered data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Kel</th>
                            <th>Pekerjaan</th>
                            <th>No Hp</th>
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
    
                let table = $('.data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('anggota.index') }}",
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'nama', name: 'nama'},
                        {data: 'jk', name: 'jk'},
                        {data: 'pekerjaan', name: 'pekerjaan'},
                        {data: 'no_hp', name: 'no_hp'},
                        {data: 'action', name: 'action', orderable: false, searchable: false,
                            render: function( data, _type, _full ) {
                                let routeDestroy = "{{route('anggota.destroy', ':id')}}";
                                let routeShow = "{{route('anggota.show', ':id')}}";
                                let btn = `
                                    <a class="btn btn-success" href="${routeShow.replace(':id', data)}">Lihat</a>
                                    <form method="POST" action="${routeDestroy.replace(':id', data)}">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <div class="form-group">
                                            <input type="submit" onclick="return confirm('Are you sure?')" class="btn btn-danger" value="Delete user">
                                        </div>
                                    </form>`;
                                return btn;
                        }},
                    ]
                });
            });
        </script>
    </x-slot>
</x-app-layout>