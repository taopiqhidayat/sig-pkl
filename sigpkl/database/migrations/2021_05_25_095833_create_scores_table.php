<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('nis', 10);
            $table->foreign('nis')
                ->references('nis')
                ->on('students')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->float('nilai_absensi')->nullable();
            $table->float('nilai_tugas')->nullable();
            $table->float('nilai_laporan')->nullable();
            $table->float('nilai_presentasi')->nullable();
            $table->integer('nisik_indu', 3)->nullable();
            $table->integer('nidis_indu', 3)->nullable();
            $table->integer('nitrm_indu', 3)->nullable();
            $table->integer('niker_indu', 3)->nullable();
            $table->float('nilai_pemlapangan')->nullable();
            $table->float('nilai_akhir', 6)->nullable();
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
        Schema::dropIfExists('scores');
    }
}
