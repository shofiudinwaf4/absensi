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

<body class="A4">
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
                        LAPORAN PRESENSI KARYAWAN <br>
                        PT. KREASI ASA INDONESIA<br>
                        PERIODE {{ strtoupper($namaBulan[$bulan]) }} {{ $tahun }} <br>
                    </span>
                    <span><i>Tulangan, Sidoarjo</i></span>
                </td>
            </tr>
        </table>
        <table class="tabledatakaryawan">
            <tr>
                <td rowspan="6">
                    @php
                        $path = asset('storage/public/uploads/karyawan/' . $karyawan->foto);
                    @endphp
                    <img src="{{ url($path) }}" alt="" width="150">
                </td>
            </tr>
            <tr>
                <td>NIK</td>
                <td>:</td>
                <td>{{ $karyawan->nik }}</td>
            </tr>
            <tr>
                <td>Nama Karyawan</td>
                <td>:</td>
                <td>{{ $karyawan->nama_lengkap }}</td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>:</td>
                <td>{{ $karyawan->jabatan }}</td>
            </tr>
            <tr>
                <td>Departemen</td>
                <td>:</td>
                <td>{{ $karyawan->nama_dept }}</td>
            </tr>
            <tr>
                <td>No. Hp</td>
                <td>:</td>
                <td>{{ $karyawan->no_hp }}</td>
            </tr>
        </table>
        <table class="tablepresensi">
            <tr>
                <th>No.</th>
                <th>Tanggal</th>
                <th>Jam Masuk</th>
                <th>Foto</th>
                <th>jam Pulang</th>
                <th>Foto</th>
                <th>Keterangan</th>
                <th>Jumlah Jam</th>
            </tr>
            @foreach ($presensi as $p)
                @php
                    $path_in = asset('storage/public/uploads/absensi/' . $p->foto_in);
                    $path_out = asset('storage/public/uploads/absensi/' . $p->foto_out);
                    $jamterlambat = selisih($p->jam_masuk, $p->jam_in);

                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ date('d-m-Y', strtotime($p->tgl_presensi)) }}</td>
                    <td>{{ $p->jam_in }}</td>
                    <td><img src="{{ url($path_in) }}" alt="" srcset="" class="foto"></td>
                    <td>{{ $p->jam_out != null ? $p->jam_out : 'Belum Absen' }}</td>
                    <td>
                        @if ($p->jam_out != null)
                            <img src="{{ url($path_out) }}" alt="" srcset="" class="foto">
                        @else
                            Belum Foto
                        @endif
                    </td>
                    <td>
                        @if ($p->jam_in > $p->jam_masuk)
                            Terlambat {{ $jamterlambat }}
                        @else
                            Tepat Waktu
                        @endif
                    </td>
                    <td>
                        @if ($p->jam_out != null)
                            @php
                                $jmljamkerja = selisih($p->jam_in, $p->jam_out);
                            @endphp
                        @else
                            @php

                                $jmljamkerja = 0;
                            @endphp
                        @endif
                        {{ $jmljamkerja }}
                    </td>
                </tr>
            @endforeach
        </table>
        <table width="100%" style="margin-top: 100px">
            <tr>
                <td style="text-align: right" colspan="2">Sidoarjo, {{ date('d-m-Y') }}</td>
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
