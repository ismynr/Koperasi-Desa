<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CraeteAngsuranPinjamanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('angsuran_pinjaman', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->unsignedInteger('pinjaman_id');
            $table->tinyInteger('angsuran_ke');
            $table->integer('jml_angsuran');
            $table->timestamps();

            $table->foreign('pinjaman_id')->references('id')->on('pinjaman');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('angsuran_pinjaman');
    }
}
