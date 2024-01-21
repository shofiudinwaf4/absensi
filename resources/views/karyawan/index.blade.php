@extends('layout.admin.tabler')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <h2 class="page-title">
                        Data Karyawan
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <a href="" class="btn btn-primary" id="btnTambahKaryawan"><svg
                                            xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus"
                                            width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M12 5l0 14" />
                                            <path d="M5 12l14 0" />
                                        </svg>Tambah Data</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <form action="/karyawan " method="GET">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="nama_karyawan"
                                                        id="nama_karyawan" placeholder="Nama Karyawan"
                                                        value="{{ Request('nama_karyawan') }}">
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <select name="kode_dept" id="kode_dept" class="form-select">
                                                        <option value="">Departemen</option>
                                                        @foreach ($departemen as $d)
                                                            <option
                                                                {{ Request('kode_dept') == $d->kode_dept ? 'selected' : '' }}
                                                                value="{{ $d->kode_dept }}">{{ $d->nama_dept }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-primary"><svg
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            class="icon icon-tabler icon-tabler-search" width="24"
                                                            height="24" viewBox="0 0 24 24" stroke-width="2"
                                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                                            stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                                            <path d="M21 21l-6 -6" />
                                                        </svg>Cari</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">

                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <td>No.</td>
                                                <td>NIK</td>
                                                <td>Nama</td>
                                                <td>Jabatan</td>
                                                <td>No. Hp</td>
                                                <td>Foto</td>
                                                <td>Departemen</td>
                                                <td>Aksi</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($karyawan as $k)
                                                @php
                                                    $path = Storage::url('uploads/karyawan/' . $k->foto);
                                                @endphp
                                                <tr>
                                                    <td>{{ $loop->iteration + $karyawan->firstItem() - 1 }}</td>
                                                    <td>{{ $k->nik }}</td>
                                                    <td>{{ $k->nama_lengkap }}</td>
                                                    <td>{{ $k->jabatan }}</td>
                                                    <td>{{ $k->no_hp }}</td>
                                                    <td>
                                                        @if (empty($k->foto))
                                                            <img src="{{ asset('assets/img/default.png') }}" class="avatar">
                                                        @else
                                                            <img src="{{ url($path) }}" class="avatar">
                                                    </td>
                                            @endif
                                            <td>{{ $k->nama_dept }}</td>
                                            <td></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {{ $karyawan->links('vendor.pagination.bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal modal-blur fade" id="modal-inputKaryawan" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data Karyawan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="#" method="POST">
                        <div class="row">
                            <div class="col-12">
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon">
                                        <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-id"
                                            width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M3 4m0 3a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v10a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3z" />
                                            <path d="M9 10m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                            <path d="M15 8l2 0" />
                                            <path d="M15 12l2 0" />
                                            <path d="M7 16l10 0" />
                                        </svg>
                                    </span>
                                    <input type="text" value="NIK" name="nik" class="form-control"
                                        placeholder="NIK">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon">
                                        <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-id"
                                            width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M3 4m0 3a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v10a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3z" />
                                            <path d="M9 10m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                            <path d="M15 8l2 0" />
                                            <path d="M15 12l2 0" />
                                            <path d="M7 16l10 0" />
                                        </svg>
                                    </span>
                                    <input type="text" value="Nama Lengkap" name="nama_lengkap" class="form-control"
                                        placeholder="Nama Lengkap">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon">
                                        <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-id"
                                            width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M3 4m0 3a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v10a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3z" />
                                            <path d="M9 10m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                            <path d="M15 8l2 0" />
                                            <path d="M15 12l2 0" />
                                            <path d="M7 16l10 0" />
                                        </svg>
                                    </span>
                                    <input type="text" value="Jabatan" name="jabatan" class="form-control"
                                        placeholder="Jabatan">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon">
                                        <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-phone"
                                            width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2" />
                                        </svg>
                                    </span>
                                    <input type="text" value="No HP" name="no_hp" class="form-control"
                                        placeholder="No HP">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('myScript')
    <script>
        $(function() {
            $('#btnTambahKaryawan').click(function() {
                $("#modal-inputKaryawan").modal("show");
            });
        });
    </script>
@endpush
