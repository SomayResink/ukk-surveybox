<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nis')->unique()->nullable()->after('email');
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null')->after('nis');
            $table->enum('role', ['super_admin', 'admin', 'student'])->default('student')->after('category_id');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nis', 'category_id', 'role']);
        });
    }
};
