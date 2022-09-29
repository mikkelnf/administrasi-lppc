<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsistenpenilaiRaporPesertaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asistenpenilai_rapor_peserta', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_rapor_peserta')->unsigned()->index()->nullable();
            $table->foreign('id_rapor_peserta')->references('id')->on('rapor_peserta')->onDelete('cascade');
            $table->unsignedBigInteger('pertemuan_1')->unsigned()->index()->nullable();
            $table->foreign('pertemuan_1')->references('id')->on('user')->onDelete('cascade');
            $table->unsignedBigInteger('pertemuan_2')->unsigned()->index()->nullable();
            $table->foreign('pertemuan_2')->references('id')->on('user')->onDelete('cascade');
            $table->unsignedBigInteger('pertemuan_3')->unsigned()->index()->nullable();
            $table->foreign('pertemuan_3')->references('id')->on('user')->onDelete('cascade');
            $table->unsignedBigInteger('pertemuan_4')->unsigned()->index()->nullable();
            $table->foreign('pertemuan_4')->references('id')->on('user')->onDelete('cascade');
            $table->unsignedBigInteger('pertemuan_5')->unsigned()->index()->nullable();
            $table->foreign('pertemuan_5')->references('id')->on('user')->onDelete('cascade');
            $table->unsignedBigInteger('pertemuan_6')->unsigned()->index()->nullable();
            $table->foreign('pertemuan_6')->references('id')->on('user')->onDelete('cascade');
            $table->unsignedBigInteger('pertemuan_7')->unsigned()->index()->nullable();
            $table->foreign('pertemuan_7')->references('id')->on('user')->onDelete('cascade');
            $table->unsignedBigInteger('pertemuan_8')->unsigned()->index()->nullable();
            $table->foreign('pertemuan_8')->references('id')->on('user')->onDelete('cascade');
            $table->unsignedBigInteger('pertemuan_9')->unsigned()->index()->nullable();
            $table->foreign('pertemuan_9')->references('id')->on('user')->onDelete('cascade');
            $table->unsignedBigInteger('pertemuan_10')->unsigned()->index()->nullable();
            $table->foreign('pertemuan_10')->references('id')->on('user')->onDelete('cascade');
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
        Schema::dropIfExists('asistenpenilai_rapor_peserta');
    }
}
