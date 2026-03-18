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
    
        Schema::create('vendor_sponsorships', function (Blueprint $table) {
            $table->id();

            $table->foreignId('vendor_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('plan_id')
                ->constrained('sponsorship_plans')
                ->cascadeOnDelete();

            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_sponsorships');
    }
};
