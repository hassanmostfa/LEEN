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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->constrained()->onDelete('cascade'); // Associate the coupon with the seller
            $table->string('code')->unique(); // Coupon code
            $table->integer('discount_value'); // Discount value
            $table->date('expires_at')->nullable(); // Expiration date
            $table->integer('usage_limit')->nullable(); // Max number of times coupon can be used
            $table->integer('usage_count')->default(0); // Number of times coupon has been used
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
        Schema::dropIfExists('coupons');
    }
};
