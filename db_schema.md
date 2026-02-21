# Database Schema - Sistem Informasi Desa

## CATATAN ARSITEKTUR AUTH

Karena Laravel Breeze digunakan dengan kustomisasi:

- **Admin & Kepala Desa** → login via email/username + password (standard Breeze)
- **Masyarakat** → login via nomor HP + OTP (email/WhatsApp)
- Kita pakai **single users table** dengan diferensiasi role, plus **tabel terpisah** untuk OTP management

---

## 1. AUTHENTICATION & USERS

```sql
-- Table: users (unified, semua role)
CREATE TABLE users (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name            VARCHAR(100) NOT NULL,
    email           VARCHAR(150) UNIQUE NULL,         -- wajib untuk admin/kepala desa
    phone           VARCHAR(20)  UNIQUE NULL,          -- wajib untuk masyarakat
    username        VARCHAR(50)  UNIQUE NULL,           -- opsional, admin bisa pakai ini
    password        VARCHAR(255) NULL,                 -- null untuk masyarakat (OTP only)
    role            ENUM('admin','kepala_desa','masyarakat') NOT NULL DEFAULT 'masyarakat',
    status          ENUM('active','inactive','suspended') NOT NULL DEFAULT 'active',
    email_verified_at   TIMESTAMP NULL,
    phone_verified_at   TIMESTAMP NULL,
    avatar          VARCHAR(255) NULL,
    last_login_at   TIMESTAMP NULL,
    last_login_ip   VARCHAR(45) NULL,
    remember_token  VARCHAR(100) NULL,
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at      TIMESTAMP NULL                     -- soft delete
);

-- Table: otp_verifications
CREATE TABLE otp_verifications (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    identifier      VARCHAR(150) NOT NULL,             -- bisa phone atau email
    type            ENUM('phone','email') NOT NULL,
    purpose         ENUM('login','register','reset_password','verify') NOT NULL,
    otp_code        VARCHAR(10) NOT NULL,              -- hashed di aplikasi
    channel         ENUM('whatsapp','sms','email') NOT NULL DEFAULT 'whatsapp',
    is_used         BOOLEAN DEFAULT FALSE,
    attempt_count   TINYINT DEFAULT 0,                 -- max attempt 3x
    expires_at      TIMESTAMP NOT NULL,                -- 5 menit
    used_at         TIMESTAMP NULL,
    ip_address      VARCHAR(45) NULL,
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    INDEX idx_identifier_purpose (identifier, purpose),
    INDEX idx_expires (expires_at)
);

-- Table: user_sessions (tracking aktif session)
CREATE TABLE user_sessions (
    id              VARCHAR(255) PRIMARY KEY,
    user_id         BIGINT UNSIGNED NULL,
    ip_address      VARCHAR(45) NULL,
    user_agent      TEXT NULL,
    payload         LONGTEXT NOT NULL,
    last_activity   INT NOT NULL,

    INDEX idx_user_id (user_id),
    INDEX idx_last_activity (last_activity)
);

-- Table: permissions (spatie/laravel-permission atau custom)
CREATE TABLE permissions (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name            VARCHAR(100) NOT NULL UNIQUE,      -- 'surat.create', 'master.manage'
    display_name    VARCHAR(150) NULL,
    group           VARCHAR(50) NULL,                  -- 'surat', 'master', 'user'
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table: role_permissions
CREATE TABLE role_permissions (
    role            ENUM('admin','kepala_desa','masyarakat') NOT NULL,
    permission_id   BIGINT UNSIGNED NOT NULL,

    PRIMARY KEY (role, permission_id),
    FOREIGN KEY (permission_id) REFERENCES permissions(id) ON DELETE CASCADE
);
```

---

## 2. DATA MASTER

