<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatatanRaporPesertaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catatan_rapor_peserta', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_rapor_peserta')->unsigned()->index()->nullable();
            $table->foreign('id_rapor_peserta')->references('id')->on('rapor_peserta')->onDelete('cascade');
            $table->string('pertemuan_1')->nullable();
            $table->string('pertemuan_2')->nullable();
            $table->string('pertemuan_3')->nullable();
            $table->string('pertemuan_4')->nullable();
            $table->string('pertemuan_5')->nullable();
            $table->string('pertemuan_6')->nullable();
            $table->string('pertemuan_7')->nullable();
            $table->string('pertemuan_8')->nullable();
            $table->string('pertemuan_9')->nullable();
            $table->string('pertemuan_10')->nullable();
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
        Schema::dropIfExists('catatan_rapor_peserta');
    }
}
