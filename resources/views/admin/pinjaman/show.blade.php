<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Angsuran Pinjaman') }}
        </h2>
    </x-slot>

    <div class="card my-4">
        <div class="card-body">
            <h4>Tagihan Angsuran Pinjaman</h4>

            <table class="table table-bordered data-table-tagihan">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Angsuran Ke</th>
                        <th>Jumlah Angsuran</th>
                        <th>Bayar Sebelum</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card my-4">
        <div class="card-body">
            <h4>Riwayat Angsuran Pinjaman</h4>

            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Angsuran Ke</th>
                        <th>Jumlah Angsuran</th>
                        <th>Tgl Bayar</th>
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
                let tableTagihan = $('.data-table-tagihan').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('pinjaman.tagihan', $pinjaman->id) }}",
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'angsuran_ke', name: 'angsuran_ke'},
                        {data: 'jml_angsuran', name: 'jml_angsuran'},
                        {data: 'bayar_sebelum', name: 'bayar_sebelum'},
                        {data: 'action', name: 'action', 
                            render: function( data, _type, _full ) {
                                if(data){
                                    let btn = `
                                        <form method="POST" action="{{route('pinjaman.store')}}">
                                            {{ csrf_field() }}
                                            {{ method_field('POST') }}
                                            <input type="hidden" name="pinjaman_id" value="{{$pinjaman->id}}"/>
                                            <input type="hidden" name="angsuran_ke" value="${data.angsuran_ke}"/>
                                            <input type="hidden" name="jml_angsuran" value="${data.jml_angsuran}"/>
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

                let table = $('.data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('pinjaman.show', $pinjaman->id) }}",
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'angsuran_ke', name: 'angsuran_ke'},
                        {data: 'jml_angsuran', name: 'jml_angsuran'},
                        {data: 'created_at', name: 'created_at'},
                    ]
                });

            })
        </script>
    </x-slot>
</x-app-layout>