```sql
-- Table: master_wilayah (RT/RW/Dusun/Desa)
CREATE TABLE master_wilayah (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    parent_id       BIGINT UNSIGNED NULL,              -- self-referencing
    tipe            ENUM('desa','dusun','rw','rt') NOT NULL,
    kode            VARCHAR(20) NULL,
    nama            VARCHAR(100) NOT NULL,
    is_active       BOOLEAN DEFAULT TRUE,
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (parent_id) REFERENCES master_wilayah(id) ON DELETE SET NULL
);

-- Table: master_pekerjaan
CREATE TABLE master_pekerjaan (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nama            VARCHAR(100) NOT NULL,
    kode            VARCHAR(20) NULL,
    is_active       BOOLEAN DEFAULT TRUE,
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table: master_agama
CREATE TABLE master_agama (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nama            VARCHAR(50) NOT NULL,
    is_active       BOOLEAN DEFAULT TRUE
);

-- Table: master_jabatan (untuk penandatangan)
CREATE TABLE master_jabatan (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nama_jabatan    VARCHAR(100) NOT NULL,
    singkatan       VARCHAR(20) NULL,
    is_penandatangan BOOLEAN DEFAULT FALSE,            -- bisa TTD surat?
    urutan          TINYINT DEFAULT 0,
    is_active       BOOLEAN DEFAULT TRUE,
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table: pejabat_desa (yang menjabat saat ini, bisa berganti)
CREATE TABLE pejabat_desa (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id         BIGINT UNSIGNED NOT NULL,
    jabatan_id      BIGINT UNSIGNED NOT NULL,
    nip             VARCHAR(30) NULL,
    periode_mulai   DATE NOT NULL,
    periode_selesai DATE NULL,
    tanda_tangan    VARCHAR(255) NULL,                 -- path file TTD digital
    stempel_path    VARCHAR(255) NULL,
    is_aktif        BOOLEAN DEFAULT TRUE,
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (jabatan_id) REFERENCES master_jabatan(id)
);

-- Table: jenis_surat (master jenis surat + konfigurasi prioritas)
CREATE TABLE jenis_surat (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    kode            VARCHAR(20) NOT NULL UNIQUE,       -- 'SKTM', 'SKD', 'SKPWNI'
    nama            VARCHAR(150) NOT NULL,
    deskripsi       TEXT NULL,
    base_priority   TINYINT NOT NULL DEFAULT 5,        -- 1-10, dasar skor prioritas
    sla_hari        TINYINT NOT NULL DEFAULT 3,        -- target selesai dalam X hari
    template_path   VARCHAR(255) NULL,                 -- path file template blade/docx
    nomor_format    VARCHAR(100) NULL,                 -- format nomor surat: '{KODE}/{BULAN}/{TAHUN}'
    counter_nomor   INT DEFAULT 0,                     -- auto-increment nomor surat
    requires_verification BOOLEAN DEFAULT TRUE,        -- perlu biodata verified?
    is_active       BOOLEAN DEFAULT TRUE,
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table: jenis_surat_fields (field dinamis per jenis surat)
CREATE TABLE jenis_surat_fields (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    jenis_surat_id  BIGINT UNSIGNED NOT NULL,
    field_key       VARCHAR(50) NOT NULL,              -- 'keperluan', 'tujuan_surat'
    field_label     VARCHAR(100) NOT NULL,
    field_type      ENUM('text','textarea','select','date','file','number','radio','checkbox') NOT NULL,
    field_options   JSON NULL,                         -- untuk select/radio: ["Bekerja","Sekolah"]
    is_required     BOOLEAN DEFAULT TRUE,
    urutan          TINYINT DEFAULT 0,
    placeholder     VARCHAR(150) NULL,
    validation_rules VARCHAR(255) NULL,               -- 'max:500|string'

    FOREIGN KEY (jenis_surat_id) REFERENCES jenis_surat(id) ON DELETE CASCADE,
    INDEX idx_jenis_surat (jenis_surat_id)
);

-- Table: syarat_surat (dokumen yang harus di-upload)
CREATE TABLE syarat_surat (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    jenis_surat_id  BIGINT UNSIGNED NOT NULL,
    nama_syarat     VARCHAR(150) NOT NULL,             -- 'Fotokopi KTP', 'Surat RT'
    deskripsi       VARCHAR(255) NULL,
    is_required     BOOLEAN DEFAULT TRUE,
    max_size_kb     INT DEFAULT 2048,
    allowed_types   VARCHAR(100) DEFAULT 'pdf,jpg,png',

    FOREIGN KEY (jenis_surat_id) REFERENCES jenis_surat(id) ON DELETE CASCADE
);

-- Table: priority_bobot (konfigurasi bobot untuk algoritma)
CREATE TABLE priority_bobot (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    kategori        VARCHAR(50) NOT NULL,              -- 'status_sosial', 'aging', 'jenis'
    kode            VARCHAR(50) NOT NULL UNIQUE,
    label           VARCHAR(100) NOT NULL,
    bobot           DECIMAL(5,2) NOT NULL DEFAULT 0,  -- nilai tambah ke priority score
    keterangan      TEXT NULL,
    is_active       BOOLEAN DEFAULT TRUE,
    updated_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
-- Contoh data:
-- ('status_sosial', 'LANSIA', 'Usia > 60 Tahun', 2.00)
-- ('status_sosial', 'DISABILITAS', 'Penyandang Disabilitas', 3.00)
-- ('status_sosial', 'HAMIL', 'Ibu Hamil', 2.50)
-- ('aging', 'PER_HARI', 'Tambahan per hari menunggu', 0.10)
-- ('aging', 'MAX_AGING', 'Maksimum bobot aging', 5.00)
```

