<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRaporPesertaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rapor_peserta', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_peserta')->unsigned()->index()->nullable();
            $table->foreign('id_peserta')->references('id')->on('peserta')->onDelete('cascade');
            $table->unsignedBigInteger('id_semesterkuliah')->unsigned()->index()->nullable();
            $table->foreign('id_semesterkuliah')->references('id')->on('semesterkuliah')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rapor_peserta');
    }
}
