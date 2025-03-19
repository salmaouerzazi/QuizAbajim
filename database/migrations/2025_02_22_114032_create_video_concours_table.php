<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideoConcoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('video_concours', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('concours_id'); // Use unsignedBigInteger
            $table->string('title')->nullable();
            $table->string('video_path');
            $table->text('description')->nullable();
            $table->integer('page')->nullable();
            $table->integer('numero_icon')->nullable();
            $table->unsignedInteger('user_id'); // Use unsignedBigInteger
            $table->integer('vues')->default(0);
            $table->integer('likes')->default(0);
            $table->enum('status', ['published', 'draft', 'archived'])->default('draft');
            $table->double('total_minutes_watched', 8, 2)->default(0);
            $table->timestamps();

            // Foreign Keys
            $table->foreign('concours_id')->references('id')->on('concours')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('video_concours');
    }
}
