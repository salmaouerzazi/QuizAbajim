<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToCardReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('card_reservations', function (Blueprint $table) {
            // Add the 'status' column as a string (or use ENUM if you have predefined values)
            $table->enum('status', ['waiting', 'approved', 'rejected'])->default('waiting');
            
            // Add the 'enfant_id' column as an unsigned integer, referencing the 'enfants' table
            $table->unsignedInteger('enfant_id')->nullable();
            $table->foreign('enfant_id')->references('id')->on('users')->onDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('card_reservations', function (Blueprint $table) {
            //
        });
    }
}
