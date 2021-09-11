<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PengaturanRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class PengaturanController extends Controller
{
    public function index()
    {
        $pengaturan = DB::table('pengaturan');

        return view('admin.pengaturan.index', compact('pengaturan'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

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

    public function destroy($id)
    {
        //
    }
}
