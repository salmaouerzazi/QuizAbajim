<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscribeLevelByPrice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscribe_level_by_price', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('subscribe_id');
            $table->unsignedInteger('level_id');
            $table->float('price', 8, 2);  // Changed to float with 2 decimal points

            $table->foreign('subscribe_id')->references('id')->on('subscribes')->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('level_id')->references('id')->on('school_levels')->onDelete('cascade')->onUpdate('cascade');

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
        Schema::dropIfExists('subscribe_level_by_price');
    }
}
