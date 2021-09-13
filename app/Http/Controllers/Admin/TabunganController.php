<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TabunganRequest;
use App\Models\Anggota;
use App\Models\JenisTabungan;
use App\Models\Tabungan;
use App\Models\User;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class TabunganController extends Controller
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
        if ($request->ajax()) {
            $data = Tabungan::all();
            
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->editColumn('nama', function($data) {
                        return [
                            'nama' => $data->user->anggota->nama,
                            'id' => $data->user->anggota->id
                        ];
                    })
                    ->editColumn('jenis_tabungan', function($data) {
                        return $data->jenisTabungan->jenis_tabungan;
                    })
                    ->editColumn('created_at', function($data) {
                        return $data->created_at->diffForHumans();
                    })
                    ->editColumn('action', function($data) {
                        return $data->user->anggota->id;
                    })
                    ->make(true);
        }

        return view('admin.tabungan.index');
    }

    /**
     * Menampilkan formulir untuk membuat resource baru
     * 
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $jenisTabungan = JenisTabungan::all();
        $user = User::withWhereHas('anggota')->get();

        return view('admin.tabungan.create', compact('jenisTabungan', 'user'));
    }

    /**
     * Simpan resource yang baru dibuat di penyimpanan.
     * 
     * @param \App\Http\Requests\TabunganRequest $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(TabunganRequest $request)
    {
        DB::transaction(function() use ($request) {
            $latestSaldo = Tabungan::where('user_id', $request->user_id)->orderBy('id', 'desc')->first();

            Tabungan::create([
                'user_id' => $request->user_id,
                'jenis_tabungan_id' => $request->jenis_tabungan_id,
                'jml_tabungan' => $request->jml_tabungan,
                'saldo' => $latestSaldo == null ? $request->jml_tabungan:($latestSaldo->saldo + $request->jml_tabungan)
            ]);            
        });

        return redirect()->route('tabungan.index')->withSuccess('Berhasil Disimpan !');
    }

    /**
     * Return riwayat tagihan lunas setoran tabungan dengan format datatables
     * dan menampilkan view 
     * 
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Anggota $tabungan
     * 
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Anggota $tabungan)
    {
        $arr = $this->generateTagihan($tabungan);

        if ($request->ajax()) {
            $data = new Collection;
            $latestSaldo = Tabungan::where('user_id', $tabungan->user->id)->orderBy('created_at', 'desc')->first();

            // Jika tidak ada tabungan dengan jenis 1 (pokok)
            if (!$this->countSetor(1, $tabungan->user->id)){
                $data->push([
                    'tgl_seharusnya' => date('d-m-Y', strtotime($tabungan->user->created_at)),
                    'jenis_tabungan' => 'Setoran Pokok',
                    'jml_yg_hrs_dibayar' => $defTabungan =JenisTabungan::find(1)->default_tabungan,
                    'action' => ($data->count() != 0) ? null:[
                        'user_id' => $tabungan->user->id,
                        'jenis_tabungan_id' => 1,
                        'jml_tabungan' => $defTabungan,
                        'saldo' => $latestSaldo == null ? $request->jml_tabungan:($latestSaldo->saldo + $request->jml_tabungan),
                    ]
                ]);
            }

            foreach ($arr as $item) {
                $data->push([
                    'tgl_seharusnya'       => $item,
                    'jenis_tabungan'      => 'Setoran Wajib',
                    'jml_yg_hrs_dibayar' => $defTabungan = JenisTabungan::find(2)->default_tabungan,
                    'action' => ($data->count() != 0) ? null:[
                        'user_id' => $tabungan->user->id,
                        'jenis_tabungan_id' => 2,
                        'jml_tabungan' => $defTabungan,
                        'saldo' => $latestSaldo == null ? $request->jml_tabungan:($latestSaldo->saldo + $request->jml_tabungan),
                    ]
                ]);
            }

            return Datatables::of($data)->addIndexColumn()->make(true);
        }

        // pindah binding karena untuk dapat mengambil requestnya 
        $anggota = $tabungan;
        return view('admin.tabungan.show', compact('anggota'));
    }

    /**
     * Return tagihan setoran dengan format datatables
     * 
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function tagihan(Request $request)
    {
        if ($request->ajax()) {
            $data = Anggota::doesntHave('user.tabungan')
                    ->orWhereHas('user.tabungan')
                    ->get();

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->editColumn('nama', function($data) {
                        return [
                            'nama' => $data->user->anggota->nama,
                            'id' => $data->user->anggota->id
                        ];
                    })
                    ->editColumn('tagihan', function($data) {
                        return count($this->generateTagihan($data)) != 0 ? 'Ada':'Tidak Ada';
                    })
                    ->editColumn('action', function($data) {
                        return $data->id;
                    })
                    ->make(true);
        }

        return view('admin.tabungan.index');
    }

    /**
     * Generate tagihan dengan return tanggal sesuai dengan tanggal awal - tanggal akhir
     * 
     * @param mixed $anggota
     * 
     * @return array
     */
    private function generateTagihan($anggota)
    {
        // generate tanggal dari awal daftar anggota
        $period = new DatePeriod(
                        new DateTime(date('Y-m-d H:i:s', strtotime($anggota->user->created_at. ' + '.$this->countSetor(2, $anggota->user->id).' months'))),
                        new DateInterval('P1M'),
                        new DateTime(date('Y-m-d H:i:s', strtotime(' + 1 month')))
                    );

        $arr = [];
        foreach ($period as $value) {
            $arr[] = $value->format('d-m-Y');
        }

        return $arr;
    }
    
    /**
     * Menjumlahhkan semua tabungan berdasarkan user_id dan jenis_tabungan_id
     * 
     * @param mixed $jenis
     * @param mixed $userId
     * 
     * @return \App\Models\Tabungan
     */
    private function countSetor($jenis, $userId)
    {
        return Tabungan::where('user_id', $userId)
                    ->where('jenis_tabungan_id', $jenis)
                    ->count();
    }
}
