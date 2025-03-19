<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnfantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enfant', function (Blueprint $table) {
            $table->id();
            $table->string('Nom',40);
            $table->string('prenom',40);
            $table->enum('sexe', ['Garçon','Fille']);
            $table->string('path',40);
            $table->unsignedInteger('level_id');
            $table->unsignedInteger('parent_id');
          
            $table->foreign('parent_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('level_id')->references('id')->on('school_levels')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enfant');
    }
}
