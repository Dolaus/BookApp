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
            Schema::create('bookings', function (Blueprint $table) {
                $table->id();
                $table->dateTime('start');
                $table->dateTime('end');
                $table->boolean('is_available');
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('table_id')->constrained('custom_tabls')->onDelete('cascade');
                $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
