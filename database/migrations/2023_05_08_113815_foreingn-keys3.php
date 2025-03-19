<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ForeingnKeys3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*Schema::table('manuels', function (Blueprint $table) {

                 $table->foreign('material_id')
                    ->references('id')
                    ->on('materials')
                     ->onDelete('cascade')
                    ->onUpdate('cascade');
             });
             Schema::table('documents', function (Blueprint $table) {

                $table->foreign('manuel_id')
                    ->references('id')
                    ->on('manuels')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            });
            Schema::table('videos', function (Blueprint $table) {
    
                $table->foreign('manuel_id')
                    ->references('id')
                    ->on('manuels')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       /* Schema::table('manuels', function(Blueprint $table) {
             $table->dropForeign('manuels_material_id_foreign');
             });
        Schema::table('documents', function(Blueprint $table) {
            $table->dropForeign('documents_manuel_id_foreign');
        });
        Schema::table('videos', function(Blueprint $table) {
            $table->dropForeign('videos_manuel_id_foreign');
        });*/
    }
}
