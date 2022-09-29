<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatatanjadwalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catatanjadwal', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_angkatan')->unsigned()->index()->nullable();
            $table->foreign('id_angkatan')->references('id')->on('angkatan')->onDelete('cascade');
            $table->unsignedBigInteger('id_semesterkuliah')->unsigned()->index()->nullable();
            $table->foreign('id_semesterkuliah')->references('id')->on('semesterkuliah')->onDelete('cascade');
            $table->string('catatan')->nullable();
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
        Schema::dropIfExists('catatanjadwal');
    }
}
