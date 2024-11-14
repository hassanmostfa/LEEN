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
        Schema::create('studio_service_booking_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('studio_service_booking_id')->constrained('studio_services_bookings')->onDelete('cascade');
            $table->foreignId('service_id')->constrained('studio_services')->onDelete('cascade');
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
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
        Schema::dropIfExists('studio_service_booking_items');
    }
};
