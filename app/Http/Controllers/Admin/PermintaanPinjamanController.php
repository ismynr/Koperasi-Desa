<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pinjaman;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class PermintaanPinjamanController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Pinjaman::class, 'pinjaman');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Pinjaman::where('disetujui', '0')->get();
            
            return Datatables::of($data)
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

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Pinjaman $pinjaman)
    {
        //
    }

    public function edit(Pinjaman $pinjaman)
    {
        //
    }

    public function update(Request $request, Pinjaman $pinjaman)
    {
        DB::transaction(function() use ($pinjaman) {

            $pinjaman->update([
                'disetujui' => '1'
            ]);

        });

        return redirect()->route('permintaan-pinjaman.index')->withSuccess('Berhasil Disimpan !');
    }

    public function destroy(Pinjaman $pinjaman)
    {
        DB::transaction(function() use ($pinjaman) {
            $pinjaman->delete();
        });

        return redirect()->route('permintaan-pinjaman.index')->withSuccess('Berhasil Disimpan !');
    }
}
