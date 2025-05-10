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

            // Clé étrangère vers quiz
            $table->unsignedBigInteger('quiz_id');
            $table->foreign('quiz_id')->references('id')->on('quiz')->onDelete('cascade');

            // Clé étrangère vers l'enfant
            $table->unsignedBigInteger('child_id');
            $table->foreign('child_id')->references('id')->on('users')->onDelete('cascade');

            // Score obtenu et date de soumission
            $table->integer('score')->nullable();
            $table->timestamp('submitted_at')->nullable();

            // À la fin uniquement
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
        Schema::dropIfExists('quiz_submissions');
    }
}
