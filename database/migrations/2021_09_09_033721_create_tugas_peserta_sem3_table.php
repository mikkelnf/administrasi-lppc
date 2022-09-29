<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTugasPesertaSem3Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tugas_peserta_sem3', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_peserta')->unsigned()->index()->nullable();
            $table->foreign('id_peserta')->references('id')->on('peserta')->onDelete('cascade');
            $table->unsignedBigInteger('id_semesterkuliah')->unsigned()->index()->nullable();
            $table->foreign('id_semesterkuliah')->references('id')->on('semesterkuliah')->onDelete('cascade');
            $table->enum('tugas_1', ['Selesai', 'Belum Selesai'])->nullable();
            $table->enum('tugas_2', ['Selesai', 'Belum Selesai'])->nullable();
            $table->enum('tugas_3', ['Selesai', 'Belum Selesai'])->nullable();
            $table->enum('tugas_4', ['Selesai', 'Belum Selesai'])->nullable();
            $table->enum('tugas_5', ['Selesai', 'Belum Selesai'])->nullable();
            $table->enum('tugas_6', ['Selesai', 'Belum Selesai'])->nullable();
            $table->enum('tugas_7', ['Selesai', 'Belum Selesai'])->nullable();
            $table->enum('tugas_8', ['Selesai', 'Belum Selesai'])->nullable();
            $table->enum('tugas_9', ['Selesai', 'Belum Selesai'])->nullable();
            $table->enum('tugas_10', ['Selesai', 'Belum Selesai'])->nullable();
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
        Schema::dropIfExists('tugas_peserta_sem3');
    }
}
