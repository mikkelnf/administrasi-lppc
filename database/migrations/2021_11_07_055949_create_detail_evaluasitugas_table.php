<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateDetailEvaluasitugasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_evaluasitugas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_semesterkuliah')->unsigned()->index()->nullable();
            $table->foreign('id_semesterkuliah')->references('id')->on('semesterkuliah');
            $table->integer('nomor_tugas')->nullable();
            $table->string('nama_tugas')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_evaluasitugas');
    }
}
