<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AnggotaStoreRequest;
use App\Http\Requests\AnggotaUpdateRequest;
use App\Models\Anggota;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AnggotaController extends Controller
{
    /**
     * Menampilkan halaman utama dari anggota
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Anggota::doesntHave('user.tabungan')
                    ->orWhereHas('user.tabungan')
                    ->get();
            
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->editColumn('action', function($data) {
                        return $data->id;
                    })
                    ->make(true);
        }

        return view('admin.anggota.index');
    }

    /**
     * Menampilkan formulir untuk membuat resource baru
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.anggota.create');
    }

    /**
     * Simpan resource yang baru dibuat di penyimpanan.
     *
     * @param  \App\Http\Requests\AnggotaStoreRequest  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(AnggotaStoreRequest $request)
    {
        DB::transaction(function() use ($request) {

            $user = User::create([
                'email' => $request->email,
                'role' => '2', //anggota
                'password' => Hash::make($request->password),
            ]);

            Anggota::create([
                'user_id' => $user->id,
                'nama' => $request->nama,
                'jk' => $request->jk,
                'pekerjaan' => $request->pekerjaan,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
                'narek' => $request->narek,
                'norek' => $request->norek,
            ]);
        });

        return redirect()->route('anggota.index')->withSuccess('Berhasil Disimpan !');
    }

    /**
     * Menampiklan resource secara spesifik
     *
     * @param  \App\Models\Anggota  $anggota
     * 
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Anggota $anggota)
    {
        return view('admin.anggota.show', compact('anggota'));
    }

    /**
     * Perbarui resource yang ditentukan dalam penyimpanan.
     *
     * @param  \App\Http\Requests\AnggotaUpdateRequest  $request
     * @param  \App\Models\Anggota  $anggota
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(AnggotaUpdateRequest $request, Anggota $anggota)
    {
        DB::transaction(function() use ($request, $anggota) {

            $user = User::where('email', $request->email)->first();
            $user->email = $request->email;

            if($request->password != ''){
                $user->password = Hash::make($request->password);
            }

            $anggota->update([
                'nama' => $request->nama,
                'jk' => $request->jk,
                'pekerjaan' => $request->pekerjaan,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
                'narek' => $request->narek,
                'norek' => $request->norek,
            ]);

        });

        return redirect()->route('anggota.index')->withSuccess('Berhasil Disimpan !');
    }

    /**
     * Hapus resource yang ditentukan dari penyimpanan.
     *
     * @param  \App\Models\Anggota  $anggota
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroy(Anggota $anggota)
    {
        try {
            DB::beginTransaction();

            $anggota->delete();
            $anggota->user->delete();
            
            DB::commit();
            return redirect()->route('anggota.index')->withSuccess('Berhasil Disimpan !');

        } catch(QueryException $ex3) {
            DB::rollBack();

            if($ex3->getCode() === '23000') {
                return redirect()->route('anggota.index')->withErrors('Maaf, Tidak dapat menghapus, terdapat data lain yang berhubungan !');
            }
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('anggota.index')->withErrors('Maaf, gagal silahkan dicoba lagi !');
        } 
    }
}
