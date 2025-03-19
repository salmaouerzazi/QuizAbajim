<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ForeingnKeys2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*Schema::table('users', function (Blueprint $table) {
        
            $table->foreign('school_id')
                ->references('id')
                ->on('schools');
                $table->foreign('level_id')
                ->references('id')
                ->on('school_levels');
                $table->foreign('option_id')
                ->references('id')
                ->on('options');
           
           
         });*/
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
