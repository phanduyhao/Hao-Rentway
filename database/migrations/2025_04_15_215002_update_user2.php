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
            $table->string('link_zalo')->after('role'); 
            $table->string('link_tele')->after('link_zalo'); 
            $table->string('quoctich')->after('link_tele'); 
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
