## 4.3.2 Sequence Diagram

*Sequence Diagram* digunakan untuk menggambarkan kelakuan objek dalam sebuah use case dengan mendeskripsikan waktu hidup objek dan pesan yang dikirimkan serta diterima antar objek. Berdasarkan pola arsitektur *Model-View-Controller* (MVC) yang digunakan pada SIAPS-APP, diagram ini memetakan interaksi antara *Actor*, *Boundary/View* (Antarmuka), *Control* (Controller), *Entity* (Model/Service), dan *Database*.

Berikut adalah *Sequence Diagram* untuk 4 modul utama pada SIAPS-APP (mengikuti referensi standar UML):

---

### 1. Sequence Diagram Modul Pengajuan Surat

Modul ini mendeskripsikan interaksi dari sisi masyarakat ketika mengirimkan form pengajuan. Sistem akan memanggil layanan khusus (*PriorityService*) untuk menghitung algoritma *Dynamic Priority Scheduling* (DPS) sebelum menyimpannya ke *database*.

**Kode PlantUML (Sesuai Referensi Gambar):**
```plantuml
@startuml
skinparam style strictuml
skinparam DefaultFontName Arial
skinparam SequenceMessageAlign center

actor Masyarakat as A
boundary "PengajuanView (Interface)" as V
control "PengajuanController (Control)" as C
entity "PriorityService (Service)" as S
entity "PengajuanSurat (Entity)" as E
database "Database" as DB

A -> V: klikKirimPengajuan(data)
activate V
V -> C: store(request)
activate C
C -> S: calculatePriorityScore(jenis_surat, urgensi)
activate S
S --> C: return priority_score
deactivate S
C -> E: create(data_pengajuan, priority_score)
activate E
E -> DB: insertIntoPengajuan()
activate DB
DB --> E: return success
deactivate DB
E --> C: return success
deactivate E
C --> V: redirectWithSuccess()
deactivate C
V --> A: tampilkanPesanSukses()
deactivate V
@enduml
```

**Kode Mermaid JS:**
```mermaid
sequenceDiagram
    actor A as Masyarakat
    participant V as PengajuanView (Interface)
    participant C as PengajuanController (Control)
    participant S as PriorityService (Service)
    participant E as PengajuanSurat (Entity)
    participant DB as Database
    
    A->>V: klikKirimPengajuan(data)
    activate V
    V->>C: store(request)
    activate C
    C->>S: calculatePriorityScore(jenis_surat, urgensi)
    activate S
    S-->>C: return priority_score
    deactivate S
    C->>E: create(data_pengajuan, priority_score)
    activate E
    E->>DB: insertIntoPengajuan()
    activate DB
    DB-->>E: return success
    deactivate DB
    E-->>C: return success
    deactivate E
    C-->>V: redirectWithSuccess()
    deactivate C
    V-->>A: tampilkanPesanSukses()
    deactivate V
```

---

### 2. Sequence Diagram Modul Verifikasi Pengajuan

Diagram ini memperlihatkan interaksi Admin Desa dalam memvalidasi berkas masyarakat dari daftar antrean yang telah diurutkan oleh algoritma.

**Kode PlantUML:**
```plantuml
@startuml
skinparam style strictuml
skinparam DefaultFontName Arial
skinparam SequenceMessageAlign center

actor "Admin Desa" as A
boundary "AntreanView (Interface)" as V
control "AdminController (Control)" as C
entity "PengajuanSurat (Entity)" as E
database "Database" as DB

A -> V: klikValidasi(pengajuan_id)
activate V
V -> C: update(request)
activate C
C -> E: updateStatus(pengajuan_id, 'Menunggu Persetujuan')
activate E
E -> DB: updatePengajuan()
activate DB
DB --> E: return success
deactivate DB
E --> C: return success
deactivate E
C --> V: redirectWithSuccess()
deactivate C
V --> A: tampilkanPesanSukses()
deactivate V
@enduml
```

**Kode Mermaid JS:**
```mermaid
sequenceDiagram
    actor A as Admin Desa
    participant V as AntreanView (Interface)
    participant C as AdminController (Control)
    participant E as PengajuanSurat (Entity)
    participant DB as Database
    
    A->>V: klikValidasi(pengajuan_id)
    activate V
    V->>C: update(request)
    activate C
    C->>E: updateStatus(pengajuan_id, 'Menunggu Persetujuan')
    activate E
    E->>DB: updatePengajuan()
    activate DB
    DB-->>E: return success
    deactivate DB
    E-->>C: return success
    deactivate E
    C-->>V: redirectWithSuccess()
    deactivate C
    V-->>A: tampilkanPesanSukses()
    deactivate V
```

---

### 3. Sequence Diagram Modul Persetujuan Surat

Modul ini berfokus pada peran Kepala Desa yang menyetujui surat. Proses ini melibatkan pemanggilan fungsi untuk membubuhkan Tanda Tangan Elektronik (TTE) dan membuat *file* PDF surat resmi.

