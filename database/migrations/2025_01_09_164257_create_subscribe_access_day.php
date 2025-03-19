<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscribeAccessDay extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscribe_access_day', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('subscribe_id'); // Foreign key to subscribe
            $table->integer('access_date');
            $table->timestamps();

            // Foreign key constraint (assuming there is a 'subscribes' table)
            $table->foreign('subscribe_id')->references('id')->on('subscribes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscribe_access_day');
    }
}
