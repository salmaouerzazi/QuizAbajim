<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLivraisonCardReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('card_reservations', function (Blueprint $table) {
            $table->enum('livraison', ['Yes', 'No'])->default('No')->after('status');
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
            $table->dropColumn('livraison');
        });
    }
}
