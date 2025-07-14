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
        Schema::table('addresses', function (Blueprint $table) {
            $table->boolean('is_custom')->nullable(); 
        });
        Schema::table('wards', function (Blueprint $table) {
            $table->boolean('is_custom')->nullable(); 
        });
        Schema::table('districts', function (Blueprint $table) {
            $table->boolean('is_custom')->nullable(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
