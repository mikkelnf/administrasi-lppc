<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSemesterperiodeAngkatanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('semesterperiode_angkatan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_angkatan')->unsigned()->index()->nullable();
            $table->foreign('id_angkatan')->references('id')->on('angkatan')->onDelete('cascade');
            $table->string('semester_1')->nullable();
            $table->string('semester_2')->nullable();
            $table->string('semester_3')->nullable();
            $table->string('semester_4')->nullable();
            $table->string('semester_5')->nullable();
            $table->string('semester_6')->nullable();
            $table->string('semester_7')->nullable();
            $table->string('semester_8')->nullable();
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
        Schema::dropIfExists('semesterperiode_angkatan');
    }
}
