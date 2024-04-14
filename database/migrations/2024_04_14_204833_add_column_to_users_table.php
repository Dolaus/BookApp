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
        Schema::table('users', function (Blueprint $table) {
            $table->string('back_img_url')->nullable();
            $table->string('table_img_url')->nullable();
            $table->string('from_time')->nullable();
            $table->string('to_time')->nullable();
            $table->integer('interval')->nullable()->default(60);
            $table->string('site_name')->nullable()->default('Your shop');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('from_time');
            $table->dropColumn('to_time');
            $table->dropColumn('back_img_url');
            $table->dropColumn('table_img_url');
            $table->dropColumn('site_name');
            $table->dropColumn('interval');
        });
    }
};
