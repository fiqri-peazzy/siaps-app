# Breakdown Sistem Informasi Desa - Pengajuan Surat Berbasis Web

## MODUL 1: AUTHENTICATION & AUTHORIZATION

### Auth Flow

Sistem memiliki 3 aktor: **Admin**, **Kepala Desa**, dan **Masyarakat** — masing-masing dengan jalur masuk berbeda.

**Masyarakat** harus registrasi terlebih dahulu sebelum bisa login. Registrasi menghasilkan akun dengan status pending atau langsung aktif tergantung konfigurasi. Setelah login, masyarakat diwajibkan mengisi biodata (<<include>>) sebelum bisa mengajukan surat — ini adalah gate wajib.

**Admin** dan **Kepala Desa** tidak perlu registrasi, akun di-seed langsung dari sistem atau dibuat oleh super admin.

### Roles & Permissions

| Permission             | Admin | Kepala Desa | Masyarakat |
| ---------------------- | ----- | ----------- | ---------- |
| Kelola Data Master     | ✅    | ❌          | ❌         |
| Kelola Informasi Desa  | ✅    | ❌          | ❌         |
| Validasi Pengajuan     | ✅    | ❌          | ❌         |
| Monitoring Pengajuan   | ❌    | ✅          | ❌         |
| Approve Surat (TTD)    | ❌    | ✅          | ❌         |
| Registrasi             | ❌    | ❌          | ✅         |
| Isi Biodata            | ❌    | ❌          | ✅         |
| Ajukan Surat           | ❌    | ❌          | ✅         |
| Lihat Status Pengajuan | ❌    | ❌          | ✅         |
| Cetak Surat PDF        | ❌    | ❌          | ✅         |

---

## MODUL 2: DATA MASTER

Data master dikelola sepenuhnya oleh Admin. Ini adalah fondasi seluruh sistem.

**Sub-modul yang perlu ada:**

**Master Jenis Surat** — mendefinisikan semua jenis surat yang bisa diajukan (Surat Keterangan Domisili, Surat Keterangan Tidak Mampu, Surat Pengantar KTP, dll). Tiap jenis surat memiliki: nama surat, template dokumen, daftar field yang wajib diisi pemohon, dan **nilai prioritas** untuk algoritma Priority Scheduling.

**Master Penduduk** — data kependudukan dasar yang bisa digunakan untuk verifikasi saat masyarakat mengisi biodata (NIK matching).

**Master Jabatan/Penandatangan** — siapa yang berhak TTD, posisi tanda tangan di dokumen.

**Master Template Surat** — template PDF/HTML per jenis surat yang akan di-generate otomatis.

**Master Prioritas** — konfigurasi bobot prioritas untuk scheduling: misalnya surat SKTM punya prioritas lebih tinggi dari surat domisili biasa, atau lansia/disabilitas mendapat bobot prioritas lebih tinggi.

---

## MODUL 3: MANAJEMEN PENGGUNA & BIODATA MASYARAKAT

Setelah login pertama kali, masyarakat **wajib** melengkapi biodata sebelum fitur pengajuan surat terbuka (middleware gate).

**Field Biodata:**
NIK, nama lengkap, tempat/tanggal lahir, jenis kelamin, agama, status perkawinan, pekerjaan, alamat lengkap, RT/RW, foto KTP (upload), nomor HP aktif.

**Flow validasi biodata:** Masyarakat mengisi → disimpan dengan status `unverified` → Admin bisa verifikasi NIK terhadap data master penduduk → status menjadi `verified`. Pengajuan surat bisa dibatasi hanya untuk biodata yang sudah terverifikasi.

---

## MODUL 4: PENGAJUAN SURAT (ANTRIAN + PRIORITY SCHEDULING)

Ini adalah modul inti sistem.

### Alur Pengajuan

1. Masyarakat memilih jenis surat yang diinginkan
2. Sistem menampilkan form dinamis sesuai jenis surat (dari master)
3. Masyarakat mengisi form + upload dokumen pendukung jika diperlukan
4. Submit → sistem membuat tiket antrian

### Algoritma Priority Scheduling

Setiap pengajuan yang masuk akan dihitung nilai prioritasnya berdasarkan beberapa faktor:

```
Priority Score = Bobot_Jenis_Surat + Bobot_Status_Sosial + Bobot_Waiting_Time
```

**Bobot Jenis Surat** → ditentukan dari master prioritas. SKTM, surat mendesak, atau surat yang berkaitan dengan kebutuhan darurat mendapat skor tinggi.

**Bobot Status Sosial** → lansia (usia >60), penyandang disabilitas, ibu hamil bisa mendapat tambahan bobot.

**Bobot Waiting Time (Aging)** → semakin lama pengajuan menunggu, skornya naik secara periodik. Ini mencegah starvation — pengajuan prioritas rendah tidak akan antri selamanya.

Antrian diproses Admin secara berurutan dari skor tertinggi ke terendah. Tampilan antrian di dashboard Admin diurutkan berdasarkan `priority_score DESC`.

### Status Pengajuan

```
SUBMITTED → QUEUED → IN_PROCESS → VALIDATED (Admin) → APPROVED/TTD (Kepala Desa) → READY → SELESAI
                                                      ↘ REJECTED (dengan keterangan)
```

---

## MODUL 5: VALIDASI PENGAJUAN (ADMIN)

Admin melihat daftar antrian yang sudah diurutkan by priority score.

**Yang dilakukan Admin:**

- Review kelengkapan dokumen pendukung
- Verifikasi data pemohon vs data master penduduk
- Jika valid → status diubah ke `VALIDATED`, surat di-generate otomatis dari template, diteruskan ke Kepala Desa
- Jika tidak valid → `REJECTED` dengan catatan alasan, notifikasi ke masyarakat

---

## MODUL 6: MONITORING & APPROVE SURAT (KEPALA DESA)

**Monitoring Pengajuan:** Kepala Desa bisa melihat semua pengajuan yang sedang berjalan, statistik harian/bulanan, jumlah per jenis surat, rata-rata waktu proses.

**Approve Surat (TTD):** Kepala Desa menerima surat yang sudah divalidasi Admin → review isi surat → Approve (tanda tangan digital/stempel) atau Reject dengan catatan. Setelah di-approve, status berubah menjadi `READY` dan masyarakat bisa mencetak.

---

## MODUL 7: CETAK SURAT PDF

Setelah status `READY`, masyarakat bisa masuk ke halaman status pengajuan dan mencetak surat dalam format PDF. PDF di-generate dari template yang sudah diisi data otomatis + tanda tangan/stempel digital Kepala Desa.

---

## MODUL 8: INFORMASI DESA

Dikelola Admin, bisa dilihat publik (atau setelah login). Berisi: pengumuman, berita desa, profil desa, struktur organisasi, layanan yang tersedia. Ini adalah modul CMS sederhana.

---

## Ringkasan Alur End-to-End

```
Masyarakat Registrasi → Login → Isi Biodata
    → Pilih Jenis Surat → Isi Form → Submit
    → Sistem Hitung Priority Score → Masuk Antrian

Admin Login → Lihat Antrian (sorted by priority)
    → Proses Validasi → Generate Draft Surat
    → Teruskan ke Kepala Desa

Kepala Desa Login → Monitoring → Review Surat
    → Approve + TTD Digital

Masyarakat → Cek Status → READY → Cetak PDF
```

---

Selanjutnya kita bisa mulai breakdown teknis per modul: **database schema, API endpoint, UI flow**, atau langsung ke implementasi modul mana yang ingin dikerjakan pertama?
