@extends('layout.presensi')
@section('header')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
    <style>
        .datepicker-modal {
            max-height: 460px !important;
        }

        .datepicker-date-display {
            background-color: #0f3a7e !important;
        }
    </style>
    <!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Form Izin / Sakit</div>
        <div class="right"></div>
    </div>
@endsection
@section('content')
    <div class="row" style="margin-top: 70px">
        <div class="col">
            <form action="/presensi/storeizin" method="post" id="frmizin">
                @csrf
                <div class="form-group">
                    <input type="text" class="form-control datepicker" name="tgl_izin" id="tgl_izin"
                        placeholder="Tanggal">
                </div>
                <div class="form-group">
                    <select name="status" id="status" class="form-control">
                        <option value="">izin / sakit</option>
                        <option value="i">izin</option>
                        <option value="s">sakit</option>
                    </select>
                </div>
                <div class="form-group">
                    <textarea name="keterangan" placeholder="keterangan" id="keterangan" cols="30" rows="5" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary w-100">Kirim</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('myscript')
    <script>
        var currYear = (new Date()).getFullYear();

        $(document).ready(function() {
            $(".datepicker").datepicker({

                format: "yyyy-mm-dd"
            });
            $("#tgl_izin").change(function(e) {
                var tgl_izin = $(this).val();
                $.ajax({
                    type: 'POST',
                    url: '/presensi/cekpengajuanizin',
                    data: {
                        _token: "{{ csrf_token() }}",
                        tgl_izin: tgl_izin
                    },
                    cache: false,
                    success: function(respond) {
                        if (respond == 1) {
                            Swal.fire({
                                title: "Ooops!",
                                text: "Anda Sudah Mengajukan Izin Pada Tanggal Tersebut",
                                icon: "warning",
                            }).then((result) => {
                                $("#tgl_izin").val("");
                            });
                        }
                    }
                });
            });
            $("#frmizin").submit(function() {
                var tgl_izin = $("#tgl_izin").val();
                var status = $("#status").val();
                var keterangan = $("#keterangan").val();
                if (tgl_izin == "") {
                    Swal.fire({
                        title: "Ooops!",
                        text: "Tanggal Belum Diisi",
                        icon: "warning",
                    });
                    return false;
                }
                if (status == "") {
                    Swal.fire({
                        title: "Ooops!",
                        text: "Status Belum Diisi",
                        icon: "warning",
                    });
                    return false;
                }
                if (keterangan == "") {
                    Swal.fire({
                        title: "Ooops!",
                        text: "Keterangan Belum Diisi",
                        icon: "warning",
                    });
                    return false;
                }
            })
        });
    </script>
@endpush
