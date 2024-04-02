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
                    <span class="badge {{ $h->jam_in < $h->jam_masuk ? 'bg-success' : 'bg-danger' }}">{{ $h->jam_in }}
                    </span>
                    <span class="badge bg-primary">{{ $h->jam_out }}</span>
                </div>
            </div>
        </li>
    </ul>
@endforeach
