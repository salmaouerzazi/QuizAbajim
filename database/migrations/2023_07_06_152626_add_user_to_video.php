<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserToVideo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
         Schema::table('videos', function (Blueprint $table) {
            $table->integer('vues')->nullable();
            $table->integer('likes')->nullable();
        //         // $table->unsignedInteger('user_id');
        //      $table->foreign('user_id')
        //      ->references('id')
        //      ->on('users');
          });
    }
    public function down()
    {
        // Schema::table('videos', function (Blueprint $table) {
        //     $table->dropForeign('videos_user_id_foreign');
        // });
    }
}
