<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Draf Surat - {{ $pengajuan->kode_pengajuan }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11pt;
            line-height: 1.5;
            padding: 1cm 2cm;
        }

        .kop {
            text-align: center;
            border-bottom: 3px solid black;
            padding-bottom: 5px;
            margin-bottom: 20px;
        }

        .judul {
            text-transform: uppercase;
            font-weight: bold;
            font-size: 14pt;
            text-align: center;
            text-decoration: underline;
        }

        .nomor {
            text-align: center;
            margin-bottom: 30px;
            font-size: 11pt;
        }

        .isi {
            margin-top: 20px;
            text-align: justify;
        }

        .ttd {
            width: 250px;
            float: right;
            margin-top: 50px;
            text-align: center;
        }

        table.biodata {
            width: 100%;
            margin: 15px 0;
            border-collapse: collapse;
        }

        table.biodata td {
            padding: 4px 0;
            vertical-align: top;
        }

        table.biodata td:first-child {
            width: 170px;
        }

        table.biodata td:nth-child(2) {
            width: 15px;
        }

        .watermark {
            position: absolute;
            top: 40%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 80pt;
            color: rgba(255, 0, 0, 0.1);
            z-index: -1;
            font-weight: bold;
            white-space: nowrap;
        }
    </style>
</head>

<body>
    @if ($pengajuan->status === 'validated' || $pengajuan->status === 'in_process')
        <div class="watermark">DRAF SURAT</div>
    @endif

    <div class="kop">
        <h2 style="margin:0;font-size:16pt;">PEMERINTAH KABUPATEN BOGOR</h2>
        <h3 style="margin:0;font-size:14pt;">KECAMATAN CIBINONG</h3>
        <h1 style="margin:0;font-size:18pt;">DESA CIPAMUJUHAN</h1>
        <p style="margin:5px 0 0; font-size:10pt;">Jl. Raya Cipamujuhan No. 123, Telp. (021) 1234567, Kode Pos 16911</p>
    </div>

    <div class="judul">{{ $pengajuan->jenisSurat->nama }}</div>
    <div class="nomor">Nomor: {{ $pengajuan->nomor_surat ?? '....... / ....... / .......' }}</div>

    <div class="isi">
        <p>Yang bertanda tangan di bawah ini Kepala Desa Cipamujuhan, Kecamatan Cibinong, Kabupaten Bogor, menerangkan
            dengan sebenarnya bahwa:</p>

        <table class="biodata">
            <tr>
                <td>Nama Lengkap</td>
                <td>:</td>
                <td><strong>{{ $pengajuan->biodata->user->name }}</strong></td>
            </tr>
            <tr>
                <td>NIK / No. KTP</td>
                <td>:</td>
                <td>{{ $pengajuan->biodata->nik }}</td>
            </tr>
            <tr>
                <td>No. KK</td>
                <td>:</td>
                <td>{{ $pengajuan->biodata->nomor_kk ?? '-' }}</td>
            </tr>
            <tr>
                <td>Tempat, Tanggal Lahir</td>
                <td>:</td>
                <td>{{ $pengajuan->biodata->tempat_lahir }},
                    {{ \Carbon\Carbon::parse($pengajuan->biodata->tanggal_lahir)->isoFormat('D MMMM Y') }}</td>
            </tr>
            <tr>
                <td>Jenis Kelamin</td>
                <td>:</td>
                <td>{{ $pengajuan->biodata->jenis_kelamin }}</td>
            </tr>
            <tr>
                <td>Agama</td>
                <td>:</td>
                <td>{{ $pengajuan->biodata->agama->agama ?? '-' }}</td>
            </tr>
            <tr>
                <td>Pekerjaan</td>
                <td>:</td>
                <td>{{ $pengajuan->biodata->pekerjaan->pekerjaan ?? '-' }}</td>
            </tr>
            <tr>
                <td>Alamat Lengkap</td>
                <td>:</td>
                <td>
                    {{ $pengajuan->biodata->alamat_lengkap }}<br>
                    RT {{ $pengajuan->biodata->rt->nama ?? '-' }} / RW
                    {{ $pengajuan->biodata->rt->rw->nama ?? '-' }},<br>
                    Dusun {{ $pengajuan->biodata->rt->rw->dusun->nama ?? '-' }}
                </td>
            </tr>
        </table>

        @if ($pengajuan->field_data && is_array($pengajuan->field_data))
            <p style="margin-top: 15px;">Menerangkan dengan sesungguhnya bahwa nama tersebut di atas benar warga Desa
                Cipamujuhan dan surat keterangan ini dibuat untuk keperluan:</p>
            <table class="biodata" style="margin-left: 20px; margin-top: 10px;">
                @foreach ($pengajuan->field_data as $key => $value)
                    @php
                        $fieldLabel = ucwords(str_replace('_', ' ', $key));
                        if (isset($pengajuan->jenisSurat->fields) && count($pengajuan->jenisSurat->fields) > 0) {
                            $field = collect($pengajuan->jenisSurat->fields)->firstWhere('field_key', $key);
                            if ($field) {
                                $fieldLabel = $field['field_label'] ?? $field->field_label;
                            }
                        }
                    @endphp
                    <tr>
                        <td style="width: 150px;">{{ $fieldLabel }}</td>
                        <td style="width: 15px;">:</td>
                        <td><strong>{{ is_array($value) ? implode(', ', $value) : $value }}</strong></td>
                    </tr>
                @endforeach
            </table>
        @else
            <p>Adalah benar warga kami yang berdomisili di alamat tersebut di atas.</p>
        @endif

        <p style="margin-top: 20px;">Demikian surat keterangan ini dibuat dengan sebenar-benarnya untuk dapat
            dipergunakan sebagaimana mestinya.</p>
    </div>

    <div class="ttd">
        <p>Cipamujuhan, {{ \Carbon\Carbon::now()->isoFormat('D MMMM Y') }}<br>Kepala Desa Cipamujuhan</p>
        <br><br><br><br>
        <p style="font-weight:bold;text-decoration:underline;margin-bottom:0;">[ NAMA KEPALA DESA ]</p>
        <p style="margin:0;">NIP. [ NIP KEPALA DESA ]</p>
    </div>
</body>

</html>
