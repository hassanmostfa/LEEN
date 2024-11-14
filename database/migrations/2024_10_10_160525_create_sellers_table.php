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
        Schema::create('sellers', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone')->nullable()->unique();
            $table->timestamp('phone_verified_at')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->string('request_status')->default('pending');
            $table->string('seller_logo')->nullable();
            $table->string('seller_banner')->nullable();
            $table->string('license')->nullable();
            $table->string('location');
            $table->string('request_rejection_reason')->nullable();
            $table->enum('service_type', ['in_house', 'at_headquarters']);
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
        Schema::dropIfExists('sellers');
    }
};
