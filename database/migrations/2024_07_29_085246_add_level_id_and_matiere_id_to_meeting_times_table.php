<?php




use Illuminate\Database\Migrations\Migration;

use Illuminate\Database\Schema\Blueprint;

use Illuminate\Support\Facades\Schema;

class AddLevelIdAndMatiereIdToMeetingTimesTable extends Migration

{

    /**

     * Run the migrations.

     *

     * @return void

     */

    public function up()

    {

        Schema::table('meeting_times', function (Blueprint $table) {

            $table->unsignedInteger('level_id')->nullable();
            $table->unsignedInteger('matiere_id')->nullable();
            //

            $table->foreign('level_id')->references('id')->on('school_levels')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('matiere_id')->references('id')->on('materials')->onDelete('cascade')->onUpdate('cascade');

        });

    }




    /**

     * Reverse the migrations.

     *

     * @return void

     */

    public function down()

    {

        Schema::table('meeting_times', function (Blueprint $table) {

            //

        });

    }

}
