@extends('layout.presensi')
@section('content')
    <div class="section" id="user-section">
        <div id="user-detail">
            <div class="avatar">
                @if (!empty(Auth::guard('karyawan')->user()->foto))
                    {{-- @php
                        $path = Storage::url('public/public/uploads/karyawan/' . Auth::guard('karyawan')->user()->foto);

                    @endphp --}}
                    {{-- <img src="{{ url($path) }}" alt="avatar" class="imaged w48 rounded"> --}}
                    <img src="{{ asset('storage/public/uploads/karyawan/' . Auth::guard('karyawan')->user()->foto) }}"
                        alt="avatar" class="imaged w48 rounded">
                @endif
            </div>
            <div id="user-info">
                <h2 id="user-name">{{ Auth::guard('karyawan')->user()->nama_lengkap }}</h2>
                <span id="user-role">{{ Auth::guard('karyawan')->user()->jabatan }}</span>
            </div>
        </div>
    </div>

    <div class="section" id="menu-section">
        <div class="card">
            <div class="card-body text-center">
                <div class="list-menu">
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="/Profile" class="green" style="font-size: 40px;">
                                <ion-icon name="person-sharp"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            <span class="text-center">Profil</span>
                        </div>
                    </div>
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="/presensi/izin" class="danger" style="font-size: 40px;">
                                <ion-icon name="calendar-number"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            <span class="text-center">Cuti</span>
                        </div>
                    </div>
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="/presensi/history" class="warning" style="font-size: 40px;">
                                <ion-icon name="document-text"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            <span class="text-center">Histori</span>
                        </div>
                    </div>
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="" class="orange" style="font-size: 40px;">
                                <ion-icon name="location"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            Lokasi
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="section mt-2" id="presence-section">
        <div class="todaypresence">
            <div class="row">
                <div class="col-6">
                    <div class="card gradasigreen">
                        <div class="card-body">
                            <div class="presencecontent">
                                {{-- <div class="iconpresence">
                                    @if ($presensiHariIni != null) --}}
                                {{-- @php
                                            $path = Storage::url('uploads/absensi/' . $presensiHariIni->foto_in);
                                        @endphp
                                        <img src="{{ url($path) }}" alt="" class="imaged w64"> --}}
                                {{-- <img src="{{ asset('storage/public/uploads/absensi/' . $presensiHariIni->foto_in) }}"
                                    alt="" class="imaged w48"> --}}
                                {{-- @else
                                        <ion-icon name="camera"></ion-icon>
                                    @endif
                                </div> --}}
                                <div class="presencedetail">
                                    <h4 class="presencetitle">Masuk</h4>
                                    <span>{{ $presensiHariIni != null ? $presensiHariIni->jam_in : 'Belum Absen' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card gradasired">
                        <div class="card-body">
                            <div class="presencecontent">
                                {{-- <div class="iconpresence">
                                    @if ($presensiHariIni != null && $presensiHariIni->jam_out != null)
                                        <img src="{{ asset('storage/public/uploads/absensi/' . $presensiHariIni->foto_out) }}"
                                            alt="" class="imaged w48">
                                    @else
                                        <ion-icon name="camera"></ion-icon>
                                    @endif
                                </div> --}}
                                <div class="presencedetail">
                                    <h4 class="presencetitle">Pulang</h4>
                                    <span>{{ $presensiHariIni != null && $presensiHariIni->jam_out != null ? $presensiHariIni->jam_out : 'Belum Absen' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="rekappresensi">
            <h3 class="text-center">Rekap Presensi Bulan {{ $namaBulan[$bulanIni] . ' ' . $tahunIni }} </h3>
            <div class="row">
                <div class="col-4">
                    <div class="card">
                        <div class="card-body text-center" style="padding: 12px 12px !important; line-height: 0.8rem">
                            <span class="badge bg-danger"
                                style="position: absolute; top: 3px; right: 10px; font-size: 0.5rem; z-index: 999">{{ $rekapPresensi->jmlHadir }}</span>
                            <ion-icon name="accessibility-outline" style="font-size: 1.6rem;"
                                class="text-primary mb-1"></ion-icon>
                            <br>
                            <span>Hadir</span>
                        </div>
                    </div>
                </div>
                @php
                    $jml = $rekapizin->jmlizin + $rekapizin->jmlsakit;
                @endphp
                <div class="col-4">
                    <div class="card">
                        <div class="card-body text-center" style="padding: 12px 12px !important; line-height: 0.8rem">
                            <span class="badge bg-danger"
                                style="position: absolute; top: 3px; right: 10px; font-size: 0.5rem; z-index: 999">{{ $jml }}</span>
                            <ion-icon name="reader-outline" style="font-size: 1.6rem;"
                                class="text-success mb-1"></ion-icon><br>
                            <span>Izin</span>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-3">
                    <div class="card">
                        <div class="card-body text-center" style="padding: 12px 12px !important; line-height: 0.8rem">
                            <span class="badge bg-danger"
                                style="position: absolute; top: 3px; right: 10px; font-size: 0.5rem; z-index: 999">{{ $rekapizin->jmlsakit }}</span>
                            <ion-icon name="medkit-outline" style="font-size: 1.6rem;"
                                class="text-warning mb-1"></ion-icon>
                            <span>Sakit</span>
                        </div>
                    </div>
                </div> --}}
                <div class="col-4">
                    <div class="card">
                        <div class="card-body text-center" style="padding: 12px 12px !important; line-height: 0.8rem">
                            <span class="badge bg-danger"
                                style="position: absolute; top: 3px; right: 10px; font-size: 0.5rem; z-index: 999">{{ $rekapPresensi->jmlTerlambat }}</span>
                            <ion-icon name="alarm-outline" style="font-size: 1.6rem;"
                                class="text-danger mb-1"></ion-icon><br>
                            <span>Telat</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="presencetab mt-2">
            <div class="tab-pane fade show active" id="pilled" role="tabpanel">
                <ul class="nav nav-tabs style1" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#home" role="tab">
                            Bulan Ini
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#profile" role="tab">
                            Leaderboard
                        </a>
                    </li>
                </ul>
            </div>
            <div class="tab-content mt-2" style="margin-bottom:100px;">
                <div class="tab-pane fade show active" id="home" role="tabpanel">
                    <ul class="listview image-listview">
                        {{-- @foreach ($historyBulanIni as $d)
                            @php
                                $path = Storage::url('uploads/absensi/' . $d->foto_in);
                            @endphp
                            <li>
                                <div class="item">
                                    <div class="icon-box bg-primary">
                                        <ion-icon name="image-outline" role="img" class="md hydrated"
                                            aria-label="image outline"></ion-icon>
                                    </div>
                                    <div class="in">
                                        <div>{{ date('d-m-Y', strtotime($d->tgl_presensi)) }}</div>
                                        <span class="badge badge-success">{{ $d->jam_in }}</span>
                                        <span
                                            class="badge badge-danger">{{ $presensiHariIni != null && $d->jam_out != null ? $d->jam_out : 'Belum Absen' }}</span>
                                    </div>
                                </div>
                            </li>
                        @endforeach --}}
                        <style>
                            .historicontent {
                                display: flex;
                            }

                            .datapresensi {
                                margin-left: 10px;
                            }
                        </style>
                        @foreach ($historyBulanIni as $hbi)
                            <div class="card">
                                <div class="card-body">
                                    <div class="historicontent">
                                        <div class="iconpresensi">
                                            <ion-icon name="finger-print-outline" role="img"
                                                class="md hydrated text-success" aria-label="image outline"
                                                style="font-size: 38px"></ion-icon>
                                        </div>
                                        <div class="datapresensi">
                                            <h3 style="line-height: 3px">{{ $hbi->nama_jam_kerja }}</h3>
                                            <h4 style="margin:0px !important">
                                                {{ date('d-m-Y', strtotime($hbi->tgl_presensi)) }}</h4>
                                            <span>{!! $hbi->jam_in != null ? date('H:i', strtotime($hbi->jam_in)) : '<span class="text-danger">Belum Absen</span>' !!}
                                            </span>
                                            <span>{!! $hbi->jam_out != null
                                                ? '- ' . date('H:i', strtotime($hbi->jam_out))
                                                : '<span class="text-danger">- Belum Absen</span>' !!}
                                            </span>
                                            <div class="mt-2" id="keterangan">
                                                @php
                                                    $jam_in = date('H:i', strtotime($hbi->jam_in));
                                                    $jam_masuk = date('H:i', strtotime($hbi->jam_masuk));
                                                    $jadwal_jam_masuk = $hbi->tgl_presensi . ' ' . $jam_masuk;
                                                    $jam_presensi = $hbi->tgl_presensi . ' ' . $jam_in;
                                                @endphp
                                                @if ($jam_in > $jam_masuk)
                                                    @php
                                                        $jumlahterlambat = hitungjamterlambat(
                                                            $jadwal_jam_masuk,
                                                            $jam_presensi,
                                                        );
                                                        $jumlahterlambatdesimal = hitungjamterlambatdesimal(
                                                            $jadwal_jam_masuk,
                                                            $jam_presensi,
                                                        );
                                                    @endphp
                                                    <span class="danger">Terlambat
                                                        ({{ $jumlahterlambat }} Jam)
                                                    </span>
                                                @else
                                                    <span style="color: green">Tepat Waktu</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </ul>
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel">
                    <ul class="listview image-listview">
                        @foreach ($leaderboard as $b)
                            <li>
                                <div class="item">
                                    <img src="assets/img/sample/avatar/avatar1.jpg" alt="image" class="image">
                                    <div class="in">
                                        <div>
                                            <b>
                                                {{ $b->nama_lengkap }}
                                            </b>
                                            <br>
                                            <small class="text-muted">{{ $b->jabatan }}</small>
                                        </div>
                                        <span
                                            class="badge {{ $b->jam_in < '07:00' ? 'bg-success' : 'bg-danger' }}">{{ $b->jam_in }}</span>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

            </div>
        </div>
    </div>
@endsection