---

## 3. PENDUDUK & BIODATA MASYARAKAT

```sql
-- Table: penduduk (data master kependudukan, bisa import dari Disdukcapil)
CREATE TABLE penduduk (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nik             VARCHAR(16) NOT NULL UNIQUE,
    no_kk           VARCHAR(16) NOT NULL,
    nama_lengkap    VARCHAR(150) NOT NULL,
    tempat_lahir    VARCHAR(100) NOT NULL,
    tanggal_lahir   DATE NOT NULL,
    jenis_kelamin   ENUM('L','P') NOT NULL,
    agama_id        BIGINT UNSIGNED NULL,
    pekerjaan_id    BIGINT UNSIGNED NULL,
    status_perkawinan ENUM('belum_kawin','kawin','cerai_hidup','cerai_mati') NOT NULL,
    golongan_darah  ENUM('A','B','AB','O','tidak_tahu') NULL,
    kewarganegaraan VARCHAR(10) DEFAULT 'WNI',
    status_dalam_kk ENUM('kepala_keluarga','istri','anak','lainnya') NULL,
    rt_id           BIGINT UNSIGNED NULL,              -- FK ke master_wilayah (RT)
    alamat_lengkap  TEXT NOT NULL,
    is_aktif        BOOLEAN DEFAULT TRUE,              -- penduduk aktif/pindah/meninggal
    status_penduduk ENUM('tetap','sementara','tinggal') DEFAULT 'tetap',
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (agama_id) REFERENCES master_agama(id),
    FOREIGN KEY (pekerjaan_id) REFERENCES master_pekerjaan(id),
    FOREIGN KEY (rt_id) REFERENCES master_wilayah(id),
    INDEX idx_nik (nik),
    INDEX idx_no_kk (no_kk)
);

-- Table: biodata_masyarakat (profil user masyarakat, linked ke penduduk)
CREATE TABLE biodata_masyarakat (
    id                  BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id             BIGINT UNSIGNED NOT NULL UNIQUE,
    penduduk_id         BIGINT UNSIGNED NULL,          -- NULL dulu sebelum verifikasi
    nik                 VARCHAR(16) NOT NULL,
    nama_lengkap        VARCHAR(150) NOT NULL,
    tempat_lahir        VARCHAR(100) NOT NULL,
    tanggal_lahir       DATE NOT NULL,
    jenis_kelamin       ENUM('L','P') NOT NULL,
    agama_id            BIGINT UNSIGNED NULL,
    pekerjaan_id        BIGINT UNSIGNED NULL,
    status_perkawinan   ENUM('belum_kawin','kawin','cerai_hidup','cerai_mati') NOT NULL,
    golongan_darah      ENUM('A','B','AB','O','tidak_tahu') NULL,
    rt_id               BIGINT UNSIGNED NULL,
    alamat_lengkap      TEXT NOT NULL,
    foto_ktp            VARCHAR(255) NULL,             -- path upload
    foto_kk             VARCHAR(255) NULL,
    is_disabilitas      BOOLEAN DEFAULT FALSE,
    jenis_disabilitas   VARCHAR(100) NULL,
    is_hamil            BOOLEAN DEFAULT FALSE,
    catatan_khusus      TEXT NULL,

    -- Status verifikasi
    verification_status ENUM('unverified','pending','verified','rejected') DEFAULT 'unverified',
    verified_by         BIGINT UNSIGNED NULL,          -- user_id admin
    verified_at         TIMESTAMP NULL,
    rejection_reason    TEXT NULL,

    created_at          TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at          TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (penduduk_id) REFERENCES penduduk(id),
    FOREIGN KEY (verified_by) REFERENCES users(id),
    FOREIGN KEY (agama_id) REFERENCES master_agama(id),
    FOREIGN KEY (pekerjaan_id) REFERENCES master_pekerjaan(id),
    FOREIGN KEY (rt_id) REFERENCES master_wilayah(id),
    INDEX idx_nik (nik)
);
```

