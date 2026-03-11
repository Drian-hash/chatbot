<!DOCTYPE html>
<html>

<head>

    <title>Laporan TTE</title>

    <style>
        body {
            margin: 0;
            background: #525659;
            font-family: Arial, Helvetica, sans-serif;
        }

        /* area preview */

        .preview {

            width: 100%;
            height: 100vh;

            display: flex;
            justify-content: center;
            align-items: flex-start;

            padding-top: 30px;

        }

        /* kertas A4 */

        .paper {

            width: 210mm;
            min-height: 297mm;

            background: white;

            padding: 25px 30px;

            box-shadow: 0 0 10px rgba(0, 0, 0, 0.6);

        }

        /* judul */

        .title {

            text-align: center;
            font-size: 16px;
            font-weight: bold;

            margin-bottom: 15px;

        }

        /* tabel */

        table {

            width: 100%;
            border-collapse: collapse;

            font-size: 11px;

        }

        table th {

            border: 1px solid #000;
            padding: 4px 6px;

            background: #f2f2f2;

        }

        table td {

            border: 1px solid #000;
            padding: 3px 6px;

        }
    </style>

</head>

<body>

    <div class="preview">

        <div class="paper">

            <div class="title">

                LAPORAN PERMOHONAN TTE

            </div>

            <table>

                <thead>

                    <tr>

                        <th width="40">No</th>
                        <th>Nama</th>
                        <th width="120">NIP</th>
                        <th>OPD</th>
                        <th width="120">No HP</th>
                        <th>Jenis Permohonan</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach ($tte as $i => $item)
                        <tr>

                            <td align="center">{{ $i + 1 }}</td>
                            <td>{{ $item->nama_lengkap }}</td>
                            <td>{{ $item->nip }}</td>
                            <td>{{ $item->opd }}</td>
                            <td>{{ $item->no_hp }}</td>
                            <td>{{ $item->jenis_permohonan }}</td>

                        </tr>
                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

    <script>
        window.onload = function() {

            window.print();

        }
    </script>

</body>

</html>
