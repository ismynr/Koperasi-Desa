<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PengaturanRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class PengaturanController extends Controller
{
    /**
     * Menampilkan halaman utama
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pengaturan = DB::table('pengaturan');

        return view('admin.pengaturan.index', compact('pengaturan'));
    }

    /**
     * Perbarui resource yang ditentukan dalam penyimpanan.
     * 
     * @param \App\Http\Requests\PengaturanRequest $request
     * @param mixed $id
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(PengaturanRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            DB::table('pengaturan')->where('key', $id)->update([
                'value' => $request->value,
            ]);

            DB::commit();
            return redirect()->route('pengaturan.index')->withSuccess('Berhasil Disimpan !');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('pengaturan.index')->withErrors('Gagal !');
        }
    }
}
