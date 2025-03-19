<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->integer('card_key');
            $table->string('reference');
            $table->enum('status', ['active', 'inactive']);
            $table->unsignedInteger('level_id');
            $table->unsignedInteger('subscribe_id')->nullable();
            $table->integer('expires_in');
            $table->boolean('is_used')->default(false);
            $table->boolean('is_printed')->default(false);
            $table->unsignedBigInteger('created_at');
            $table->unsignedBigInteger('updated_at');

            $table->foreign('level_id')->references('id')->on('school_levels')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('subscribe_id')->references('id')->on('subscribes')->onDelete('cascade')->onUpdate('cascade');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cards');
    }
}
