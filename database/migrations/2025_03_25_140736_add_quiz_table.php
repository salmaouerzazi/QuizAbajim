<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddQuizTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create quiz table
        Schema::create('quiz', function (Blueprint $table) {
            $table->id();
            $table->string('model_type')->nullable();
            $table->unsignedInteger('model_id')->nullable();
            $table->unsignedInteger('level_id');
            $table->unsignedInteger('material_id');
            $table->integer('question_count');
            $table->string('pdf_path');
            $table->unsignedInteger('teacher_id');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->softDeletes();

            $table->foreign('level_id')->references('id')->on('school_levels')->onDelete('cascade');
            $table->foreign('material_id')->references('id')->on('materials')->onDelete('cascade');
            $table->foreign('teacher_id')->references('id')->on('users')->onDelete('cascade');

        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
