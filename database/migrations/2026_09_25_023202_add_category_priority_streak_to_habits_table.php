<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('habits', function (Blueprint $table) {
            $table->string('category')->default('Personal')->after('description');
            $table->string('priority')->default('Medium')->after('category');
            $table->unsignedInteger('streak')->default(0)->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('habits', function (Blueprint $table) {
            $table->dropColumn(['category', 'priority', 'streak']);
        });
    }
};