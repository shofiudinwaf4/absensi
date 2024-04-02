@extends('layout.presensi')
@section('header')
    <!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Ganti Password</div>
    </div>
@endsection
@section('content')
    <div class="row" style="margin-top: 4rem">
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
    <form action="/presensi/{{ $karyawan->nik }}/updatePassword" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="col">
            <div class="form-group boxed">
                <div class="input-wrapper">
                    <input type="password" name="current_password" class="form-control" placeholder="Password Lama"
                        autocomplete="off" />
                </div>
                @error('current_password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group boxed">
                <div class="input-wrapper">
                    {{-- <input type="password" class="form-control" name="password" placeholder="Password Baru"
                        autocomplete="off"> --}}
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                        name="password" placeholder="Password Lama" required autocomplete="current-password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                {{-- @error('currentpassword')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror --}}
            </div>
            <div class="form-group boxed">
                <div class="input-wrapper">
                    {{-- <input type="password" class="form-control" name="password_confirmation"
                        placeholder="Konfirmasi Password" autocomplete="off"> --}}
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                        name="password_confirmation" placeholder="Password Lama" required autocomplete="current-password">
                </div>
                {{-- @error('currentpassword')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror --}}
            </div>
            <div class="form-group boxed">
                <div class="input-wrapper">
                    <button type="submit" class="btn btn-primary btn-block">
                        <ion-icon name="refresh-outline"></ion-icon>
                        Update
                    </button>
                </div>
            </div>
        </div>
    </form>
    {{-- <div class="py-5 mt-3">
        <div class="row">
            <div class="col-12">
                @if (Session::get('success'))
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                    </div>
                @endif
                @if (Session::get('warning'))
                    <div class="alert alert-warning">
                        {{ Session::get('warning') }}
                    </div>
                @endif
            </div>
        </div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow">
                        <div class="card-header bg-primary">
                            <h4 class="mb-0 text-white">Change Password</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ url('/presensi/updatePassword') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label>Current Password</label>
                                    <input type="password" name="current_password" class="form-control" />
                                </div>
                                <div class="mb-3">
                                    <label>New Password</label>
                                    <input type="password" name="password" class="form-control" />
                                </div>
                                <div class="mb-3">
                                    <label>Confirm Password</label>
                                    <input type="password" name="password_confirmation" class="form-control" />
                                </div>
                                <div class="mb-3 text-end">
                                    <hr>
                                    <button type="submit" class="btn btn-primary">Update Password</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
@endsection
<script>
    function myFunction() {
        var x = document.getElementById("myInput");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }

    function myFunction1() {
        var x = document.getElementById("password_baru");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }

    function myFunction2() {
        var x = document.getElementById("password_confirmation");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
</script>
