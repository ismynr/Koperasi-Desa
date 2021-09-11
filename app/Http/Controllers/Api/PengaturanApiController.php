<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PengaturanRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class PengaturanApiController extends Controller
{
    public function show($key)
    {
        return DB::table('pengaturan')->where('key', $key)->first();
    }

    public function update(PengaturanRequest $request)
    {
        DB::beginTransaction();

        try {
            DB::table('pengaturan')->update([
                'key' => $request->key,
                'value' => $request->value,
            ]);

            DB::commit();
            return response()->json(['message' => 'Berhasil'], Response::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Gagal'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
