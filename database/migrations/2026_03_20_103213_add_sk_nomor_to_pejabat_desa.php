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
        Schema::table('pejabat_desa', function (Blueprint $table) {
            $table->string('sk_nomor', 100)->nullable()->after('nip');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pejabat_desa', function (Blueprint $table) {
            $table->dropColumn('sk_nomor');
        });
    }
};
