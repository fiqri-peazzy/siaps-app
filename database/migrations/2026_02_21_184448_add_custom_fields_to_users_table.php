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
            $table->string('phone', 20)->unique()->nullable()->after('email');
            $table->string('username', 50)->unique()->nullable()->after('phone');
            $table->enum('role', ['admin', 'kepala_desa', 'masyarakat'])->default('masyarakat')->after('password');
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active')->after('role');
            $table->timestamp('phone_verified_at')->nullable()->after('email_verified_at');
            $table->string('avatar')->nullable()->after('phone_verified_at');
            $table->timestamp('last_login_at')->nullable()->after('avatar');
            $table->string('last_login_ip', 45)->nullable()->after('last_login_at');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone',
                'username',
                'role',
                'status',
                'phone_verified_at',
                'avatar',
                'last_login_at',
                'last_login_ip',
                'deleted_at'
            ]);
        });
    }
};
