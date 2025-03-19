<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UpdateStatusEnumInCardReservationsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::statement("ALTER TABLE card_reservations MODIFY COLUMN status ENUM('waiting', 'approved', 'rejected', 'in_delivery', 'delivered') NOT NULL DEFAULT 'waiting'");
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::statement("ALTER TABLE card_reservations MODIFY COLUMN status ENUM('waiting', 'approved', 'rejected') NOT NULL DEFAULT 'waiting'");
    }
}
