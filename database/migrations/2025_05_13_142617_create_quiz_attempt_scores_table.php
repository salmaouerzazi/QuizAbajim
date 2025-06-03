<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuizAttemptScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz_attempt_scores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quiz_id');
            $table->unsignedInteger('child_id');
            $table->integer('score')->default(0);               // Score obtenu
            $table->integer('score_total')->default(0);         // Score maximum du quiz
            $table->timestamp('submitted_at')->nullable();      // Date de la tentative
            $table->timestamps();

            $table->foreign('quiz_id')->references('id')->on('quiz')->onDelete('cascade');
            $table->foreign('child_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quiz_attempt_scores');
    }
}
