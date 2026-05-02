# BAB IV: HASIL DAN PEMBAHASAN

## 4.1 Hasil Pengumpulan Data

Proses pengumpulan data dilakukan untuk mendapatkan gambaran mendalam mengenai kondisi pelayanan administrasi di Kantor Desa Baturata serta untuk menentukan variabel-variabel yang akan diimplementasikan ke dalam algoritma *Priority Scheduling*. Berikut adalah rincian hasil pengumpulan data tersebut:

### 4.1.1 Pemaparan Hasil Observasi Lapangan

Berdasarkan observasi yang dilakukan secara langsung di Kantor Desa Baturata, ditemukan beberapa fakta mengenai kondisi operasional pelayanan surat-menyurat sebagai berikut:

**1. Kondisi Eksisting Pelayanan**
Saat ini, proses pelayanan administrasi pengajuan surat masih berjalan secara konvensional atau manual. Masyarakat yang membutuhkan surat keterangan harus datang langsung ke kantor desa pada jam kerja, membawa berkas persyaratan fisik, dan menunggu petugas untuk memproses permohonan tersebut. Pencatatan data pengajuan masih menggunakan buku register fisik yang rentan terhadap risiko kerusakan atau kehilangan data.

**2. Kendala Operasional**
Ditemukan beberapa kendala utama dalam sistem manual ini, antara lain:
*   **Ketidakpastian Antrean**: Terjadinya penumpukan berkas permohonan di meja kerja aparatur desa, terutama pada saat volume pengajuan tinggi.
*   **Kesulitan Prioritas**: Petugas mengalami kesulitan dalam menentukan permohonan mana yang harus didahulukan (misalnya antara warga yang memiliki kebutuhan mendesak dengan warga yang datang lebih awal namun untuk urusan biasa).
*   **Hambatan Birokrasi**: Proses tanda tangan kepala desa seringkali terhambat karena berkas fisik harus menunggu di meja dan tidak adanya notifikasi real-time mengenai urgensi dokumen tersebut.

### 4.1.2 Pemaparan Hasil Wawancara

Wawancara dilakukan terhadap dua subjek utama, yaitu aparatur pemerintah desa dan perwakilan masyarakat Desa Baturata:

**1. Perspektif Aparatur Desa (Operator & Kepala Desa)**
Pihak pemerintah desa menyatakan kebutuhan mendesak terhadap sistem manajemen digital. Aparatur desa memerlukan alat yang dapat mengklasifikasikan pengajuan surat secara otomatis berdasarkan tingkat kepentingannya. Hal ini bertujuan agar dokumen-dokumen yang bersifat krusial tidak tertumpuk di bawah tumpukan berkas lainnya. Selain itu, digitalisasi arsip sangat diperlukan untuk mempermudah pencarian data di masa mendatang.

**2. Perspektif Masyarakat**
Warga desa mengeluhkan waktu tunggu yang tidak menentu dan keharusan untuk bolak-balik ke kantor desa hanya untuk mengecek apakah surat sudah selesai atau belum. Harapan masyarakat adalah adanya sistem online yang memungkinkan mereka mengajukan surat dari rumah dan mendapatkan kepastian mengenai status dokumen serta urutan prioritas pengajuan mereka secara transparan.

### 4.1.3 Ekstraksi Parameter untuk Algoritma Priority Scheduling

Berdasarkan analisis hasil observasi dan wawancara, maka dirumuskan tiga parameter utama yang akan digunakan sebagai variabel penentu dalam Algoritma *Priority Scheduling* pada SIAPS-APP. Parameter ini dirancang menggunakan sistem poin aditif (semakin tinggi skor, semakin tinggi prioritas) untuk memastikan pelayanan yang adil dan efisien.

**Tabel 4.1: Parameter Bobot Jenis Surat**
| No | Jenis Surat | Nilai Bobot | Keterangan |
|:---:|:---|:---:|:---|
| 1 | Surat Keterangan Kematian | 10 | Prioritas Sangat Tinggi (Krusal) |
| 2 | Surat Keterangan Tidak Mampu (SKTM) | 9 | Prioritas Sangat Tinggi |
| 3 | Surat Keterangan Kelahiran | 8 | Prioritas Tinggi |
| 4 | Surat Pengantar Nikah (Model N1-N4) | 8 | Prioritas Tinggi |
| 5 | Surat Pengantar Pembuatan KTP/KK | 7 | Prioritas Menengah-Atas |
| 6 | Surat Keterangan Pindah/Datang | 7 | Prioritas Menengah-Atas |
| 7 | Surat Keterangan Ahli Waris | 7 | Prioritas Menengah-Atas |
| 8 | Surat Keterangan Domisili | 6 | Prioritas Menengah |
| 9 | Surat Keterangan Belum Pernah Menikah | 6 | Prioritas Menengah |
| 10 | Surat Keterangan Janda/Duda | 6 | Prioritas Menengah |
| 11 | Surat Keterangan Usaha (SKU) | 5 | Prioritas Dasar |
| 12 | Surat Keterangan Berkelakuan Baik | 5 | Prioritas Dasar |
| 13 | Surat Keterangan Riwayat Tanah | 5 | Prioritas Dasar |

**Tabel 4.2: Parameter Bobot Tingkat Urgensi**
| No | Tingkat Urgensi | Nilai Bobot | Deskripsi Penggunaan |
|:---:|:---|:---:|:---|
| 1 | Sangat Mendesak | 4 | Keperluan darurat/kesehatan/tenggat waktu kritis |
| 2 | Mendesak | 3 | Keperluan administratif dengan batasan waktu singkat |
| 3 | Biasa | 2 | Pengurusan administratif rutin |
| 4 | Tidak Mendesak | 1 | Pengajuan untuk arsip pribadi/jangka panjang |

