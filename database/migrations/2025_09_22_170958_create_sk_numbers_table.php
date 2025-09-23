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
        Schema::create('sk_numbers', function (Blueprint $table) {
            $table->id();
            $table->string('sk_number')->unique();
            $table->date('date');
            $table->boolean('is_verified')->default(false);
            $table->timestamp('verified_at')->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sk_numbers');
    }
};
