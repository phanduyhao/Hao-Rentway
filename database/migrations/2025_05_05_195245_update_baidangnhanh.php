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
        Schema::table('baidangnhanh', function (Blueprint $table) {
            $table->string('title', 255)->after('name'); // Trường name kiểu VARCHAR(255)
            $table->string('slug', 255)->after('title'); // Trường name kiểu VARCHAR(255)
    
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
