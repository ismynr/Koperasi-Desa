<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PengaturanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pengaturan')->insert([
            'key' => 'bunga_tabungan',
            'value' => '0.7'
        ],[
            'key' => 'bunga_simpanan',
            'value' => '1'
        ]);
    }
}
