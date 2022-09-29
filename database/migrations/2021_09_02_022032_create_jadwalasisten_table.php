<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateJadwalasistenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jadwalasisten', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_semesterperiode')->unsigned()->index()->nullable();
            $table->foreign('id_semesterperiode')->references('id')->on('semesterperiode');
            $table->unsignedBigInteger('id_jadwalkursus')->unsigned()->index()->nullable();
            $table->foreign('id_jadwalkursus')->references('id')->on('jadwalkursus');
            $table->unsignedBigInteger('id_pertemuankursus')->unsigned()->index()->nullable();
            $table->foreign('id_pertemuankursus')->references('id')->on('pertemuankursus');
            $table->unsignedBigInteger('host')->unsigned()->index()->nullable();
            $table->foreign('host')->references('id')->on('user');
            $table->unsignedBigInteger('instruktur')->unsigned()->index()->nullable();
            $table->foreign('instruktur')->references('id')->on('user');
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
        Schema::dropIfExists('jadwalasisten');
    }
}
