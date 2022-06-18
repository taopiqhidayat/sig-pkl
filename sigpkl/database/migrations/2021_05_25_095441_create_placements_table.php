<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlacementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('placements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('nis', 10);
            $table->foreign('nis')
                ->references('nis')
                ->on('students')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->char('n_induk', 18)->nullable();
            $table->foreign('n_induk')
                ->references('n_induk')
                ->on('teachers')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('id_industri')->nullable();
            $table->foreign('id_industri')
                ->references('id')
                ->on('industries')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->date('mulai')->nullable();
            $table->date('sampai')->nullable();
            $table->time('waktu_masuk')->nullable();
            $table->time('waktu_keluar')->nullable();
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
        Schema::dropIfExists('placements');
    }
}
