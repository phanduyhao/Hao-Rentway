<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Thêm trường code vào bảng provinces
        Schema::table('provinces', function (Blueprint $table) {
            $table->string('code')->unique()->after('name');
        });

        // Thêm trường code vào bảng districts
        Schema::table('districts', function (Blueprint $table) {
            $table->string('code')->after('name');
        });

        // Thêm trường code vào bảng wards
        Schema::table('wards', function (Blueprint $table) {
            $table->string('code')->after('name');
        });

        // Thêm trường latitude và longitude vào bảng addresses
        Schema::table('addresses', function (Blueprint $table) {
            $table->decimal('latitude', 10, 8)->nullable()->after('ward_id');
            $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
        });
    }

    public function down()
    {
        // Xóa trường code khỏi bảng provinces
        Schema::table('provinces', function (Blueprint $table) {
            $table->dropColumn('code');
        });

        // Xóa trường code khỏi bảng districts
        Schema::table('districts', function (Blueprint $table) {
            $table->dropColumn('code');
        });

        // Xóa trường code khỏi bảng wards
        Schema::table('wards', function (Blueprint $table) {
            $table->dropColumn('code');
        });

        // Xóa trường latitude và longitude khỏi bảng addresses
        Schema::table('addresses', function (Blueprint $table) {
            $table->dropColumn(['latitude', 'longitude']);
        });
    }
};