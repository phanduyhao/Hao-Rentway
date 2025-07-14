<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 🔹 Kiểm tra và xóa khóa ngoại nếu tồn tại
        Schema::table('baidangs', function (Blueprint $table) {
            // Lấy danh sách khóa ngoại từ MySQL
            $foreignKeys = DB::select("SELECT CONSTRAINT_NAME 
                                       FROM information_schema.KEY_COLUMN_USAGE 
                                       WHERE TABLE_NAME = 'baidangs' 
                                       AND COLUMN_NAME = 'baidangchitiet_id'");

            if (!empty($foreignKeys)) {
                $fkName = $foreignKeys[0]->CONSTRAINT_NAME;
                $table->dropForeign($fkName); // Xóa khóa ngoại
            }

            // Xóa cột nếu có
            if (Schema::hasColumn('baidangs', 'baidangchitiet_id')) {
                $table->dropColumn('baidangchitiet_id');
            }
        });

        // 🔹 Xóa khóa ngoại và cột `baidang_id` trong `baidang_chitiets`
        Schema::table('baidang_chitiets', function (Blueprint $table) {
            if (Schema::hasColumn('baidang_chitiets', 'baidang_id')) {
                $table->dropForeign(['baidang_id']);
                $table->dropColumn('baidang_id');
            }
        });

        // 🔹 Thêm lại khóa ngoại vào `baidangs`
        Schema::table('baidangs', function (Blueprint $table) {
            $table->foreignId('baidangchitiet_id')->nullable()->constrained('baidang_chitiets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('baidangs', function (Blueprint $table) {
            $table->dropForeign(['baidangchitiet_id']);
            $table->dropColumn('baidangchitiet_id');
        });

        Schema::table('baidang_chitiets', function (Blueprint $table) {
            $table->foreignId('baidang_id')->constrained('baidangs')->onDelete('cascade');
        });
    }
};
