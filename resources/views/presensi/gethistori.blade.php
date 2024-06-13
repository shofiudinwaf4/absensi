@if ($histori->isEmpty())
    <div class="alert alert-outline-warning">
        <p>Data Masih Kosong</p>
    </div>
@endif
@foreach ($histori as $h)
    <ul class="listview image-listview">
        <li>
            <div class="item">
                {{-- @php
                    $path = Storage::url('uploads/absensi/' . $h->foto_in);
                @endphp
                <img src="{{ url($path) }}" alt="image" class="image"> --}}
                <div class="in">
                    <div>
                        <b>
                            {{ date('d-m-Y', strtotime($h->tgl_presensi)) }}
                        </b>
                        <br>
                        {{-- <small class="text-muted">{{ $b->jabatan }}</small> --}}
                    </div>
                    <div class="mt-2" id="keterangan">
                        <h4>{{ $h->nama_jam_kerja }}</h4>
                        @php
                            $jam_in = date('H:i', strtotime($h->jam_in));
                            $jam_masuk = date('H:i', strtotime($h->jam_masuk));
                            $jadwal_jam_masuk = $h->tgl_presensi . ' ' . $jam_masuk;
                            $jam_presensi = $h->tgl_presensi . ' ' . $jam_in;
                        @endphp
                        @if ($jam_in > $jam_masuk)
                            @php
                                $jumlahterlambat = hitungjamterlambat($jadwal_jam_masuk, $jam_presensi);
                                $jumlahterlambatdesimal = hitungjamterlambatdesimal($jadwal_jam_masuk, $jam_presensi);
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
        </li>
    </ul>
@endforeach
