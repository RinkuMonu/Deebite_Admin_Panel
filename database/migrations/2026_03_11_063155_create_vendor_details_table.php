<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{    
    public function up(): void
    {
        Schema::create('vendor_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('shop_name')->nullable();
            $table->string('profile_photo')->nullable();
            $table->string('document_type')->nullable()->comment('Aadhar, PAN, FSSAI');
            $table->string('document_file')->nullable();
            $table->string('fssai_number')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vendor_details');
    }
};
