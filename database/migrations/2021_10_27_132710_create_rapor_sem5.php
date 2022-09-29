<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRaporSem5 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rapor_sem5', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_semesterkuliah')->unsigned()->index()->nullable();
            $table->foreign('id_semesterkuliah')->references('id')->on('semesterkuliah')->onDelete('cascade');
            $table->integer('nomor_pertemuan')->nullable();
            $table->string('nama_pertemuan')->nullable();
            $table->string('nama_tugas')->nullable();
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
        Schema::dropIfExists('rapor_sem5');
    }
}
