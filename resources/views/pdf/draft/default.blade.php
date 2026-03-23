<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Draf Surat - {{ $pengajuan->kode_pengajuan }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 11pt;
            line-height: 1.15;
            color: #000;
            padding: 0 2cm 1cm 2cm;
        }

        /* ===================== KOP SURAT ===================== */
        .kop {
            width: 100%;
            position: relative;
            border-bottom: 4px double black;
            padding-top: 0.5cm;
            padding-bottom: 6px;
            margin-bottom: 10px;
        }

        .kop-inner {
            display: table;
            width: 100%;
        }

        .kop-logo {
            display: table-cell;
            width: 70px;
            vertical-align: middle;
            text-align: center;
            padding-right: 10px;
        }

        .kop-logo img {
            width: 70px;
            height: auto;
        }

        .kop-text {
            display: table-cell;
            vertical-align: middle;
            text-align: center;
        }

        .kop-text .nama-pemerintah {
            font-size: 12pt;
            font-weight: bold;
            letter-spacing: 0.5px;
            margin: 0;
            line-height: 1.2;
        }

        .kop-text .nama-kecamatan {
            font-size: 12pt;
            font-weight: bold;
            margin: 2px 0;
            line-height: 1.2;
        }

        .kop-text .nama-desa {
            font-size: 16pt;
            font-weight: bold;
            margin: 2px 0;
            line-height: 1.2;
        }

        .kop-text .alamat-desa {
            font-size: 9pt;
            margin-top: 2px;
            line-height: 1.2;
        }

        /* ===================== JUDUL SURAT ===================== */
        .judul-wrapper {
            text-align: center;
            margin: 12px 0 4px 0;
        }

        .judul {
            font-size: 12pt;
            font-weight: bold;
            text-transform: uppercase;
            text-decoration: underline;
            letter-spacing: 0.5px;
        }

        .nomor-surat {
            font-size: 10.5pt;
            text-align: center;
            margin-bottom: 12px;
        }

        /* ===================== ISI SURAT ===================== */
        .pembuka-surat {
            margin-bottom: 8px;
            text-align: justify;
            line-height: 1.3;
        }

        table.biodata {
            width: 100%;
            border-collapse: collapse;
            margin: 6px 0 10px 0;
        }

        table.biodata td {
            padding: 1.5px 0;
            vertical-align: top;
            line-height: 1.2;
        }

        table.biodata td.label {
            width: 150px;
        }

        table.biodata td.titik-dua {
            width: 14px;
            text-align: center;
        }

        table.biodata td.value {
            font-weight: bold;
        }

        /* ===================== PENUTUP ===================== */
        .penutup {
            margin-top: 10px;
            text-align: justify;
            line-height: 1.3;
        }

        /* ===================== TTD ===================== */
        .ttd-wrapper {
            width: 240px;
            float: right;
            margin-top: 24px;
            text-align: center;
        }

        .ttd-kota {
            margin-bottom: 4px;
        }

        .ttd-nama {
            font-weight: bold;
            text-decoration: underline;
            text-transform: uppercase;
            margin: 0;
        }

        .ttd-nip {
            margin: 0;
            font-size: 10pt;
        }

        .ttd-kosong {
            height: 70px;
        }

        /* ===================== WATERMARK ===================== */
        @if ($pengajuan->status !== 'approved' && $pengajuan->status !== 'ready' && $pengajuan->status !== 'completed')
            .watermark {
                position: fixed;
                top: 40%;
                left: 5%;
                font-size: 80pt;
                color: rgba(200, 0, 0, 0.08);
                font-weight: bold;
                white-space: nowrap;
                transform: rotate(-40deg);
                z-index: -1;
                letter-spacing: -5px;
            }
        @endif
    </style>
</head>

