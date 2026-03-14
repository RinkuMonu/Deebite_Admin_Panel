<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{    
    public function up(): void
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('number', 15); // Length limit de di
            $table->text('feedback')->nullable(); // Default '' se achha nullable hai
            $table->decimal('rating', 3, 1)->default(0.0); // E.g. 4.5, 5.0
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};
