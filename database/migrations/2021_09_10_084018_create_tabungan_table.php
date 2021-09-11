<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTabunganTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tabungan', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->unsignedMediumInteger('user_id');
            $table->unsignedTinyInteger('jenis_tabungan_id');
            $table->integer('jml_tabungan');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('jenis_tabungan_id')->references('id')->on('jenis_tabungan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tabungan');
    }
}
