<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('n_induk', 18);
            $table->foreign('n_induk')
                ->references('n_induk')
                ->on('teachers')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('id_industri');
            $table->foreign('id_industri')
                ->references('id')
                ->on('industries')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('kondisi_siswa');
            $table->string('kondisi_industri');
            $table->string('keluhan_siswa')->nullable();
            $table->string('keluhan_industri')->nullable();
            $table->string('kinerja_siswa');
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
        Schema::dropIfExists('visits');
    }
}
