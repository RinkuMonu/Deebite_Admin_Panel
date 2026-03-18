<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sponsorship_plans', function (Blueprint $table) {
            $table->id();

            $table->string('plan_name'); // Basic, Premium, Featured, super saver , etc...
            $table->text('description')->nullable();

            $table->decimal('price', 10, 2);
            $table->integer('duration_days'); // how long plan is active

            $table->string('placement')->nullable(); // search_result, home_top, category_page

            $table->integer('priority')->default(1); 
            // higher priority = show first in search results

            $table->boolean('status')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sponsorship_plans');
    }
};
