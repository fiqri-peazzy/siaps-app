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
        Schema::create('otp_verifications', function (Blueprint $table) {
            $table->id();
            $table->string('identifier', 150);
            $table->enum('type', ['phone', 'email']);
            $table->enum('purpose', ['login', 'register', 'reset_password', 'verify']);
            $table->string('otp_code', 10);
            $table->enum('channel', ['whatsapp', 'sms', 'email'])->default('whatsapp');
            $table->boolean('is_used')->default(false);
            $table->tinyInteger('attempt_count')->default(0);
            $table->timestamp('expires_at');
            $table->timestamp('used_at')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();

            $table->index(['identifier', 'purpose']);
            $table->index('expires_at');
        });

        Schema::create('master_wilayah', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('master_wilayah')->onDelete('set null');
            $table->enum('tipe', ['desa', 'dusun', 'rw', 'rt']);
            $table->string('kode', 20)->nullable();
            $table->string('nama', 100);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('master_pekerjaan', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->string('kode', 20)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('master_agama', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 50);
            $table->boolean('is_active')->default(true);
        });

        Schema::create('master_jabatan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_jabatan', 100);
            $table->string('singkatan', 20)->nullable();
            $table->boolean('is_penandatangan')->default(false);
            $table->tinyInteger('urutan')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('pejabat_desa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('jabatan_id')->constrained('master_jabatan');
            $table->string('nip', 30)->nullable();
            $table->date('periode_mulai');
            $table->date('periode_selesai')->nullable();
            $table->string('tanda_tangan')->nullable();
            $table->string('stempel_path')->nullable();
            $table->boolean('is_aktif')->default(true);
            $table->timestamps();
        });

        Schema::create('priority_bobot', function (Blueprint $table) {
            $table->id();
            $table->string('kategori', 50);
            $table->string('kode', 50)->unique();
            $table->string('label', 100);
            $table->decimal('bobot', 5, 2)->default(0);
            $table->text('keterangan')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('priority_bobot');
        Schema::dropIfExists('pejabat_desa');
        Schema::dropIfExists('master_jabatan');
        Schema::dropIfExists('master_agama');
        Schema::dropIfExists('master_pekerjaan');
        Schema::dropIfExists('master_wilayah');
        Schema::dropIfExists('otp_verifications');
    }
};
