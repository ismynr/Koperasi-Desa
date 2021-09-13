<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\Tabungan;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MutasiAnggotaController extends Controller
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
            $data = Tabungan::where('user_id', auth()->id())->get();
            
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->editColumn('jenis_tabungan', function($data) {
                        return $data->jenisTabungan->jenis_tabungan;
                    })
                    ->editColumn('penarikan', function($data) {
                        return $data->jenis_tabungan_id == 4 ? $data->jml_tabungan:'-';
                    })
                    ->editColumn('setoran', function($data) {
                        return $data->jenis_tabungan_id != 4 ? $data->jml_tabungan:'-';
                    })
                    ->editColumn('created_at', function($data) {
                        return date('d-m-y h:m', strtotime($data->created_at));
                    })
                    ->make(true);
        }

        $wajib = Tabungan::where('user_id', auth()->id())->where('jenis_tabungan_id', '2')->get()->sum('jml_tabungan');
        $sukarela = Tabungan::where('user_id', auth()->id())->where('jenis_tabungan_id', '3')->get()->sum('jml_tabungan');
        $penarikan = Tabungan::where('user_id', auth()->id())->where('jenis_tabungan_id', '4')->get()->sum('jml_tabungan');

        return view('anggota.mutasi-anggota.index', compact('wajib', 'sukarela', 'penarikan'));
    }
}
