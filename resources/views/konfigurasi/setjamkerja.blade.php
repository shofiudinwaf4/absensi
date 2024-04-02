@extends('layout.admin.tabler')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <h2 class="page-title">
                        Set Jam Kerja </h2>
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
                    <form action="/konfigurasi/storesetjamkerja" method="POST">
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
                                <tr>
                                    <td>Senin
                                        <input type="hidden" name="hari[]" value="senin">
                                    </td>
                                    <td><select name="kode_jam_kerja[]" id="kode_jam_kerja" class="form-select">
                                            <option value="">Pilih Jam Kerja</option>
                                            @foreach ($jamkerja as $jk)
                                                <option value="{{ $jk->kode_jam_kerja }}">{{ $jk->nama_jam_kerja }}</option>
                                            @endforeach
                                        </select></td>
                                </tr>
                                <tr>
                                    <td>Selasa
                                        <input type="hidden" name="hari[]" value="selasa">
                                    </td>
                                    <td><select name="kode_jam_kerja[]" id="kode_jam_kerja" class="form-select">
                                            <option value="">Pilih Jam Kerja</option>
                                            @foreach ($jamkerja as $jk)
                                                <option value="{{ $jk->kode_jam_kerja }}">{{ $jk->nama_jam_kerja }}</option>
                                            @endforeach
                                        </select></td>
                                </tr>
                                <tr>
                                    <td>Rabu<input type="hidden" name="hari[]" value="rabu"></td>
                                    <td><select name="kode_jam_kerja[]" id="kode_jam_kerja" class="form-select">
                                            <option value="">Pilih Jam Kerja</option>
                                            @foreach ($jamkerja as $jk)
                                                <option value="{{ $jk->kode_jam_kerja }}">{{ $jk->nama_jam_kerja }}</option>
                                            @endforeach
                                        </select></td>
                                </tr>
                                <tr>
                                    <td>Kamis<input type="hidden" name="hari[]" value="kamis"></td>
                                    <td><select name="kode_jam_kerja[]" id="kode_jam_kerja" class="form-select">
                                            <option value="">Pilih Jam Kerja</option>
                                            @foreach ($jamkerja as $jk)
                                                <option value="{{ $jk->kode_jam_kerja }}">{{ $jk->nama_jam_kerja }}
                                                </option>
                                            @endforeach
                                        </select></td>
                                </tr>
                                <tr>
                                    <td>Jumat<input type="hidden" name="hari[]" value="jumat"></td>
                                    <td><select name="kode_jam_kerja[]" id="kode_jam_kerja" class="form-select">
                                            <option value="">Pilih Jam Kerja</option>
                                            @foreach ($jamkerja as $jk)
                                                <option value="{{ $jk->kode_jam_kerja }}">{{ $jk->nama_jam_kerja }}
                                                </option>
                                            @endforeach
                                        </select></td>
                                </tr>
                                <tr>
                                    <td>Sabtu<input type="hidden" name="hari[]" value="sabtu"></td>
                                    <td><select name="kode_jam_kerja[]" id="kode_jam_kerja" class="form-select">
                                            <option value="">Pilih Jam Kerja</option>
                                            @foreach ($jamkerja as $jk)
                                                <option value="{{ $jk->kode_jam_kerja }}">{{ $jk->nama_jam_kerja }}
                                                </option>
                                            @endforeach
                                        </select></td>
                                </tr>
                            </tbody>
                        </table>
                        <button class="btn btn-primary w-100" type="submit">Simpan</button>
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
