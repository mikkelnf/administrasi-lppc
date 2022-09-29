<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvaluasitugasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluasitugas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_tugas')->unsigned()->index()->nullable();
            $table->foreign('id_tugas')->references('id')->on('detail_evaluasitugas')->onDelete('cascade');
            $table->unsignedBigInteger('id_peserta')->unsigned()->index()->nullable();
            $table->foreign('id_peserta')->references('id')->on('peserta')->onDelete('cascade');
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
        Schema::dropIfExists('evaluasitugas');
    }
}
