<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AngsuranPinjaman;
use App\Models\Pinjaman;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class PinjamanController extends Controller
{
    /**
     * Menampilkan halaman utama dari anggota
     * 
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Pinjaman::where('disetujui', 1)->get();
            
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->editColumn('nama', function($data) {
                        return [
                            'nama' => $data->user->anggota->nama,
                            'id' => $data->user->anggota->id
                        ];
                    })
                    ->editColumn('status', function($data) {
                        $count = $data->angsuranPinjaman->count();
                        return 'Terbayar '. $count . ' Kali '.($data->tenor == $count ? 'LUNAS':'');
                    })
                    ->editColumn('action', function($data) {
                        return $data->id;
                    })
                    ->make(true);
        }

        return view('admin.pinjaman.index');
    }
    
    /**
     * Simpan resource angsuran pinjaman yang baru dibuat di penyimpanan.
     * 
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::transaction(function() use ($request) {
            AngsuranPinjaman::create([
                'pinjaman_id' => $request->pinjaman_id,
                'angsuran_ke' => $request->angsuran_ke,
                'jml_angsuran' => $request->jml_angsuran,
            ]);            
        });

        return redirect()->route('pinjaman.index')->withSuccess('Berhasil Disimpan !');
    }

    /**
     * Return riwayat tagihan lunas dengan format datatables
     * dan menampilkan view 
     * 
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Pinjaman $pinjaman
     * 
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Pinjaman $pinjaman)
    {
        // riwayat yang sudah lunas
        if ($request->ajax()) {
            $data = AngsuranPinjaman::where('pinjaman_id', $pinjaman->id)->get();

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->editColumn('created_at', function($data) {
                        return date('d-m-Y', strtotime($data->created_at));
                    })
                    ->make(true);
        }

        return view('admin.pinjaman.show', compact('pinjaman'));
    }

    /**
     * Return tagihan pinjaman dengan format datatables
     * 
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Pinjaman $pinjaman
     * 
     * @return \Illuminate\Http\Response
     */
    public function tagihan(Request $request, Pinjaman $pinjaman)
    {
        // prediksi tagihan untuk angsuran pinjaman
        $arr = $this->generateTagihan($pinjaman);

        if ($request->ajax()) {
            $data = new Collection;
            $latestAngsuran = AngsuranPinjaman::where('pinjaman_id', $pinjaman->id)->orderBy('angsuran_ke', 'desc')->first();
            $no = ($latestAngsuran == null) ? 1:($latestAngsuran->angsuran_ke+1);

            foreach ($arr as $item) {
                $data->push([
                    'angsuran_ke' => $no,
                    'jml_angsuran' => round($pinjaman->jml_pinjaman / $pinjaman->tenor),
                    'bayar_sebelum' => $item,
                    'action' =>  ($data->count() != 0) ? null:[
                        // data yang akan di store
                        'angsuran_ke' =>$no,
                        'jml_angsuran' => round($pinjaman->jml_pinjaman / $pinjaman->tenor),
                    ]
                ]);

                $no++;
            }

            return Datatables::of($data)->addIndexColumn()->make(true);
        }
    }

    /**
     * Generate tagihan dengan return tanggal sesuai dengan tanggal awal - tanggal akhir
     * 
     * @param mixed $pinjaman
     * 
     * @return array
     */
    private function generateTagihan($pinjaman)
    {
        // generate tanggal dari awal daftar anggota
        $period = new DatePeriod(
            new DateTime(date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s', strtotime($pinjaman->created_at.' +1 month')). ' + '.$this->countAngsuranPinjaman($pinjaman->id).'  months'))),
            new DateInterval('P1M'),
            new DateTime(date('Y-m-d H:i:s', strtotime('+ '.$pinjaman->tenor.' months')))
        );

        $arr = [];
        foreach ($period as $value) {
            $arr[] = $value->format('d-m-Y');
        }

        return $arr;
    }
        
    /**
     * Menjumlahhkan semua angsuran pinjaman berdasarkan pinjaman_id
     * 
     * @param mixed $pinjaman_id
     * 
     * @return \App\Models\AngsuranPinjaman
     */
    private function countAngsuranPinjaman($pinjaman_id)
    {
        return AngsuranPinjaman::where('pinjaman_id', $pinjaman_id)->count();
    }
}
