<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('baidangnhanh', function (Blueprint $table) {
            $table->id(); // Tạo trường ID tự động tăng
            $table->string('name', 255); // Trường name kiểu VARCHAR(255)
            $table->string('phone', 15); // Trường phone kiểu VARCHAR(15)
            $table->string('email', 255)->nullable(); // Trường email kiểu VARCHAR(255), có thể null
            $table->string('address', 500)->nullable(); // Trường address kiểu VARCHAR(500), có thể null
            $table->json('images')->nullable(); // Trường images kiểu JSON, có thể null
            $table->text('description')->nullable(); // Trường description kiểu TEXT, có thể null
            $table->timestamps(); // Tạo 2 trường created_at và updated_at
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('baidangnhanh');
    }
};
