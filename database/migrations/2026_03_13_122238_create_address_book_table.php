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
        Schema::create('address_book', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                    ->constrained()
                    ->cascadeOnDelete(); // delete addresses if user deleted

            $table->enum('address_type', ['home', 'office', 'work', 'other']);

            $table->text('address'); // full address text

            $table->decimal('longitude', 11, 8);
            $table->decimal('latitude', 10, 8);

            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('address_book');
    }
};
