<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCallUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('call_users', function (Blueprint $table) {
   
   
            $table->id();
            $table->unsignedInteger('support_team_id');
            $table->unsignedInteger('user_id');
            $table->timestamps();

            //$table->foreign('support_team_id')->references('id')->on('support_teams')->onDelete('cascade');
           // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('call_users');
    }
}
