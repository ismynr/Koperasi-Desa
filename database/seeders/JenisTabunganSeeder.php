<?php

namespace Database\Seeders;

use App\Models\JenisTabungan;
use Illuminate\Database\Seeder;

class JenisTabunganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        JenisTabungan::create([
            'jenis_tabungan' => 'Simpanan Pokok',
            'default_tabungan' => 500000,
            'n_bln_sekali' => 0
        ]);

        JenisTabungan::create([
            'jenis_tabungan' => 'Simpanan Wajib',
            'default_tabungan' => 500000,
            'n_bln_sekali' => 1
        ]);

        JenisTabungan::create([
            'jenis_tabungan' => 'Simpanan Sukarela',
            'default_tabungan' => 0,
            'n_bln_sekali' => 0
        ]);
    }
}
