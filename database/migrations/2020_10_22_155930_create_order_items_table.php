<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('order_id')->unsigned();
            //  morphic
            $table->string('model_type'); // App\Models\Webinar, App\Models\Meeting, App\Models\Ticket
            $table->integer('model_id')->unsigned(); // webinar_id, meeting_id, ticket_id

            $table->integer('amount')->unsigned()->nullable();
            $table->integer('tax')->unsigned()->nullable();
            $table->integer('commission')->unsigned()->nullable();
            $table->integer('discount')->unsigned()->nullable();
            $table->integer('total_amount')->unsigned();
            $table->integer('created_at')->unsigned()->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_items');
    }
}
