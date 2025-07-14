<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    // ALTER TABLE `provinces` ADD `country` ENUM('Vietnam', 'Philippines', 'Thailand') NOT NULL DEFAULT 'Vietnam' AFTER `id`;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Thêm trường code vào bảng provinces
        Schema::table('provinces', function (Blueprint $table) {
            $table->enum('country', ['Vietnam', 'Philippines', 'Thailand'])->default('Vietnam')->after('id'); // Quốc gia
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Xóa trường code khỏi bảng provinces
        Schema::table('provinces', function (Blueprint $table) {
            $table->dropColumn('country');
        });
    }
};
