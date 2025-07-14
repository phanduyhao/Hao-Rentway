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
        Schema::table('baidangs', function (Blueprint $table) {
            $table->boolean('isVip')->default(false); // Vip hay không
            $table->timestamp('expired_at')->nullable(); // Ngày hết hạn
            $table->string('age')->nullable(); // Ngày hết hạn
            $table->string('huongbancong')->nullable(); // Hướng nhà (Đông, Tây,...)

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