**Tabel 4.3: Parameter Waktu Tunggu (Aging)**
| Variabel | Satuan | Nilai Tambahan | Tujuan |
|:---|:---:|:---:|:---|
| Waiting Time (Aging) | Per Hari | +1.0 Poin | Mencegah penumpukan antrean lama (*Starvation*) |

Dengan integrasi ketiga parameter di atas, sistem akan melakukan perhitungan skor prioritas total menggunakan formula:
**Total Skor = (Bobot Jenis Surat + Bobot Urgensi) + Skor Aging**

Data hasil pengumpulan ini menjadi fondasi logis bagi pengembangan SIAPS-APP agar dapat menggantikan sistem manual dengan metode penjadwalan yang lebih objektif dan terukur.

## 4.2 Hasil Pemodelan

Pada sub-bab ini akan dipaparkan mengenai hasil pemodelan algoritma *Dynamic Priority Scheduling* (DPS) yang diimplementasikan pada sistem SIAPS-APP. Pemodelan ini bertujuan untuk memvalidasi logika perhitungan sebelum diterapkan ke dalam bahasa pemrograman.

### 4.2.1 Penjelasan Formula Matematis Algoritma

Algoritma DPS pada sistem ini bekerja dengan menjumlahkan bobot statis (Jenis Surat dan Urgensi) dengan bobot dinamis (Waktu Tunggu). Formula matematis yang digunakan adalah sebagai berikut:

$$P_{total} = B_s + B_u + (W \times A)$$

**Keterangan:**
*   $P_{total}$ : Skor Prioritas Total (semakin tinggi skor, semakin prioritas).
*   $B_s$ : Bobot Jenis Surat (Nilai 1 s/d 10).
*   $B_u$ : Bobot Tingkat Urgensi (Nilai 1 s/d 4).
*   $W$ : *Waiting Time* / Waktu Tunggu (dihitung berdasarkan jumlah hari sejak tanggal pengajuan).
*   $A$ : Konstanta *Aging* (ditetapkan sebesar 1).

### 4.2.2 Skenario Data Uji (Dataset Simulasi)

Untuk menguji efektivitas algoritma, disusun sebuah skenario data uji yang melibatkan 5 pemohon dengan karakteristik pengajuan yang bervariasi:

**Tabel 4.4: Dataset Simulasi Pengajuan**
| Pemohon | Jenis Surat ($B_s$) | Tingkat Urgensi ($B_u$) | Waktu Tunggu ($W$) |
|:---:|:---|:---:|:---:|
| **A** | SKTM (9) | Mendesak (3) | 0 Hari |
| **B** | Surat Keterangan Usaha (5) | Biasa (2) | 10 Hari |
| **C** | Surat Keterangan Kematian (10) | Sangat Mendesak (4) | 0 Hari |
| **D** | Surat Keterangan Domisili (6) | Tidak Mendesak (1) | 0 Hari |
| **E** | Surat Keterangan Kelahiran (8) | Biasa (2) | 5 Hari |

### 4.2.3 Simulasi Perhitungan Manual

Berikut adalah langkah-langkah perhitungan skor prioritas untuk masing-masing pemohon berdasarkan formula DPS:

1.  **Pemohon A**: $P_{total} = 9 + 3 + (0 \times 1) = \mathbf{12}$
2.  **Pemohon B**: $P_{total} = 5 + 2 + (10 \times 1) = \mathbf{17}$
3.  **Pemohon C**: $P_{total} = 10 + 4 + (0 \times 1) = \mathbf{14}$
4.  **Pemohon D**: $P_{total} = 6 + 1 + (0 \times 1) = \mathbf{7}$
5.  **Pemohon E**: $P_{total} = 8 + 2 + (5 \times 1) = \mathbf{15}$

**Analisis Starvation Prevention:**
Perhatikan **Pemohon B**. Meskipun jenis suratnya memiliki bobot dasar rendah ($B_s = 5$), namun karena telah menunggu selama 10 hari, skor akhirnya menjadi 17. Hal ini membuktikan bahwa mekanisme *Aging* berhasil meningkatkan prioritas pengajuan lama agar tidak tergeser terus-menerus oleh pengajuan baru yang memiliki bobot dasar lebih tinggi.

### 4.2.4 Hasil Pengurutan Antrean (Queue Sorting)

Berdasarkan hasil simulasi perhitungan manual, maka urutan antrean pelayanan dokumen di Kantor Desa Baturata adalah sebagai berikut:

**Tabel 4.5: Hasil Akhir Pengurutan Antrean DPS**
| Urutan | Pemohon | Jenis Surat | Skor Akhir | Keterangan |
|:---:|:---:|:---|:---:|:---|
| 1 | **B** | Surat Keterangan Usaha | **17** | Prioritas Tinggi (Aging) |
| 2 | **E** | Surat Keterangan Kelahiran | **15** | Prioritas Tinggi |
| 3 | **C** | Surat Keterangan Kematian | **14** | Prioritas Menengah |
| 4 | **A** | SKTM | **12** | Prioritas Menengah |
| 5 | **D** | Surat Keterangan Domisili | **7** | Prioritas Rendah |

**Kesimpulan Pemodelan:**
Hasil pengurutan menunjukkan bahwa algoritma *Dynamic Priority Scheduling* memberikan hasil yang lebih adil dibandingkan metode FIFO konvensional. Pada metode FIFO, Pemohon B akan berada di urutan pertama namun tanpa adanya transparansi bobot kepentingan. Dengan DPS, sistem dapat memberikan prioritas tinggi kepada kebutuhan mendesak (seperti Pemohon C) sekaligus menjamin pengajuan lama (seperti Pemohon B) tetap mendapatkan pelayanan tepat waktu.
