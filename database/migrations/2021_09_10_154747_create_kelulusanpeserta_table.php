<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKelulusanpesertaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kelulusanpeserta', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_peserta')->unsigned()->index()->nullable();
            $table->foreign('id_peserta')->references('id')->on('peserta')->onDelete('cascade');
            $table->bigInteger('kehadiran')->nullable();
            $table->bigInteger('kelengkapan_tugas')->nullable();
            $table->string('status_kelulusan')->nullable();
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
        Schema::dropIfExists('kelulusanpeserta');
    }
}