---

## 4. PENGAJUAN SURAT & ANTRIAN (CORE MODULE)

```sql
-- Table: pengajuan_surat (main table)
CREATE TABLE pengajuan_surat (
    id                  BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    kode_pengajuan      VARCHAR(30) NOT NULL UNIQUE,  -- 'PGJ-20250221-0001'
    user_id             BIGINT UNSIGNED NOT NULL,
    biodata_id          BIGINT UNSIGNED NOT NULL,
    jenis_surat_id      BIGINT UNSIGNED NOT NULL,

    -- Data pengajuan
    keperluan           TEXT NULL,                    -- keperluan umum
    field_data          JSON NOT NULL,                -- jawaban field dinamis
    catatan_pemohon     TEXT NULL,

    -- Prioritas & Antrian
    priority_score      DECIMAL(8,2) NOT NULL DEFAULT 0,
    priority_breakdown  JSON NULL,     -- {'base':5,'lansia':2,'aging':0.5,'total':7.5}
    antrian_number      INT NULL,                     -- nomor antrian harian
    antrian_date        DATE NULL,

    -- Status tracking
    status              ENUM(
                            'draft',
                            'submitted',
                            'queued',
                            'in_process',
                            'need_revision',
                            'validated',
                            'approved',
                            'rejected',
                            'ready',
                            'completed',
                            'cancelled'
                        ) NOT NULL DEFAULT 'draft',

    -- Timestamps per status (untuk SLA monitoring)
    submitted_at        TIMESTAMP NULL,
    queued_at           TIMESTAMP NULL,
    process_started_at  TIMESTAMP NULL,
    validated_at        TIMESTAMP NULL,
    approved_at         TIMESTAMP NULL,
    ready_at            TIMESTAMP NULL,
    completed_at        TIMESTAMP NULL,

    -- Hasil surat
    nomor_surat         VARCHAR(100) NULL,            -- nomor resmi surat
    surat_path          VARCHAR(255) NULL,            -- path PDF final
    surat_generated_at  TIMESTAMP NULL,

    -- Handler
    handled_by_admin    BIGINT UNSIGNED NULL,         -- user_id admin yang proses
    approved_by         BIGINT UNSIGNED NULL,         -- user_id kepala desa

    -- Misc
    is_priority_recalculated BOOLEAN DEFAULT FALSE,
    last_priority_update TIMESTAMP NULL,

    created_at          TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at          TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at          TIMESTAMP NULL,

    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (biodata_id) REFERENCES biodata_masyarakat(id),
    FOREIGN KEY (jenis_surat_id) REFERENCES jenis_surat(id),
    FOREIGN KEY (handled_by_admin) REFERENCES users(id),
    FOREIGN KEY (approved_by) REFERENCES users(id),

    INDEX idx_status (status),
    INDEX idx_priority_score (priority_score DESC),
    INDEX idx_antrian_date (antrian_date),
    INDEX idx_user_status (user_id, status)
);

-- Table: pengajuan_dokumen (dokumen pendukung yang diupload)
CREATE TABLE pengajuan_dokumen (
    id                  BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    pengajuan_id        BIGINT UNSIGNED NOT NULL,
    syarat_id           BIGINT UNSIGNED NULL,          -- FK ke syarat_surat
    nama_dokumen        VARCHAR(150) NOT NULL,
    original_filename   VARCHAR(255) NOT NULL,
    file_path           VARCHAR(255) NOT NULL,
    file_size           INT NOT NULL,
    mime_type           VARCHAR(100) NOT NULL,
    upload_status       ENUM('uploaded','verified','rejected') DEFAULT 'uploaded',
    rejection_note      VARCHAR(255) NULL,
    uploaded_at         TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (pengajuan_id) REFERENCES pengajuan_surat(id) ON DELETE CASCADE,
    FOREIGN KEY (syarat_id) REFERENCES syarat_surat(id)
);

-- Table: pengajuan_history (log perubahan status — audit trail lengkap)
CREATE TABLE pengajuan_history (
    id                  BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    pengajuan_id        BIGINT UNSIGNED NOT NULL,
    from_status         VARCHAR(30) NULL,
    to_status           VARCHAR(30) NOT NULL,
    priority_score_saat_itu DECIMAL(8,2) NULL,
    actor_id            BIGINT UNSIGNED NULL,          -- siapa yang ubah status
    actor_role          VARCHAR(20) NULL,
    catatan             TEXT NULL,
    metadata            JSON NULL,                    -- data tambahan jika perlu
    created_at          TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (pengajuan_id) REFERENCES pengajuan_surat(id) ON DELETE CASCADE,
    INDEX idx_pengajuan (pengajuan_id)
);

-- Table: pengajuan_revisi (jika admin minta perbaikan)
CREATE TABLE pengajuan_revisi (
    id                  BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    pengajuan_id        BIGINT UNSIGNED NOT NULL,
    diminta_oleh        BIGINT UNSIGNED NOT NULL,
    catatan_revisi      TEXT NOT NULL,
    field_bermasalah    JSON NULL,                    -- ['nik','foto_ktp']
    deadline_revisi     TIMESTAMP NULL,
    status              ENUM('pending','revised','expired') DEFAULT 'pending',
    revised_at          TIMESTAMP NULL,
    created_at          TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (pengajuan_id) REFERENCES pengajuan_surat(id) ON DELETE CASCADE,
    FOREIGN KEY (diminta_oleh) REFERENCES users(id)
);

-- Table: antrian_harian (snapshot antrian per hari)
CREATE TABLE antrian_harian (
    id                  BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    tanggal             DATE NOT NULL,
    jenis_surat_id      BIGINT UNSIGNED NOT NULL,
    pengajuan_id        BIGINT UNSIGNED NOT NULL,
    nomor_antrian       INT NOT NULL,
    priority_score      DECIMAL(8,2) NOT NULL,
    status              ENUM('waiting','processing','done','skipped') DEFAULT 'waiting',
    estimated_time      TIME NULL,

    UNIQUE KEY uq_antrian (tanggal, jenis_surat_id, nomor_antrian),
    FOREIGN KEY (pengajuan_id) REFERENCES pengajuan_surat(id),
    FOREIGN KEY (jenis_surat_id) REFERENCES jenis_surat(id),
    INDEX idx_tanggal_status (tanggal, status)
);
```

