<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>A4</title>

    <!-- Normalize or reset CSS with your favorite library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">

    <!-- Load paper.css for happy printing -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">

    <!-- Set page size here: A5, A4 or A3 -->
    <!-- Set also "landscape" if you need -->
    <style>
        @page {
            size: A4
        }

        #title {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 18px;
            font-weight: bold;
        }

        .tabledatakaryawan {
            margin-top: 40px
        }

        .tabledatakaryawan tr td {
            padding: 5px
        }

        .tablepresensi {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .tablepresensi tr th {
            border: 2px solid black;
            padding: 8px;
            background-color: rgb(201, 201, 201);
            font-size: 10px;
        }

        .tablepresensi tr td {
            border: 2px solid black;
            padding: 5px;
            font-size: 17px;
        }

        .foto {
            width: 40px;
            height: 40px
        }
    </style>
</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->

<body class="landscape">
    @php
        function selisih($jam_masuk, $jam_keluar)
        {
            [$h, $m, $s] = explode(':', $jam_masuk);
            $dtAwal = mktime($h, $m, $s, '1', '1', '1');
            [$h, $m, $s] = explode(':', $jam_keluar);
            $dtAkhir = mktime($h, $m, $s, '1', '1', '1');
            $dtSelisih = $dtAkhir - $dtAwal;
            $totalmenit = $dtSelisih / 60;
            $jam = explode('.', $totalmenit / 60);
            $sisamenit = $totalmenit / 60 - $jam[0];
            $sisamenit2 = $sisamenit * 60;
            $jml_jam = $jam[0];
            return $jml_jam . ':' . round($sisamenit2);
        }
    @endphp
    <!-- Each sheet element should have the class "sheet" -->
    <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
    <section class="sheet padding-10mm">

        <!-- Write HTML just like a web page -->
        <table style="width: 100%">
            <tr>
                <td style="width: 30px">
                    <img src="{{ asset('assets/img/kreasiai.png') }}" alt="" width="80" height="80">
                </td>
                <td>
                    <span id="title">
                        REKAP PRESENSI KARYAWAN <br>
                        PT. KREASI ASA INDONESIA<br>
                        PERIODE {{ strtoupper($namaBulan[$bulan]) }} {{ $tahun }} <br>
                    </span>
                    <span><i>Tulangan, Sidoarjo</i></span>
                </td>
            </tr>
        </table>
        <table class="tablepresensi">
            <tr>
                <th rowspan="2">NIK</th>
                <th rowspan="2">Nama Karyawan</th>
                <th colspan="31">Tanggal</th>
                <th rowspan="2">Total <br> Hadir</th>
                <th rowspan="2">Total <br>Terlambat</th>
            </tr>
            <tr>
                <?php for ($i=1; $i <= 31; $i++) { 
                 ?> <th>{{ $i }}</th>
                <?php } ?>
            </tr>
            @foreach ($rekap as $r)
                <tr style="text-align: center">
                    <td>{{ $r->nik }}</td>
                    <td>{{ $r->nama_lengkap }}</td>
                    <?php
                    $totalhadir = 0;
                    $totalterlambat =0;
                    for ($i=1; $i <= 31; $i++) { 
                        $tgl = "tgl_".$i;
                        if (empty($r->$tgl)) {
                            $hadir = ['',''];
                            $totalhadir += 0;
                        }else {
                            # code...
                            $hadir = explode("-",$r->$tgl);
                            $totalhadir += 1;
                            if ($hadir[0]>$r->jam_masuk) {
                                $totalterlambat +=1;
                            }
                        }
                    ?>
                    <td>
                        <span
                            style="color:  {{ $hadir[0] > $r->jam_masuk ? 'red' : '' }}">{{ !empty($hadir[0]) ? $hadir[0] : '-' }}</span><br>
                        <span
                            style="color:  {{ $hadir[1] < $r->jam_pulang ? 'red' : '' }}">{{ !empty($hadir[1]) ? $hadir[1] : '-' }}</span>
                    </td>
                    <?php } ?>
                    <td>{{ $totalhadir }}</td>
                    <td>{{ $totalterlambat }}</td>
                </tr>
            @endforeach
        </table>
        <table width="100%" style="margin-top: 100px">
            <tr>
                <td></td>
                <td style="text-align: center">Sidoarjo, {{ date('d-m-Y') }}</td>
            </tr>
            <tr>
                <td style="text-align: center;vertical-align: bottom; height:100px">
                    <u>
                        Gogot Alam Anpurnan <br>
                        <i><b>Direktur</b></i>
                    </u>
                </td>
                <td style="text-align: center; vertical-align: bottom; height:100px">
                    <u>
                        Ahmad Shofiudin Firdani Wafa <br>
                        <i><b>Komisaris</b></i>
                    </u>
                </td>
            </tr>
        </table>
    </section>

</body>

</html>
