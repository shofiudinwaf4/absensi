@extends('layout.admin.tabler')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <h2 class="page-title">
                        Konfigurasi Lokasi
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        @if (Session::get('success'))
                            <div class="alert alert-success">
                                {{ session::get('success') }}
                            </div>
                        @elseif (Session::get('warning'))
                            <div class="alert alert-warning">
                                {{ session::get('warning') }}
                            </div>
                        @endif
                        <form action="/konfigurasi/updatelokasikantor" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <label for="" class="form-label">Lokasi Kantor</label>
                                    <div class="input-icon mb-3">
                                        <span class="input-icon-addon">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-tabler icon-tabler-map-2" width="24" height="24"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M12 18.5l-3 -1.5l-6 3v-13l6 -3l6 3l6 -3v7.5" />
                                                <path d="M9 4v13" />
                                                <path d="M15 7v5.5" />
                                                <path
                                                    d="M21.121 20.121a3 3 0 1 0 -4.242 0c.418 .419 1.125 1.045 2.121 1.879c1.051 -.89 1.759 -1.516 2.121 -1.879z" />
                                                <path d="M19 18v.01" />
                                            </svg>
                                        </span>
                                        <input type="text" name="lokasi_kantor"
                                            value="{{ $konfigurasi_kantor->lokasi_kantor }}" id="lokasi_kantor"
                                            class="form-control" placeholder="Lokasi Kantor">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <label for="" class="form-label">Radius Kantor</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="radius" autocomplete="off"
                                            name="radius" value="{{ $konfigurasi_kantor->radius }}" id="radius">
                                        <span class="input-group-text">
                                            Meter
                                        </span>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="row">
                                <div class="col-6">
                                    <label class="form-label">Jam Masuk</label>
                                    <input type="text" name="jam_masuk" id="jam_masuk"
                                        value="{{ $konfigurasi_kantor->jam_masuk }}" class="form-control"
                                        data-mask="00:00:00" data-mask-visible="true" placeholder="00:00:00"
                                        autocomplete="off">

                                </div>
                            </div> --}}
                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="form-group">
                                        <button type="submit" name="cetak" class="btn btn-primary w-100">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-tabler icon-tabler-refresh" width="24" height="24"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4" />
                                                <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4" />
                                            </svg>
                                            Update</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
