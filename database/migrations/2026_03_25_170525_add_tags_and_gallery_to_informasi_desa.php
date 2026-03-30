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
        Schema::table('informasi_desa', function (Blueprint $table) {
            $table->string('tags')->nullable()->after('konten');
            $table->json('gallery')->nullable()->after('thumbnail');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('informasi_desa', function (Blueprint $table) {
            $table->dropColumn(['tags', 'gallery']);
        });
    }
};
