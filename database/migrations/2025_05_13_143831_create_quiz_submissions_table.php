<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuizSubmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz_submissions', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('quiz_id');
            $table->unsignedInteger('child_id');
            $table->unsignedBigInteger('attempt_id');
            $table->unsignedBigInteger('question_id'); 
            $table->unsignedBigInteger('answer_id')->nullable();     // Pour QCM ou binaire
            $table->boolean('is_valid')->default(false); 
            $table->boolean('is_boolean_question')->default(false); // Pour savoir si c’est Vrai/Faux
            $table->json('arrow_mapping')->nullable(); //Pour les questions arrow (matching par flèches)

            $table->timestamps();

            $table->foreign('quiz_id')->references('id')->on('quiz')->onDelete('cascade');
            $table->foreign('child_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('attempt_id')->references('id')->on('quiz_attempt_scores')->onDelete('cascade');
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
            $table->foreign('answer_id')->references('id')->on('answers')->onDelete('set null');
        });
    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quiz_submissions');
    }
}
