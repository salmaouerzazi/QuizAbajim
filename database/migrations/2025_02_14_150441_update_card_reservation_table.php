<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCardReservationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('card_reservations', function (Blueprint $table) {
            if (Schema::hasColumn('card_reservations', 'livraison')) {
                $table->dropColumn('livraison');
            }

            if (!Schema::hasColumn('card_reservations', 'rejection_note')) {
                $table->text('rejection_note')->nullable()->after('status');
            }
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
            if (Schema::hasColumn('card_reservations', 'rejection_note')) {
                $table->dropColumn('rejection_note');
            }
        });
    }
}
