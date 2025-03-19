<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAttToWebinars extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('webinars', function (Blueprint $table) {

            // $table->integer('category_id')->unsigned();

            // $table->integer('start_date');
            // $table->integer('duration')->after('start_date')->unsigned();
            // $table->string('seo_description',128)->nullable();
            // $table->string('video_demo')->nullable();
            // $table->integer('capacity')->unsigned();
            // $table->integer('price')->unsigned();
            // $table->text('description')->nullable();
            // $table->boolean('support')->default(false);

            // $table->boolean('partner_instructor')->default(false);
            // $table->boolean('subscribe')->default(false);
            // $table->text('message_for_reviewer')->nullable();

          //  $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('webinars', function (Blueprint $table) {
            //
        });
    }
}