---

## 5. SURAT & PENOMORAN

```sql
-- Table: surat_terbit (surat yang sudah selesai dan resmi)
CREATE TABLE surat_terbit (
    id                  BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    pengajuan_id        BIGINT UNSIGNED NOT NULL UNIQUE,
    nomor_surat         VARCHAR(100) NOT NULL UNIQUE,
    jenis_surat_id      BIGINT UNSIGNED NOT NULL,
    nama_pemohon        VARCHAR(150) NOT NULL,         -- snapshot saat surat dibuat
    nik_pemohon         VARCHAR(16) NOT NULL,
    pejabat_id          BIGINT UNSIGNED NOT NULL,      -- siapa yang TTD
    tanggal_terbit      DATE NOT NULL,
    berlaku_sampai      DATE NULL,                    -- ada surat yang ada masa berlakunya
    file_path           VARCHAR(255) NOT NULL,
    file_hash           VARCHAR(64) NULL,             -- SHA256 untuk verifikasi keaslian
    qr_code_path        VARCHAR(255) NULL,            -- QR code verifikasi
    qr_token            VARCHAR(100) NULL UNIQUE,     -- token untuk scan QR
    download_count      INT DEFAULT 0,
    last_downloaded_at  TIMESTAMP NULL,
    created_at          TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (pengajuan_id) REFERENCES pengajuan_surat(id),
    FOREIGN KEY (jenis_surat_id) REFERENCES jenis_surat(id),
    FOREIGN KEY (pejabat_id) REFERENCES pejabat_desa(id),
    INDEX idx_qr_token (qr_token),
    INDEX idx_nomor (nomor_surat)
);

-- Table: nomor_surat_counter (untuk generate nomor surat otomatis)
CREATE TABLE nomor_surat_counter (
    id                  BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    jenis_surat_id      BIGINT UNSIGNED NOT NULL,
    tahun               YEAR NOT NULL,
    bulan               TINYINT NOT NULL,
    counter             INT NOT NULL DEFAULT 0,

    UNIQUE KEY uq_counter (jenis_surat_id, tahun, bulan),
    FOREIGN KEY (jenis_surat_id) REFERENCES jenis_surat(id)
);
```

