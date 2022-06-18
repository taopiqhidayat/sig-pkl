<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('nis', 10);
            $table->foreign('nis')
                ->references('nis')
                ->on('students')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('id_kuis');
            $table->foreign('id_kuis')
                ->references('id')
                ->on('quizzes')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('id_tanyaan');
            $table->foreign('id_tanyaan')
                ->references('id')
                ->on('enigmas')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('id_pilihan');
            $table->foreign('id_pilihan')
                ->references('id')
                ->on('choices')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->boolean('dipilih');
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
        Schema::dropIfExists('answers');
    }
}
