<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\AngsuranPinjaman;
use App\Models\Pinjaman;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class PengajuanPinjamanController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Pinjaman::where('user_id', auth()->id())->get();
            
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->editColumn('sisa_angsuran', function($data) {
                        $angsuran = Pinjaman::whereHas('angsuranPinjaman')->count();
                        return $data->disetujui == 1 ? ($data->tenor - $angsuran):'';
                    })
                    ->editColumn('disetujui', function($data) {
                        return $data->disetujui == 1 ? 'Ya':'Belum';
                    })
                    ->editColumn('action', function($data) {
                        return ($data->disetujui == 0 ? null:$data->id);
                    })
                    ->make(true);
        }

        return view('anggota.pengajuan-pinjaman.index');
    }

    public function create()
    {
        $bunga = DB::table('pengaturan')->where('key', 'BUNGA_PINJAMAN')->first()->value;

        return view('anggota.pengajuan-pinjaman.create', compact('bunga'));
    }

    public function store(Request $request)
    {
        DB::transaction(function() use ($request) {
            Pinjaman::create([
                'user_id' => auth()->id(),
                'jml_pinjaman' => $request->jml_pinjaman,
                'tenor' => $request->tenor,
                'total_pinjaman' => $request->total_pinjaman,
                'tujuan_pinjaman' => $request->tujuan_pinjaman,
                'disetujui' => '0',
            ]);            
        });

        return redirect()->route('pengajuan-pinjaman.index')->withSuccess('Berhasil Disimpan !');
    }

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

        return view('anggota.pengajuan-pinjaman.show', compact('pinjaman'));
    }

    public function edit(Pinjaman $pinjaman)
    {
        //
    }

    public function update(Request $request, Pinjaman $pinjaman)
    {
        //
    }

    public function destroy(Pinjaman $pinjaman)
    {
        //
    }

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
                ]);
                $no++;
            }

            return Datatables::of($data)->addIndexColumn()->make(true);
        }
    }

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
    
    private function countAngsuranPinjaman($pinjaman_id)
    {
        return AngsuranPinjaman::where('pinjaman_id', $pinjaman_id)->count();
    }
}
