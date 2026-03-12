<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan TTE</title>

    <style>
        @page {
            size: A4;
            margin: 20mm;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 13px;
            margin: 0;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .container {
            width: 210mm;
            min-height: 297mm;
            margin: auto;
            background: white;
        }

        /* HEADER */

        .kop {
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            position: relative;
            padding-top: 10px;
        }

        .logo {
            position: absolute;
            left: 0;
            top: 5px;
            width: 85px;
        }

        .kop-text h2 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }

        .kop-text h3 {
            margin: 2px 0;
            font-size: 22px;
            font-weight: bold;
        }

        .kop-text p {
            margin: 2px 0;
            font-size: 13px;
        }

        /* GARIS KOP */

        .kop-line {
            width: 100%;
            margin-top: 10px;
        }

        .kop-line1 {
            border-top: 2px solid #000;
        }

        .kop-line2 {
            border-top: 1px solid #000;
            margin-top: 3px;
        }

        /* JUDUL */

        .judul {
            text-align: center;
            margin-top: 15px;
            font-weight: bold;
            font-size: 16px;
        }

        /* TABLE */

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th {
            background: #bcd0d6;
            border: 0.6px solid #555;
            padding: 8px;
            text-align: center;
        }

        td {
            vertical-align: top;
        }

        table td {
            border: 0.6px solid #555;
            padding: 8px;
        }

        .center {
            text-align: center;
        }

        .highlight {
            background: #f1e2a7;
            font-weight: bold;
        }
    </style>

</head>


<body onload="window.print()">

    <div class="container">

        <!-- KOP SURAT -->

        <div class="kop">

            <img src="{{ asset('images/logo/ktp.png') }}" class="logo">

            <div class="kop-text">

                <h2>PEMERINTAH KABUPATEN KETAPANG</h2>
                <h3>DINAS KOMUNIKASI DAN INFORMATIKA</h3>

                <p>Jalan Jurip Sumoharjo No.06 Ketapang Kode Pos 78811</p>
                <p>Email : diskominfo@ketapangkab.go.id</p>
                <p>Website : https://diskominfo.ketapangkab.go.id</p>

            </div>

        </div>

        <div class="kop-line">
            <div class="kop-line1"></div>
            <div class="kop-line2"></div>
        </div>

        @php

            $bulanIndonesia = [
                1 => 'JANUARI',
                2 => 'FEBRUARI',
                3 => 'MARET',
                4 => 'APRIL',
                5 => 'MEI',
                6 => 'JUNI',
                7 => 'JULI',
                8 => 'AGUSTUS',
                9 => 'SEPTEMBER',
                10 => 'OKTOBER',
                11 => 'NOVEMBER',
                12 => 'DESEMBER',
            ];

            $penerbitan = $tte->where('jenis_permohonan', 'Permohonan TTE Baru (Belum Mempunyai TTE)')->count();
            $reset = $tte->where('jenis_permohonan', 'Lupa Passphrase TTE')->count();
            $pembaharuan = $tte->where('jenis_permohonan', 'Pembaharuan TTE ( TTE Expired)')->count();
            $total = $tte->count();

        @endphp


        <div class="judul">

            LAPORAN PELAYANAN TANDA TANGAN ELEKTRONIK
            <br>

            BULAN {{ $bulanIndonesia[(int) $bulan] ?? '' }} TAHUN {{ $tahun }}

        </div>


        <table>

            <thead>
                <tr>
                    <th>Tanggal & Waktu Permohonan</th>
                    <th>Nama Pemohon</th>
                    <th>NIP</th>
                    <th>OPD</th>
                    <th>Kontak Pemohon</th>
                    <th>Jenis Permohonan TTE</th>
                </tr>
            </thead>


            <tbody>

                @forelse($tte as $row)
                    <tr>

                        <td class="center">
                            {{ \Carbon\Carbon::parse($row->timestamp)->format('d/m/Y H:i:s') }}
                        </td>

                        <td>{{ $row->nama_lengkap }}</td>

                        <td class="center">{{ $row->nip }}</td>

                        <td>{{ $row->opd }}</td>

                        <td class="center">{{ $row->no_hp }}</td>

                        <td>{{ $row->jenis_permohonan }}</td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="6" class="center">
                            Data tidak ditemukan
                        </td>
                    </tr>
                @endforelse


                <!-- KETERANGAN + RINGKASAN -->

                <tr>

                    <td style="border-top:none; border-right:none; width:140px; vertical-align:top; padding-top:16px;">
                        <b>Keterangan</b>
                    </td>

                    <td
                        style="border-top:none; border-left:none; border-right:none; width:15px; vertical-align:top; padding-top:16px;">
                        :
                    </td>

                    <td colspan="2"
                        style="border-top:none; border-left:none; border-right:none; padding-top:16px; padding-left:10px; line-height:1.7;">

                        Sumber Form Permohonan Pelayanan Sertifikat Elektronik<br>
                        https://bit.ly/form_permohonan_tte<br>
                        Tim Pelayanan Sertifikat Elektronik

                    </td>

                    <td colspan="2" style="border-left:none; border-top:none; width:220px; padding-top:16px;">

                        <table style="width:100%; border-collapse:collapse;">

                            <tr>
                                <td style="border:none; width:120px;">Penerbitan</td>
                                <td style="border:none; width:10px;">:</td>
                                <td style="border:none;">{{ $penerbitan }}</td>
                            </tr>

                            <tr>
                                <td style="border:none;">Reset</td>
                                <td style="border:none;">:</td>
                                <td style="border:none;">{{ $reset }}</td>
                            </tr>

                            <tr>
                                <td style="border:none;">Pembaharuan</td>
                                <td style="border:none;">:</td>
                                <td style="border:none;">{{ $pembaharuan }}</td>
                            </tr>

                            <tr class="highlight">
                                <td style="border:none;">Total Layanan</td>
                                <td style="border:none;">:</td>
                                <td style="border:none;">{{ $total }} Layanan Tercatat</td>
                            </tr>

                        </table>

                    </td>

                </tr>


            </tbody>

        </table>

    </div>

</body>

</html>
