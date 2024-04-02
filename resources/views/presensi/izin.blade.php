@extends('layout.presensi')
@section('header')
    <!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Data Izin / Sakit</div>
        <div class="right"></div>
    </div>
@endsection
@section('content')
    <div class="row" style="margin-top: 70px">
        <div class="col">
            @php
                $messageSuccess = Session::get('success');
                $messageError = Session::get('error');
            @endphp
            @if (Session::get('success'))
                <div class="alert alert-success">
                    {{ $messageSuccess }}
                </div>
            @elseif (Session::get('error'))
                <div class="alert alert-danger">
                    {{ $messageError }}
                </div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col">
            @foreach ($dataizin as $di)
                <ul class="listview image-listview">
                    <li>
                        <div class="item">
                            <div class="in">
                                <div>
                                    <b>
                                        {{ date('d-m-Y', strtotime($di->tgl_izin)) }}
                                        ({{ $di->status == 's' ? 'sakit' : 'izin' }})
                                    </b>
                                    <br>
                                    <small class="text-muted">{{ $di->keterangan }}</small>
                                </div>
                                @if ($di->status_approved == 0)
                                    <span class="badge bg-warning">Diproses</span>
                                @elseif ($di->status_approved == 1)
                                    <span class="badge bg-success">Disetujui</span>
                                @elseif ($di->status_approved == 2)
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </div>
                        </div>
                    </li>
                </ul>
            @endforeach
        </div>

    </div>
    {{-- flying button --}}
    <div class="fab-button bottom-right" style="margin-bottom: 70px">
        <a href="/presensi/buatizin" class="fab"><ion-icon name="add-outline"></ion-icon></a>
    </div>
@endsection
