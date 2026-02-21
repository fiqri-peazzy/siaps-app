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
        Schema::create('jenis_surat', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 20)->unique();
            $table->string('nama', 150);
            $table->text('deskripsi')->nullable();
            $table->tinyInteger('base_priority')->default(5);
            $table->tinyInteger('sla_hari')->default(3);
            $table->string('template_path')->nullable();
            $table->string('nomor_format', 100)->nullable();
            $table->integer('counter_nomor')->default(0);
            $table->boolean('requires_verification')->default(true);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('jenis_surat_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jenis_surat_id')->constrained('jenis_surat')->onDelete('cascade');
            $table->string('field_key', 50);
            $table->string('field_label', 100);
            $table->enum('field_type', ['text', 'textarea', 'select', 'date', 'file', 'number', 'radio', 'checkbox']);
            $table->json('field_options')->nullable();
            $table->boolean('is_required')->default(true);
            $table->tinyInteger('urutan')->default(0);
            $table->string('placeholder', 150)->nullable();
            $table->string('validation_rules', 255)->nullable();

            $table->index('jenis_surat_id');
        });

        Schema::create('syarat_surat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jenis_surat_id')->constrained('jenis_surat')->onDelete('cascade');
            $table->string('nama_syarat', 150);
            $table->string('deskripsi', 255)->nullable();
            $table->boolean('is_required')->default(true);
            $table->integer('max_size_kb')->default(2048);
            $table->string('allowed_types', 100)->default('pdf,jpg,png');
        });

        Schema::create('penduduk', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 16)->unique();
            $table->string('no_kk', 16);
            $table->string('nama_lengkap', 150);
            $table->string('tempat_lahir', 100);
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->foreignId('agama_id')->nullable()->constrained('master_agama');
            $table->foreignId('pekerjaan_id')->nullable()->constrained('master_pekerjaan');
            $table->enum('status_perkawinan', ['belum_kawin', 'kawin', 'cerai_hidup', 'cerai_mati']);
            $table->enum('golongan_darah', ['A', 'B', 'AB', 'O', 'tidak_tahu'])->nullable();
            $table->string('kewarganegaraan', 10)->default('WNI');
            $table->enum('status_dalam_kk', ['kepala_keluarga', 'istri', 'anak', 'lainnya'])->nullable();
            $table->foreignId('rt_id')->nullable()->constrained('master_wilayah');
            $table->text('alamat_lengkap');
            $table->boolean('is_aktif')->default(true);
            $table->enum('status_penduduk', ['tetap', 'sementara', 'tinggal'])->default('tetap');
            $table->timestamps();

            $table->index('nik');
            $table->index('no_kk');
        });

        Schema::create('biodata_masyarakat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');
            $table->foreignId('penduduk_id')->nullable()->constrained('penduduk');
            $table->string('nik', 16);
            $table->string('nama_lengkap', 150);
            $table->string('tempat_lahir', 100);
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->foreignId('agama_id')->nullable()->constrained('master_agama');
            $table->foreignId('pekerjaan_id')->nullable()->constrained('master_pekerjaan');
            $table->enum('status_perkawinan', ['belum_kawin', 'kawin', 'cerai_hidup', 'cerai_mati']);
            $table->enum('golongan_darah', ['A', 'B', 'AB', 'O', 'tidak_tahu'])->nullable();
            $table->foreignId('rt_id')->nullable()->constrained('master_wilayah');
            $table->text('alamat_lengkap');
            $table->string('foto_ktp')->nullable();
            $table->string('foto_kk')->nullable();
            $table->boolean('is_disabilitas')->default(false);
            $table->string('jenis_disabilitas', 100)->nullable();
            $table->boolean('is_hamil')->default(false);
            $table->text('catatan_khusus')->nullable();
            $table->enum('verification_status', ['unverified', 'pending', 'verified', 'rejected'])->default('unverified');
            $table->foreignId('verified_by')->nullable()->constrained('users');
            $table->timestamp('verified_at')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->timestamps();

            $table->index('nik');
        });

        Schema::create('pengajuan_surat', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pengajuan', 30)->unique();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('biodata_id')->constrained('biodata_masyarakat');
            $table->foreignId('jenis_surat_id')->constrained('jenis_surat');
            $table->text('keperluan')->nullable();
            $table->json('field_data');
            $table->text('catatan_pemohon')->nullable();
            $table->decimal('priority_score', 8, 2)->default(0);
            $table->json('priority_breakdown')->nullable();
            $table->integer('antrian_number')->nullable();
            $table->date('antrian_date')->nullable();
            $table->enum('status', ['draft', 'submitted', 'queued', 'in_process', 'need_revision', 'validated', 'approved', 'rejected', 'ready', 'completed', 'cancelled'])->default('draft');
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('queued_at')->nullable();
            $table->timestamp('process_started_at')->nullable();
            $table->timestamp('validated_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('ready_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->string('nomor_surat', 100)->nullable();
            $table->string('surat_path')->nullable();
            $table->timestamp('surat_generated_at')->nullable();
            $table->foreignId('handled_by_admin')->nullable()->constrained('users');
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->boolean('is_priority_recalculated')->default(false);
            $table->timestamp('last_priority_update')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
            $table->index(['priority_score']);
            $table->index('antrian_date');
            $table->index(['user_id', 'status']);
        });

        Schema::create('pengajuan_dokumen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuan_id')->constrained('pengajuan_surat')->onDelete('cascade');
            $table->foreignId('syarat_id')->nullable()->constrained('syarat_surat');
            $table->string('nama_dokumen', 150);
            $table->string('original_filename');
            $table->string('file_path');
            $table->integer('file_size');
            $table->string('mime_type', 100);
            $table->enum('upload_status', ['uploaded', 'verified', 'rejected'])->default('uploaded');
            $table->string('rejection_note')->nullable();
            $table->timestamp('uploaded_at')->useCurrent();
        });

        Schema::create('pengajuan_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuan_id')->constrained('pengajuan_surat')->onDelete('cascade');
            $table->string('from_status', 30)->nullable();
            $table->string('to_status', 30);
            $table->decimal('priority_score_saat_itu', 8, 2)->nullable();
            $table->foreignId('actor_id')->nullable()->constrained('users');
            $table->string('actor_role', 20)->nullable();
            $table->text('catatan')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index('pengajuan_id');
        });

        Schema::create('pengajuan_revisi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuan_id')->constrained('pengajuan_surat')->onDelete('cascade');
            $table->foreignId('diminta_oleh')->constrained('users');
            $table->text('catatan_revisi');
            $table->json('field_bermasalah')->nullable();
            $table->timestamp('deadline_revisi')->nullable();
            $table->enum('status', ['pending', 'revised', 'expired'])->default('pending');
            $table->timestamp('revised_at')->nullable();
            $table->timestamps();
        });

        Schema::create('antrian_harian', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->foreignId('jenis_surat_id')->constrained('jenis_surat');
            $table->foreignId('pengajuan_id')->constrained('pengajuan_surat');
            $table->integer('nomor_antrian');
            $table->decimal('priority_score', 8, 2);
            $table->enum('status', ['waiting', 'processing', 'done', 'skipped'])->default('waiting');
            $table->time('estimated_time')->nullable();

            $table->unique(['tanggal', 'jenis_surat_id', 'nomor_antrian'], 'uq_antrian');
            $table->index(['tanggal', 'status']);
        });

        Schema::create('surat_terbit', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuan_id')->unique()->constrained('pengajuan_surat');
            $table->string('nomor_surat', 100)->unique();
            $table->foreignId('jenis_surat_id')->constrained('jenis_surat');
            $table->string('nama_pemohon', 150);
            $table->string('nik_pemohon', 16);
            $table->foreignId('pejabat_id')->constrained('pejabat_desa');
            $table->date('tanggal_terbit');
            $table->date('berlaku_sampai')->nullable();
            $table->string('file_path');
            $table->string('file_hash', 64)->nullable();
            $table->string('qr_code_path')->nullable();
            $table->string('qr_token', 100)->nullable()->unique();
            $table->integer('download_count')->default(0);
            $table->timestamp('last_downloaded_at')->nullable();
            $table->timestamps();

            $table->index('qr_token');
            $table->index('nomor_surat');
        });

        Schema::create('nomor_surat_counter', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jenis_surat_id')->constrained('jenis_surat');
            $table->year('tahun');
            $table->tinyInteger('bulan');
            $table->integer('counter')->default(0);

            $table->unique(['jenis_surat_id', 'tahun', 'bulan'], 'uq_counter');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nomor_surat_counter');
        Schema::dropIfExists('surat_terbit');
        Schema::dropIfExists('antrian_harian');
        Schema::dropIfExists('pengajuan_revisi');
        Schema::dropIfExists('pengajuan_history');
        Schema::dropIfExists('pengajuan_dokumen');
        Schema::dropIfExists('pengajuan_surat');
        Schema::dropIfExists('biodata_masyarakat');
        Schema::dropIfExists('penduduk');
        Schema::dropIfExists('syarat_surat');
        Schema::dropIfExists('jenis_surat_fields');
        Schema::dropIfExists('jenis_surat');
    }
};
