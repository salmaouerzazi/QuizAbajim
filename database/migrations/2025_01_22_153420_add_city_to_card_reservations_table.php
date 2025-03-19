<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCityToCardReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('card_reservations', function (Blueprint $table) {
            $table->enum('city', [
                'تونس', 'صفاقس', 'سوسة', 'التضامن', 'القيروان', 'قابس', 
                'بنزرت', 'أريانة', 'قفصة', 'المنستير', 'مدنين', 'نابل', 
                'القصرين', 'بن عروس', 'المهدية', 'سيدي بوزيد', 'جندوبة', 
                'قبلي', 'توزر', 'سليانة', 'باجة', 'زغوان', 'منوبة'
            ])->nullable()->after('address'); // Replace 'column_name' with the column after which you want to add 'city'
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('card_reservations', function (Blueprint $table) {
            $table->dropColumn('city');
        });
    }
}
