<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('card_reservations', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Name of the person reserving the card
            $table->string('address'); // Address of the person
            $table->unsignedInteger('user_id'); // Foreign key reference to the user
            $table->unsignedInteger('level_id'); // Foreign key reference to the level of the child (or card type)
            $table->timestamps(); // Created at and updated at timestamps

            // Add foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Ensure user exists
            $table->foreign('level_id')->references('id')->on('school_levels')->onDelete('cascade'); // Ensure level exists
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('card_reservations');
    }
}
