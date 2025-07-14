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
        Schema::create('baidang_lienhes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('baidang_id')->constrained('baidangs')->onDelete('cascade');
            $table->string('agent_name')->nullable(); // Tên môi giới
            $table->string('phone')->nullable(); // Số điện thoại
            $table->string('email')->nullable(); // Email
            $table->string('zalo_link')->nullable(); // Link Zalo
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('baidang_lienhes');
    }
};
