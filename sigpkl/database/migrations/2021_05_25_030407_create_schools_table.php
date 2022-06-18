<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schools', function (Blueprint $table) {
            $table->integer('id');
            $table->string('nama', 128);
            $table->string('provinsi');
            $table->string('kota');
            $table->string('alamat');
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->date('dft_mulai')->nullable();
            $table->date('dft_sampai')->nullable();
            $table->date('clk_mulai')->nullable();
            $table->date('clk_sampai')->nullable();
            $table->date('pkl_mulai')->nullable();
            $table->date('pkl_sampai')->nullable();
            $table->date('uji_mulai')->nullable();
            $table->date('uji_sampai')->nullable();
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
        Schema::dropIfExists('schools');
    }
}
