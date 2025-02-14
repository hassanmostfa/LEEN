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
        Schema::create('studio_services_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('studio_service_id')->constrained('studio_services')->onDelete('cascade');
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->foreignId('seller_id')->constrained('sellers')->onDelete('cascade');
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->date('date');
            $table->time('start_time');
            $table->string('payment_status')->default('unpaid');
            $table->string('booking_status')->default('pending');
            $table->decimal('paid_amount' , 8, 2);
            $table->string('request_rejection_reason')->nullable();
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
        Schema::dropIfExists('studio_services_bookings');
    }
};
