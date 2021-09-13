<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PenarikanRequest;
use App\Models\JenisTabungan;
use App\Models\Tabungan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class PenarikanController extends Controller
{
    /**
     * Menampilkan halaman utama
     * 
     * @param Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Tabungan::where('jenis_tabungan_id', 4)->get();
            
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->editColumn('nama', function($data) {
                        return [
                            'nama' => $data->user->anggota->nama,
                            'id' => $data->user->anggota->id
                        ];
                    })
                    ->editColumn('created_at', function($data) {
                        return $data->created_at->diffForHumans();
                    })
                    ->editColumn('action', function($data) {
                        return $data->id;
                    })
                    ->make(true);
        }

        return view('admin.penarikan.index');
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
        
        return view('admin.penarikan.create', compact('jenisTabungan', 'user'));
    }

    /**
     * Simpan resource yang baru dibuat di penyimpanan.
     * 
     * @param \App\Http\Requests\PenarikanRequest $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(PenarikanRequest $request)
    {
        DB::transaction(function() use ($request) {
            $latestSaldo = Tabungan::where('user_id', $request->user_id)->orderBy('created_at', 'desc')->first();

            Tabungan::create([
                'user_id' => $request->user_id,
                'jenis_tabungan_id' => 4,
                'jml_tabungan' => $request->jml_tabungan,
                'saldo' => $latestSaldo == null ? $request->jml_tabungan:($latestSaldo->saldo - $request->jml_tabungan),
            ]);
        });

        return redirect()->route('penarikan.index')->withSuccess('Berhasil Disimpan !');
    }
}
