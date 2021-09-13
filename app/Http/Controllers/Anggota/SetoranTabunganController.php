<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\JenisTabungan;
use App\Models\Tabungan;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SetoranTabunganController extends Controller
{
    /**
     * Menampilkan halaman utama
     * 
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $countSetorTerbayar = Tabungan::where('user_id', auth()->id())
                                        ->where('jenis_tabungan_id', 2)
                                        ->count();
        $countSetorPokok = Tabungan::where('user_id', auth()->id())
                                        ->where('jenis_tabungan_id', 1)
                                        ->count();

        // generate tanggal dari awal daftar anggota
        $period = new DatePeriod(
                        new DateTime(date('Y-m-d H:i:s', strtotime(auth()->user()->created_at. ' + '.$countSetorTerbayar.' months'))),
                        new DateInterval('P1M'),
                        new DateTime(date('Y-m-d H:i:s', strtotime(' + 1 month')))
                    );

        $arr = [];
        foreach ($period as $value) {
            $arr[] = $value->format('d-m-Y');
        }

        if ($request->ajax()) {
            $data = new Collection;

            if (!$countSetorPokok){
                $data->push([
                    'tgl_seharusnya' => date('d-m-Y', strtotime(auth()->user()->created_at)),
                    'jenis_tabungan' => 'Setoran Pokok',
                    'jml_yg_hrs_dibayar' => JenisTabungan::find(1)->default_tabungan,
                ]);
            }

            foreach ($arr as $item) {
                $data->push([
                    'tgl_seharusnya'       => $item,
                    'jenis_tabungan'      => 'Setoran Wajib',
                    'jml_yg_hrs_dibayar' => JenisTabungan::find(2)->default_tabungan,
                ]);
            }

            return Datatables::of($data)->addIndexColumn()->make(true);
        }

        return view('anggota.setoran-tabungan.index');
    }
}