---

## 6. NOTIFIKASI

```sql
-- Table: notifications
CREATE TABLE notifications (
    id                  CHAR(36) PRIMARY KEY,          -- UUID
    type                VARCHAR(150) NOT NULL,
    notifiable_type     VARCHAR(150) NOT NULL,
    notifiable_id       BIGINT UNSIGNED NOT NULL,
    data                JSON NOT NULL,                -- {'title':'...','message':'...','url':'...'}
    channel             SET('database','whatsapp','email') DEFAULT 'database',
    read_at             TIMESTAMP NULL,
    sent_at             TIMESTAMP NULL,
    failed_at           TIMESTAMP NULL,
    failure_reason      TEXT NULL,
    created_at          TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    INDEX idx_notifiable (notifiable_type, notifiable_id),
    INDEX idx_read (read_at)
);

-- Table: notification_templates
CREATE TABLE notification_templates (
    id                  BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    kode                VARCHAR(50) NOT NULL UNIQUE,  -- 'PENGAJUAN_SUBMITTED', 'SURAT_READY'
    channel             ENUM('whatsapp','email','database') NOT NULL,
    subject             VARCHAR(200) NULL,            -- untuk email
    body                TEXT NOT NULL,                -- template dengan {variable}
    is_active           BOOLEAN DEFAULT TRUE,
    updated_at          TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

---

## 7. INFORMASI DESA (CMS)

```sql
-- Table: informasi_desa
CREATE TABLE informasi_desa (
    id                  BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    kategori            ENUM('pengumuman','berita','profil','layanan','agenda') NOT NULL,
    judul               VARCHAR(200) NOT NULL,
    slug                VARCHAR(200) NOT NULL UNIQUE,
    konten              LONGTEXT NOT NULL,
    thumbnail           VARCHAR(255) NULL,
    is_published        BOOLEAN DEFAULT FALSE,
    is_pinned           BOOLEAN DEFAULT FALSE,
    published_at        TIMESTAMP NULL,
    view_count          INT DEFAULT 0,
    created_by          BIGINT UNSIGNED NOT NULL,
    updated_by          BIGINT UNSIGNED NULL,
    created_at          TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at          TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at          TIMESTAMP NULL,

    FOREIGN KEY (created_by) REFERENCES users(id),
    INDEX idx_kategori_published (kategori, is_published)
);