<body>

    {{-- WATERMARK --}}
    @if ($pengajuan->status !== 'approved' && $pengajuan->status !== 'ready' && $pengajuan->status !== 'completed')
        <div class="watermark">DRAF</div>
    @endif

    {{-- KOP SURAT --}}
    <div class="kop">
        <div class="kop-inner">
            <div class="kop-logo">
                <img src="{{ public_path('images/buolkab.png') }}" alt="Logo Kabupaten Buol">
            </div>
            <div class="kop-text">
                <p class="nama-pemerintah">PEMERINTAH KABUPATEN BUOL</p>
                <p class="nama-kecamatan">KECAMATAN PALELEH</p>
                <p class="nama-desa">DESA BATURATA</p>
                <p class="alamat-desa">Jl. Trans Sulawesi No. 100, Telp. 0445 211 kode pos 94568</p>
            </div>
        </div>
    </div>

    {{-- JUDUL SURAT --}}
    <div class="judul-wrapper">
        <p class="judul">{{ $pengajuan->jenisSurat->nama }}</p>
    </div>
    <p class="nomor-surat">
        Nomor : {{ $pengajuan->nomor_surat ?? '....... / ....... / .......' }}
    </p>

    {{-- PEMBUKA --}}
    <p class="pembuka-surat">
        Yang bertanda tangan di bawah ini Kepala Desa Baturata, Kecamatan Paleleh, Kabupaten Buol, menerangkan dengan
        sebenarnya bahwa:
    </p>

    {{-- DATA DIRI PEMOHON --}}
    @php
        $biodata = $pengajuan->biodata;
        $namaLengkap = $biodata->nama_lengkap ?? ($biodata->user->name ?? '-');

        $genderMap = [
            'L' => 'Laki-laki',
            'P' => 'Perempuan',
            'l' => 'Laki-laki',
            'p' => 'Perempuan',
            'laki-laki' => 'Laki-laki',
            'perempuan' => 'Perempuan',
        ];
        $jenisKelamin =
            $genderMap[$biodata->jenis_kelamin] ??
            ($genderMap[strtolower($biodata->jenis_kelamin)] ?? $biodata->jenis_kelamin);

        $statusKawinMap = [
            'belum_menikah' => 'Belum Menikah',
            'menikah' => 'Menikah',
            'cerai_hidup' => 'Cerai Hidup',
            'cerai_mati' => 'Cerai Mati',
        ];
        $statusKawin = $statusKawinMap[$biodata->status_perkawinan] ?? ($biodata->status_perkawinan ?? '-');

        // Build address - MasterWilayah is self-referencing: RT -> parent (RW) -> parent (Dusun)
        $rt = $biodata->rt?->nama ?? '-';
        $rw = $biodata->rt?->parent?->nama ?? '-';
        $dusun = $biodata->rt?->parent?->parent?->nama ?? '-';
        $alamatLengkap = $biodata->alamat_lengkap;
        $alamatDisplay =
            $alamatLengkap .
            ', ' .
            'Dusun ' .
            $dusun .
            ', Rt ' .
            $rt .
            ' Rw ' .
            $rw .
            ', Desa Baturata, Kec. Paleleh, Kab. Buol';
    @endphp

    <table class="biodata">
        <tr>
            <td class="label">Nama</td>
            <td class="titik-dua">:</td>
            <td class="value">{{ $namaLengkap }}</td>
        </tr>
        <tr>
            <td class="label">Tempat Tanggal Lahir</td>
            <td class="titik-dua">:</td>
            <td>{{ $biodata->tempat_lahir }},
                {{ \Carbon\Carbon::parse($biodata->tanggal_lahir)->isoFormat('D MMMM Y') }}</td>
        </tr>
        <tr>
            <td class="label">Jenis Kelamin</td>
            <td class="titik-dua">:</td>
            <td>{{ $jenisKelamin }}</td>
        </tr>
        <tr>
            <td class="label">Agama</td>
            <td class="titik-dua">:</td>
            <td>{{ $biodata->agama?->nama ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Pekerjaan</td>
            <td class="titik-dua">:</td>
            <td>{{ $biodata->pekerjaan?->nama ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Status Perkawinan</td>
            <td class="titik-dua">:</td>
            <td>{{ $statusKawin }}</td>
        </tr>
        <tr>
            <td class="label">NIK / No. KTP</td>
            <td class="titik-dua">:</td>
            <td>{{ $biodata->nik }}</td>
        </tr>
        {{-- nomor_kk removed: column does not exist in DB --}}
        <tr>
            <td class="label">Alamat Lengkap</td>
            <td class="titik-dua">:</td>
            <td>{{ $alamatDisplay }}</td>
        </tr>
    </table>

    {{-- FIELD SPESIFIK JENIS SURAT --}}
    @if ($pengajuan->field_data && is_array($pengajuan->field_data) && count($pengajuan->field_data) > 0)
        <table class="biodata">
            @foreach ($pengajuan->field_data as $key => $value)
                @if ($key !== 'keperluan')
                    @php
                        $fieldLabel = ucwords(str_replace('_', ' ', $key));
                        if (isset($pengajuan->jenisSurat->fields)) {
                            $matchedField = collect($pengajuan->jenisSurat->fields)->firstWhere('field_key', $key);
                            if ($matchedField) {
                                $fieldLabel = $matchedField->field_label ?? $matchedField['field_label'];
                            }
                        }
                    @endphp
                    <tr>
                        <td class="label">{{ $fieldLabel }}</td>
                        <td class="titik-dua">:</td>
                        <td>{{ is_array($value) ? implode(', ', $value) : $value }}</td>
                    </tr>
                @endif
            @endforeach
        </table>
    @endif

    {{-- ISI PARAGRAF --}}
    @php
        $keperluan = $pengajuan->field_data['keperluan'] ?? ($pengajuan->keperluan ?? null);
    @endphp

    <p class="pembuka-surat" style="margin-top:8px;">
        Bahwa benar nama tersebut di atas adalah benar-benar warga Desa Baturata, Kec. Paleleh, Kab. Buol
        dan termasuk kelompok masyarakat yang keadaan ekonominya
        {{ $pengajuan->jenisSurat->kode === 'SKTM' ? 'kurang mampu dan termasuk dalam kategori keluarga miskin' : 'memerlukan pelayanan administrasi' }}
        @if ($keperluan)
            yang akan digunakan sebagai <strong>{{ $keperluan }}</strong>
        @endif.
    </p>

    <p class="penutup">
        Demikian surat keterangan ini dibuat dengan sebenar-benarnya, dan sebagai pernyataan mutlak
        apabila dikemudian hari keterangan yang saya sampaikan ini tidak benar, maka saya siap bertanggung jawab
        sesuai aturan yang berlaku.
    </p>

    <p class="penutup" style="margin-top: 6px;">
        Demikian Surat Keterangan ini dibuat untuk digunakan dalam pengugusan
        <strong>{{ $keperluan ?? $pengajuan->jenisSurat->nama }}</strong>.
    </p>

    {{-- TTD --}}
    <div class="ttd-wrapper">
        <p class="ttd-kota">Baturata, {{ \Carbon\Carbon::now()->isoFormat('D MMMM Y') }}</p>
        <p>Kepala Desa Baturata</p>
        <div class="ttd-kosong"></div>
        @php
            $pejabat = \App\Models\PejabatDesa::with(['user', 'jabatan'])
                ->where('is_aktif', 1)
                ->whereHas('jabatan', fn($q) => $q->where('nama_jabatan', 'like', '%Kepala Desa%'))
                ->first();
        @endphp
        <p class="ttd-nama">{{ $pejabat?->user?->name ?? 'KEPALA DESA BATURATA' }}</p>
        @if ($pejabat?->nip)
            <p class="ttd-nip">NIP. {{ $pejabat->nip }}</p>
        @endif
    </div>

    <div style="clear:both;"></div>
</body>

</html>