**Kode PlantUML:**
```plantuml
@startuml
skinparam style strictuml
skinparam DefaultFontName Arial
skinparam SequenceMessageAlign center

actor "Kepala Desa" as A
boundary "PersetujuanView (Interface)" as V
control "PersetujuanController (Control)" as C
entity "SuratService (Service)" as S
entity "PengajuanSurat (Entity)" as E
database "Database" as DB

A -> V: klikSetujui(pengajuan_id)
activate V
V -> C: approve(request)
activate C
C -> S: generateSuratPdf(pengajuan_id)
activate S
S --> C: return pdf_path
deactivate S
C -> E: updateStatusSelesai(pengajuan_id, pdf_path)
activate E
E -> DB: updatePengajuan()
activate DB
DB --> E: return success
deactivate DB
E --> C: return success
deactivate E
C --> V: redirectWithSuccess()
deactivate C
V --> A: tampilkanPesanSukses()
deactivate V
@enduml
```

**Kode Mermaid JS:**
```mermaid
sequenceDiagram
    actor A as Kepala Desa
    participant V as PersetujuanView (Interface)
    participant C as PersetujuanController (Control)
    participant S as SuratService (Service)
    participant E as PengajuanSurat (Entity)
    participant DB as Database
    
    A->>V: klikSetujui(pengajuan_id)
    activate V
    V->>C: approve(request)
    activate C
    C->>S: generateSuratPdf(pengajuan_id)
    activate S
    S-->>C: return pdf_path
    deactivate S
    C->>E: updateStatusSelesai(pengajuan_id, pdf_path)
    activate E
    E->>DB: updatePengajuan()
    activate DB
    DB-->>E: return success
    deactivate DB
    E-->>C: return success
    deactivate E
    C-->>V: redirectWithSuccess()
    deactivate C
    V-->>A: tampilkanPesanSukses()
    deactivate V
```

---

### 4. Sequence Diagram Modul Pengunduhan Surat

Modul ini menggambarkan cara sistem merespons permintaan masyarakat yang ingin mengambil atau mengunduh *file* PDF surat yang telah selesai.

**Kode PlantUML:**
```plantuml
@startuml
skinparam style strictuml
skinparam DefaultFontName Arial
skinparam SequenceMessageAlign center

actor Masyarakat as A
boundary "RiwayatView (Interface)" as V
control "PengajuanController (Control)" as C
entity "PengajuanSurat (Entity)" as E
database "Database" as DB
entity "FileStorage (System)" as F

A -> V: klikUnduhSurat(pengajuan_id)
activate V
V -> C: download(pengajuan_id)
activate C
C -> E: findById(pengajuan_id)
activate E
E -> DB: selectPengajuan()
activate DB
DB --> E: return data
deactivate DB
E --> C: return data (surat_path)
deactivate E
C -> F: getFile(surat_path)
activate F
F --> C: return file_stream
deactivate F
C --> V: responseDownload(file)
deactivate C
V --> A: tampilkanDialogUnduh()
deactivate V
@enduml
```

**Kode Mermaid JS:**
```mermaid
sequenceDiagram
    actor A as Masyarakat
    participant V as RiwayatView (Interface)
    participant C as PengajuanController (Control)
    participant E as PengajuanSurat (Entity)
    participant DB as Database
    participant F as FileStorage (System)
    
    A->>V: klikUnduhSurat(pengajuan_id)
    activate V
    V->>C: download(pengajuan_id)
    activate C
    C->>E: findById(pengajuan_id)
    activate E
    E->>DB: selectPengajuan()
    activate DB
    DB-->>E: return data
    deactivate DB
    E-->>C: return data (surat_path)
    deactivate E
    C->>F: getFile(surat_path)
    activate F
    F-->>C: return file_stream
    deactivate F
    C-->>V: responseDownload(file)
    deactivate C
    V-->>A: tampilkanDialogUnduh()
    deactivate V
```

---

### Panduan Pembuatan Manual Sequence Diagram (Untuk Visio/Draw.io):

Berdasarkan referensi gambar Anda, elemen-elemen yang wajib ada saat menggambar secara manual adalah:
1.  **Actor (Bentuk Orang)**: Tarik *actor* ke ujung paling kiri, beri nama peran (misal: Masyarakat, Admin).
2.  **Boundary / Interface (Bentuk Kotak)**: Menandakan antarmuka yang dilihat pengguna (Contoh: `PengajuanView`).
3.  **Control (Bentuk Kotak)**: Menandakan logika program di controller (Contoh: `PengajuanController`).
4.  **Entity (Bentuk Kotak)**: Menandakan model atau data memori (Contoh: `PengajuanSurat` / `PriorityService`).
5.  **Database (Bentuk Kotak / Silinder)**: Menandakan penyimpanan permanen.
6.  **Lifeline (Garis Putus-putus ke bawah)**: Berasal dari bawah setiap kotak/actor.
7.  **Activation Box (Kotak Vertikal Panjang di Lifeline)**: Menandakan objek sedang bekerja/aktif memproses metode. Di gambar Anda, kotak abu-abu ini terlihat sangat jelas di setiap garis panah yang masuk.
8.  **Pesan Pemanggilan / Request (Garis Solid dengan Panah Penuh $\rightarrow$)**: Contoh `store(request)`, `insertIntoBookings()`. Sertakan nomor urutan pesan (1, 2, 3...) dalam bentuk lingkaran hitam seperti pada gambar.
9.  **Pesan Kembalian / Return (Garis Putus-putus dengan Panah Terbuka $\dashrightarrow$)**: Contoh `return success`, `tampilkanPesanSukses()`.
