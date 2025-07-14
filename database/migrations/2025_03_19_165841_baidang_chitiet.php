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
        Schema::create('baidang_chitiets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('baidang_id')->constrained(table: 'baidangs')->onDelete('cascade'); 
            $table->integer('sophong')->nullable();
            $table->integer('sotang')->nullable(); 
            $table->integer('hoahong')->nullable(); 
            $table->integer('thangdatcoc')->nullable(); 
            $table->integer('thangtratruoc')->nullable(); 
            $table->enum('hopdong', ['1thang', '6thang', '1nam'])->nullable(); 
            $table->string('video')->unique()->nullable(); 
            $table->timestamps();
        });

        Schema::table('baidang_lienhes', function (Blueprint $table) {
            // Xóa khóa ngoại trước
            $table->enum('loailienhe', ['moigioi', 'daidien', 'chunha'])->nullable(); 
            $table->string('facebook')->nullable(); 
            $table->string('telegram')->nullable(); 

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
