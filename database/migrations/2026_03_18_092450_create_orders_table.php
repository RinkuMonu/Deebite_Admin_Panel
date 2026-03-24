<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // روابط (Foreign Keys)
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('restaurant_id');
            $table->unsignedBigInteger('delivery_partner_id')->nullable();
            $table->unsignedBigInteger('address_id');

            // Pricing
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('delivery_fee', 10, 2)->default(0);
            $table->decimal('tax', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);

            // Status
            $table->enum('status', [
                'pending',
                'accepted',
                'preparing',
                'ready',
                'picked_up',
                'delivered',
                'cancelled'
            ])->default('pending');

            // Payment
            $table->enum('payment_status', [
                'pending',
                'paid',
                'failed'
            ])->default('pending');

            $table->string('payment_method')->default('COD'); // COD / Online

            $table->timestamps();

            // Optional Foreign Key Constraints (recommended)
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('restaurant_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('delivery_partner_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('address_id')->references('id')->on('address_book')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