-- Table: profil_desa
CREATE TABLE profil_desa (
    id                  BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nama_desa           VARCHAR(100) NOT NULL,
    kode_desa           VARCHAR(20) NULL,
    kecamatan           VARCHAR(100) NULL,
    kabupaten           VARCHAR(100) NULL,
    provinsi            VARCHAR(100) NULL,
    kode_pos            VARCHAR(10) NULL,
    alamat_kantor       TEXT NULL,
    telepon             VARCHAR(20) NULL,
    email               VARCHAR(100) NULL,
    website             VARCHAR(150) NULL,
    logo_path           VARCHAR(255) NULL,
    kop_surat_path      VARCHAR(255) NULL,             -- template kop surat
    visi                TEXT NULL,
    misi                TEXT NULL,
    luas_wilayah        DECIMAL(10,2) NULL,
    jumlah_penduduk     INT NULL,
    updated_at          TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

---

## 8. ACTIVITY LOG & AUDIT

```sql
-- Table: activity_logs
CREATE TABLE activity_logs (
    id                  BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id             BIGINT UNSIGNED NULL,
    action              VARCHAR(100) NOT NULL,         -- 'login', 'create_pengajuan'
    model_type          VARCHAR(100) NULL,
    model_id            BIGINT UNSIGNED NULL,
    description         TEXT NULL,
    old_values          JSON NULL,
    new_values          JSON NULL,
    ip_address          VARCHAR(45) NULL,
    user_agent          TEXT NULL,
    created_at          TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    INDEX idx_user (user_id),
    INDEX idx_model (model_type, model_id),
    INDEX idx_created (created_at)
);
```

---

## ERD RELASI RINGKAS

```
users ──────────────────── biodata_masyarakat ──── penduduk
  │                               │
  │                               │
  └── pengajuan_surat ────────────┘
        │         │
        │         ├── pengajuan_dokumen
        │         ├── pengajuan_history
        │         ├── pengajuan_revisi
        │         └── antrian_harian
        │
        └── surat_terbit ──── pejabat_desa ──── master_jabatan
                                    │
                                  users

jenis_surat ──── jenis_surat_fields
           ──── syarat_surat
           ──── nomor_surat_counter

users ──── otp_verifications
      ──── notifications
      ──── activity_logs
```

---

## PRIORITY SCORING LOGIC (Reference untuk Service Class)

```
Priority Score = base_priority (dari jenis_surat)
               + bobot_lansia   (jika usia > 60)
               + bobot_disabilitas (jika is_disabilitas = true)
               + bobot_hamil    (jika is_hamil = true)
               + aging_score    (days_waiting × bobot_per_hari, max aging_max)
               - 0              (tidak ada penalti)

Recalculate: dijalankan via Laravel Scheduler setiap hari pukul 00:01
             → UPDATE pengajuan_surat SET priority_score = ...
               WHERE status IN ('submitted','queued','in_process')
```

---
