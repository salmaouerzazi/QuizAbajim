<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ForeignKeys1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /* Schema::table('users', function (Blueprint $table) {
        
            $table->foreign('school_id')
                ->references('id')
                ->on('schools');
           
           
         });
        Schema::table('sectionsmat', function (Blueprint $table) {
           
            $table->foreign('level_id')
                ->references('id')
                ->on('school_levels');
            
        });
        Schema::table('speciality', function (Blueprint $table) {
            
            $table->foreign('section_id')
                ->references('id')
                ->on('sectionsmat');
                
        });
        Schema::table('material', function (Blueprint $table) {

            $table->foreign('section_id')
                ->references('id')
                ->on('sectionsmat');
        });*/
      
    }

    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
  /*  public function down()
    {
         Schema::table('users', function(Blueprint $table) {
             $table->dropForeign('users_school_id_foreign');
         });
         Schema::table('sectionsmat', function(Blueprint $table) {
            $table->dropForeign('sectionsmat_level_school_id_foreign');
         });
         Schema::table('speciality', function(Blueprint $table) {
             $table->dropForeign('speciality_section_id_foreign');
         });
         Schema::table('material', function(Blueprint $table) {
             $table->dropForeign('material_section_id_foreign');
         });
       
      
    }*/
}
