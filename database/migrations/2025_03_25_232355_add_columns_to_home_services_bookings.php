<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('home_services_bookings', function (Blueprint $table) {
            $table->decimal('copoun_discount', 8, 2)->default(0)->after('paid_amount');
            $table->decimal('service_discount', 8, 2)->default(0)->after('copoun_discount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('home_services_bookings', function (Blueprint $table) {
            //
        });
    }
};
