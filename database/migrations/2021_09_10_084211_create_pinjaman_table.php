<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePinjamanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pinjaman', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->unsignedMediumInteger('user_id');
            $table->integer('jml_pinjaman');
            $table->tinyInteger('tenor');
            $table->integer('total_pinjaman');
            $table->text('tujuan_pinjaman');
            $table->enum('disetujui', [1, 0]);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pinjaman');
    }
}
