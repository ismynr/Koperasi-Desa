<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Tagihan Tabungan') }}
        </h2>
    </x-slot>

    <div class="card my-4">
        <div class="card-body">
            <h4>Tagihan Setoran Tabungan</h4>

            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Seharusnya</th>
                        <th>Jenis</th>
                        <th>Jumlah yg Harus Dibayar</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

    <x-slot name="js">
        <script>
            $(() => {
                let table = $('.data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('tabungan.show', $anggota->id) }}",
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'tgl_seharusnya', name: 'tgl_seharusnya'},
                        {data: 'jenis_tabungan', name: 'jenis_tabungan'},
                        {data: 'jml_yg_hrs_dibayar', name: 'jml_yg_hrs_dibayar'},
                        {data: 'action', name: 'action', 
                            render: function( data, _type, _full ) {
                                if(data){
                                    let btn = `
                                        <form method="POST" action="{{route('tabungan.store')}}">
                                            {{ csrf_field() }}
                                            {{ method_field('POST') }}
                                            <input type="hidden" name="user_id" value="${data.user_id}"/>
                                            <input type="hidden" name="jenis_tabungan_id" value="${data.jenis_tabungan_id}"/>
                                            <input type="hidden" name="jml_tabungan" value="${data.jml_tabungan}"/>
                                            <input type="hidden" name="saldo" value="${data.saldo}"/>
                                            <div class="form-group">
                                                <input type="submit" onclick="return confirm('Are you sure?')" class="btn btn-success" value="Tandai Lunas">
                                            </div>
                                        </form>`;
                                    return btn;
                                }
                                
                                return '';
                        }},
                    ]
                });

            })
        </script>
    </x-slot>
</x-app-layout>