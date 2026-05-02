# 4.3 Hasil Pengembangan Sistem

Sub-bab ini menguraikan hasil rancangan sistem SIAPS-APP yang dibangun berdasarkan hasil analisis dan pemodelan sebelumnya. Salah satu instrumen penting untuk memvisualisasikan alur kerja sistem adalah *Activity Diagram*.

## 4.3.1 Activity Diagram

*Activity Diagram* menggambarkan alur kerja (*workflow*) atau aktivitas dari sebuah sistem atau proses bisnis. Pada pemodelan ini, *activity diagram* dirancang secara sederhana menggunakan dua *swimlane* utama yang mewakili interaksi antara **Aktor (Pengguna)** dan **Sistem**.

Berikut adalah rancangan *activity diagram* untuk 4 modul utama dalam sistem SIAPS-APP (selain modul Login):

---

### 1. Activity Diagram Modul Pengajuan Surat

Modul ini menjelaskan alur saat masyarakat melakukan permohonan pembuatan surat baru. Di sinilah parameter algoritma *Priority Scheduling* mulai dicatat oleh sistem.

**Penjelasan Alur:**
Masyarakat memilih jenis surat, lalu sistem menampilkan form. Masyarakat mengisi data dan tingkat urgensi, lalu mengunggah berkas. Sistem melakukan validasi; jika tidak lengkap, akan dikembalikan ke masyarakat. Jika lengkap, sistem menghitung skor prioritas awal dan menyimpan pengajuan.

**Kode PlantUML:**
```plantuml
@startuml
skinparam style strictuml
skinparam DefaultFontName Arial
skinparam ActivityBackgroundColor white
skinparam ActivityBorderColor black
skinparam ActivityDiamondBackgroundColor white
skinparam ActivityDiamondBorderColor black

|Masyarakat|
start
:Pilih jenis surat;
|Sistem|
:Tampilkan form pengajuan;
|Masyarakat|
:Isi form (keperluan, urgensi);
:Upload dokumen persyaratan;
:Klik tombol kirim;
|Sistem|
while (Cek kelengkapan data?) is (Tidak Lengkap)
  :Tampilkan alert pesan error;
  |Masyarakat|
  :Perbaiki isian form;
  :Klik tombol kirim;
  |Sistem|
endwhile (Lengkap)
:Hitung skor prioritas (DPS);
:Simpan data pengajuan;
:Update status "Menunggu Verifikasi";
stop
@enduml
```

**Kode Mermaid:**
```mermaid
flowchart TD
    subgraph Masyarakat
        Start(( )) --> A[Pilih jenis surat]
        C[Isi form & Upload dokumen] --> D[Klik tombol kirim]
        F[Perbaiki isian form] --> C
    end
    
    subgraph Sistem
        A --> B[Tampilkan form pengajuan]
        B --> C
        D --> E{Cek kelengkapan data?}
        E -- Tidak Lengkap --> G[Tampilkan alert pesan error]
        G --> F
        E -- Lengkap --> H[Hitung skor prioritas DPS]
        H --> I[Simpan data pengajuan]
        I --> J[Update status Menunggu Verifikasi]
        J --> End((( )))
    end
```

---

### 2. Activity Diagram Modul Verifikasi Pengajuan

Modul ini menggambarkan alur kerja Admin Desa dalam memverifikasi berkas yang masuk, dengan memanfaatkan urutan antrean yang telah diolah oleh algoritma DPS.

**Penjelasan Alur:**
Admin membuka menu antrean. Sistem menampilkan daftar pengajuan yang sudah terurut berdasarkan skor prioritas tertinggi. Admin memilih pengajuan teratas dan memeriksa dokumen. Jika dokumen tidak valid (salah/buram), admin menolak dan sistem mengirim notifikasi revisi ke masyarakat. Jika valid, sistem mengupdate status ke "Menunggu Persetujuan".

**Kode PlantUML:**
```plantuml
@startuml
skinparam style strictuml
skinparam DefaultFontName Arial
skinparam ActivityBackgroundColor white
skinparam ActivityBorderColor black
skinparam ActivityDiamondBackgroundColor white
skinparam ActivityDiamondBorderColor black

|Admin Desa|
start
:Buka menu antrean pengajuan;
|Sistem|
:Tampilkan daftar antrean\n(Urut Prioritas Tertinggi);
|Admin Desa|
:Pilih pengajuan teratas;
|Sistem|
:Tampilkan detail & dokumen;
|Admin Desa|
:Periksa keabsahan dokumen;
|Sistem|
if (Dokumen valid?) then (Tidak Valid)
  :Update status "Direvisi";
  :Kirim notifikasi ke masyarakat;
  stop
else (Valid)
  :Update status "Menunggu Persetujuan";
  stop
endif
@enduml
```

**Kode Mermaid:**
```mermaid
flowchart TD
    subgraph Admin Desa
        Start(( )) --> A[Buka menu antrean pengajuan]
        C[Pilih pengajuan teratas] --> D[Periksa keabsahan dokumen]
    end
    
    subgraph Sistem
        A --> B["Tampilkan daftar antrean (Urut Prioritas Tertinggi)"]
        B --> C
        D --> E{Dokumen valid?}
        E -- Tidak Valid --> F[Update status Direvisi]
        F --> G[Kirim notifikasi ke masyarakat]
        G --> End1((( )))
        E -- Valid --> H[Update status Menunggu Persetujuan]
        H --> End2((( )))
    end
```

---

### 3. Activity Diagram Modul Persetujuan Surat (Tanda Tangan)

