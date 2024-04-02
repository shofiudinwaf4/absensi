@extends('layout.admin.tabler')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <h2 class="page-title">
                        Edit Set Jam Kerja </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <div class="col-12">

                    <table class="table">
                        <tr>
                            <th>NIK</th>
                            <th>{{ $karyawan->nik }}</th>
                        </tr>
                        <tr>
                            <th>Nama Karyawan</th>
                            <th>{{ $karyawan->nama_lengkap }}</th>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <form action="/konfigurasi/updatesetjamkerja" method="POST">
                        @csrf
                        <input type="hidden" name="nik" id="" value="{{ $karyawan->nik }}">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Hari</th>
                                    <th>Jam Kerja</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($setjamkerja as $sjk)
                                    <tr>
                                        <td>
                                            {{ $sjk->hari }}
                                            <input type="hidden" name="hari[]" value="{{ $sjk->hari }}">
                                        </td>
                                        <td><select name="kode_jam_kerja[]" id="kode_jam_kerja" class="form-select">
                                                <option value="">Pilih Jam Kerja</option>
                                                @foreach ($jamkerja as $jk)
                                                    <option
                                                        {{ $jk->kode_jam_kerja == $sjk->kode_jam_kerja ? 'selected' : '' }}
                                                        value="{{ $jk->kode_jam_kerja }}">
                                                        {{ $jk->nama_jam_kerja }}
                                                    </option>
                                                @endforeach
                                            </select></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <button class="btn btn-primary w-100" type="submit">Update</button>
                    </form>
                </div>
                <div class="col-6">
                    <table class="table">
                        <thead>
                            <tr>
                                <th colspan="6">Master Jam Kerja</th>
                            </tr>
                            <tr>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Awal Masuk</th>
                                <th>jam Masuk</th>
                                <th>Akhir Masuk</th>
                                <th>Jam Pulang</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jamkerja as $jk)
                                <tr>
                                    <td>{{ $jk->kode_jam_kerja }}</td>
                                    <td>{{ $jk->nama_jam_kerja }}</td>
                                    <td>{{ $jk->awal_jam_masuk }}</td>
                                    <td>{{ $jk->jam_masuk }}</td>
                                    <td>{{ $jk->akhir_jam_masuk }}</td>
                                    <td>{{ $jk->jam_pulang }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
