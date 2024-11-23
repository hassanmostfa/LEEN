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
        Schema::create('employees_timetables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade'); // Employee link
            $table->foreignId('seller_id')->constrained('sellers')->onDelete('cascade');    // Seller link
            $table->date('date'); // Booking date
            $table->time('start_time'); // Start time
            $table->string('status')->default('available'); // Status (e.g., booked, available)
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
        Schema::dropIfExists('employees_timetables');
    }
};