Modul ini menjelaskan alur persetujuan akhir oleh Kepala Desa sebelum surat dicetak atau diterbitkan secara digital.

**Penjelasan Alur:**
Kepala Desa membuka menu persetujuan. Sistem menampilkan daftar surat yang telah diverifikasi oleh admin. Kepala Desa melihat *draft* surat, lalu menekan tombol setujui. Sistem memproses persetujuan (pembubuhan TTE/QR Code), mengenerate file PDF surat, dan mengubah status menjadi "Selesai".

**Kode PlantUML:**
```plantuml
@startuml
skinparam style strictuml
skinparam DefaultFontName Arial
skinparam ActivityBackgroundColor white
skinparam ActivityBorderColor black
skinparam ActivityDiamondBackgroundColor white
skinparam ActivityDiamondBorderColor black

|Kepala Desa|
start
:Buka menu persetujuan;
|Sistem|
:Tampilkan daftar surat tervalidasi;
|Kepala Desa|
:Pilih surat;
|Sistem|
:Tampilkan draft surat;
|Kepala Desa|
:Klik tombol setujui;
|Sistem|
:Proses pembubuhan TTE / QR Code;
:Generate file surat PDF;
:Update status "Selesai";
stop
@enduml
```

**Kode Mermaid:**
```mermaid
flowchart TD
    subgraph Kepala Desa
        Start(( )) --> A[Buka menu persetujuan]
        C[Pilih surat] --> E
        E[Klik tombol setujui] --> F
    end
    
    subgraph Sistem
        A --> B[Tampilkan daftar surat tervalidasi]
        B --> C
        C --> D[Tampilkan draft surat]
        D --> E
        F[Proses pembubuhan TTE / QR Code] --> G[Generate file surat PDF]
        G --> H[Update status Selesai]
        H --> End((( )))
    end
```

---

### 4. Activity Diagram Modul Pengunduhan/Pengambilan Surat

Modul ini menggambarkan alur ketika masyarakat ingin mengunduh atau mengambil surat yang telah selesai diproses.

**Penjelasan Alur:**
Masyarakat membuka menu riwayat pengajuan. Sistem menampilkan status dokumen. Masyarakat memilih pengajuan berstatus "Selesai", lalu menekan tombol unduh. Sistem melakukan verifikasi status, mengenerate tautan unduhan, dan memberikan file PDF kepada masyarakat.

**Kode PlantUML:**
```plantuml
@startuml
skinparam style strictuml
skinparam DefaultFontName Arial
skinparam ActivityBackgroundColor white
skinparam ActivityBorderColor black
skinparam ActivityDiamondBackgroundColor white
skinparam ActivityDiamondBorderColor black

|Masyarakat|
start
:Buka menu riwayat pengajuan;
|Sistem|
:Tampilkan daftar riwayat;
|Masyarakat|
:Pilih pengajuan status "Selesai";
|Sistem|
:Tampilkan detail penyelesaian;
|Masyarakat|
:Klik tombol unduh surat;
|Sistem|
if (Cek status file?) then (File Tersedia)
  :Generate tautan unduhan;
  :Kirim file PDF surat;
  stop
else (File Error)
  :Tampilkan alert gagal;
  stop
endif
@enduml
```

**Kode Mermaid:**
```mermaid
flowchart TD
    subgraph Masyarakat
        Start(( )) --> A[Buka menu riwayat pengajuan]
        C[Pilih pengajuan status Selesai] --> E
        E[Klik tombol unduh surat] --> F
    end
    
    subgraph Sistem
        A --> B[Tampilkan daftar riwayat]
        B --> C
        C --> D[Tampilkan detail penyelesaian]
        D --> E
        F{Cek status file?}
        F -- File Tersedia --> G[Generate tautan unduhan]
        G --> H[Kirim file PDF surat]
        H --> End1((( )))
        F -- File Error --> I[Tampilkan alert gagal]
        I --> End2((( )))
    end
```

---

### Panduan Pembuatan Manual untuk Anda:
Jika Anda ingin menyalin atau membuat ulang diagram ini agar persis seperti gambar referensi Anda menggunakan **Draw.io** atau **Visual Paradigm**:

1.  **Buat Swimlane**: Tarik komponen *Vertical Pool/Swimlane*, bagilah menjadi dua kolom utama: **Kolom Kiri (Nama Aktor: Masyarakat/Admin/Kades)** dan **Kolom Kanan (Sistem)**.
2.  **Mulai (Start Node)**: Gunakan lingkaran hitam penuh di kolom Aktor untuk memulai alur.
3.  **Aktivitas**: Gunakan kotak dengan sudut membulat (*Rounded Rectangle*) untuk setiap aksi. Pastikan menaruhnya di kolom yang tepat (Aksi manusia di kolom Aktor, proses komputer di kolom Sistem).
4.  **Percabangan (Decision)**: Gunakan bentuk belah ketupat (*Diamond*) di kolom Sistem untuk pengecekan seperti "Cek stok buku" atau "Cek kelengkapan dokumen".
5.  **Garis Panah**: Hubungkan setiap aktivitas secara sekuensial. Jika kondisi pada *Diamond* adalah "Tidak Lengkap/Habis", tarik panah ke kiri (ke kolom Aktor) untuk menampilkan aksi perbaikan atau *alert*. Jika "Lengkap/Valid", tarik panah ke bawah untuk melanjutkan proses di sistem.
6.  **Selesai (End Node)**: Gunakan lingkaran hitam bergaris tepi ganda di kolom Sistem untuk menandakan proses berakhir.
