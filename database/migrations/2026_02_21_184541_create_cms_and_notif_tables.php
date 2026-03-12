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
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('type', 150);
            $table->string('notifiable_type', 150);
            $table->unsignedBigInteger('notifiable_id');
            $table->json('data');
            $table->set('channel', ['database', 'whatsapp', 'email'])->default('database');
            $table->timestamp('read_at')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            $table->text('failure_reason')->nullable();
            $table->timestamps();

            $table->index(['notifiable_type', 'notifiable_id']);
            $table->index('read_at');
        });

        Schema::create('notification_templates', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 50)->unique();
            $table->enum('channel', ['whatsapp', 'email', 'database']);
            $table->string('subject', 200)->nullable();
            $table->text('body');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('informasi_desa', function (Blueprint $table) {
            $table->id();
            $table->enum('kategori', ['pengumuman', 'berita', 'profil', 'layanan', 'agenda']);
            $table->string('judul', 200);
            $table->string('slug', 200)->unique();
            $table->longText('konten');
            $table->string('thumbnail')->nullable();
            $table->boolean('is_published')->default(false);
            $table->boolean('is_pinned')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->integer('view_count')->default(0);
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['kategori', 'is_published']);
        });

        Schema::create('profil_desa', function (Blueprint $table) {
            $table->id();
            $table->string('nama_desa', 100);
            $table->string('kode_desa', 20)->nullable();
            $table->string('kecamatan', 100)->nullable();
            $table->string('kabupaten', 100)->nullable();
            $table->string('provinsi', 100)->nullable();
            $table->string('kode_pos', 10)->nullable();
            $table->text('alamat_kantor')->nullable();
            $table->string('telepon', 20)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('website', 150)->nullable();
            $table->string('logo_path')->nullable();
            $table->string('kop_surat_path')->nullable();
            $table->text('visi')->nullable();
            $table->text('misi')->nullable();
            $table->decimal('luas_wilayah', 10, 2)->nullable();
            $table->integer('jumlah_penduduk')->nullable();
            $table->timestamps();
        });

        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->string('action', 100);
            $table->string('model_type', 100)->nullable();
            $table->unsignedBigInteger('model_id')->nullable();
            $table->text('description')->nullable();
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index('user_id');
            $table->index(['model_type', 'model_id']);
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
        Schema::dropIfExists('profil_desa');
        Schema::dropIfExists('informasi_desa');
        Schema::dropIfExists('notification_templates');
        Schema::dropIfExists('notifications');
    }
};
