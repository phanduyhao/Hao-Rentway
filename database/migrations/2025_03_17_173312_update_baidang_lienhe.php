<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up() {
        Schema::table('baidang_lienhes', function (Blueprint $table) {
            // Xóa khóa ngoại trước
            $table->dropForeign(['baidang_id']); 
            // Xóa cột baidang_id
            $table->dropColumn('baidang_id');
        });
    }

    public function down() {
        Schema::table('baidang_lienhes', function (Blueprint $table) {
            // Nếu muốn rollback, thêm lại cột baidang_id
            $table->foreignId('baidang_id')->constrained('baidangs')->onDelete('cascade');
        });
    }
};
