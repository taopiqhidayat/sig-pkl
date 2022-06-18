<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePresentationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presentations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('nis', 10);
            $table->foreign('nis')
                ->references('nis')
                ->on('students')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('presentasi');
            $table->integer('nilai_a')->nullable();
            $table->integer('nilai_b')->nullable();
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
        Schema::dropIfExists('presentations');
    }
}
