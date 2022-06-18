<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('nis', 10);
            $table->foreign('nis')
                ->references('nis')
                ->on('students')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->char('pembimbing');
            $table->foreign('pembimbing')
                ->references('n_induk')
                ->on('teachers')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->char('penguji')->nullable();
            $table->foreign('penguji')
                ->references('n_induk')
                ->on('teachers')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->date('tanggal')->nullable();
            $table->time('waktu')->nullable();
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
        Schema::dropIfExists('tests');
    }
}
