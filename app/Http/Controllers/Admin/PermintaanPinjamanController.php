<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pinjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class PermintaanPinjamanController extends Controller
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
            $data = Pinjaman::where('disetujui', '0')->get();
            
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->editColumn('nama', function($data) {
                        return [
                            'nama' => $data->user->anggota->nama,
                            'id' => $data->user->anggota->id
                        ];
                    })
                    ->editColumn('action', function($data) {
                        return $data->id;
                    })
                    ->make(true);
        }

        return view('admin.permintaan-pengajuan.index');
    }

    /**
     * Perbarui resource yang ditentukan dalam penyimpanan.
     * 
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Pinjaman $pinjaman
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pinjaman $pinjaman)
    {
        DB::transaction(function() use ($pinjaman) {
            $pinjaman->update([
                'disetujui' => '1'
            ]);
        });

        return redirect()->route('permintaan-pinjaman.index')->withSuccess('Berhasil Disimpan !');
    }

    /**
     * Hapus resource yang ditentukan dari penyimpanan.
     * 
     * @param \App\Models\Pinjaman $pinjaman
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pinjaman $pinjaman)
    {
        DB::transaction(function() use ($pinjaman) {
            $pinjaman->delete();
        });

        return redirect()->route('permintaan-pinjaman.index')->withSuccess('Berhasil Disimpan !');
    }
}
