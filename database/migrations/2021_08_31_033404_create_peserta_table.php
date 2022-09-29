<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePesertaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peserta', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('npm_peserta')->unique();
            $table->string('nama_peserta')->unique();
            $table->string('notelp_peserta');
            $table->string('email_peserta');
            $table->string('kelas_peserta');
            $table->unsignedBigInteger('id_angkatan');
            $table->foreign('id_angkatan')->references('id')->on('angkatan')->onDelete('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('id_jurusan');
            $table->foreign('id_jurusan')->references('id')->on('jurusan')->onDelete('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('id_asisten')->unsigned()->index()->nullable();
            $table->foreign('id_asisten')->references('id')->on('user');
            $table->rememberToken();
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
        Schema::dropIfExists('peserta');
    }
}
