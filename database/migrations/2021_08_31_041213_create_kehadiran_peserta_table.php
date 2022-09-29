<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKehadiranPesertaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kehadiran_peserta', function (Blueprint $table) {
            $table->foreignId('id_peserta');
            $table->foreignId('id_semesterkuliah');
            $table->enum('pertemuan_1', ['Hadir', 'Absen'])->nullable();
            $table->enum('pertemuan_2', ['Hadir', 'Absen'])->nullable();
            $table->enum('pertemuan_3', ['Hadir', 'Absen'])->nullable();
            $table->enum('pertemuan_4', ['Hadir', 'Absen'])->nullable();
            $table->enum('pertemuan_5', ['Hadir', 'Absen'])->nullable();
            $table->enum('pertemuan_6', ['Hadir', 'Absen'])->nullable();
            $table->enum('pertemuan_7', ['Hadir', 'Absen'])->nullable();
            $table->enum('pertemuan_8', ['Hadir', 'Absen'])->nullable();
            $table->enum('pertemuan_9', ['Hadir', 'Absen'])->nullable();
            $table->enum('pertemuan_10', ['Hadir', 'Absen'])->nullable();
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
        Schema::dropIfExists('kehadiran_peserta');
    }
}
