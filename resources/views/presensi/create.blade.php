@extends('layout.presensi')
@section('header')
    <!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">E-Presensi</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->
    <style>
        .webcam-capture,
        .webcam-capture video {
            display: inline-block;
            width: 100% !important;
            margin: auto;
            height: auto !important;
            border-radius: 15px;
        }

        #map {
            height: 500px;
        }

        .jam-digital-malasngoding {

            background-color: #27272783;
            position: absolute;
            top: 65px;
            right: 10px;
            z-index: 9999;
            width: 150px;
            border-radius: 10px;
            padding: 5px;
        }



        .jam-digital-malasngoding p {
            color: #fff;
            font-size: 16px;
            text-align: center;
            margin-top: 0;
            margin-bottom: 0;
        }
    </style>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@endsection
@section('content')
    <div class="row" style="margin-top: 60px">
        <div class="col">
            <input type="hidden" id="lokasi">
            <div id="map"></div>
            {{-- <div class="webcam-capture"> --}}
        </div>
    </div>
    </div>
    <div class="jam-digital-malasngoding">
        <p>{{ date('d-m-y') }}</p>
        <p id="jam"></p>
        <p>{{ $jamkerja->nama_jam_kerja }}</p>
        <p>Mulai Absen: {{ date('H:i', strtotime($jamkerja->awal_jam_masuk)) }}</p>
        <p>Masuk: {{ date('H:i', strtotime($jamkerja->jam_masuk)) }}</p>
        <p>Absen Berakhir: {{ date('H:i', strtotime($jamkerja->akhir_jam_masuk)) }}</p>
    </div>
    <div class="row mt-1">
        <div class="col">
            @if ($cek > 0)
                <button id="takeabsen" class="btn btn-danger btn-block"><ion-icon name="camera-outline"></ion-icon>Absen
                    Pulang</button>
            @else
                <button id="takeabsen" class="btn btn-primary btn-block"><ion-icon name="camera-outline"></ion-icon>Absen
                    Masuk</button>
            @endif
        </div>
    </div>
    {{-- <div class="row mt-2">
        <div class="col">
            <div id="map"></div>
        </div>
    </div> --}}
    {{-- notifikasi audio --}}
    <audio id="notifikasi_in">
        <source src="{{ asset('assets/sound/notifikasi_in.mp3') }}" type="audio/mp3">
    </audio>
    <audio id="notifikasi_out">
        <source src="{{ asset('assets/sound/notifikasi_out.mp3') }}" type="audio/mp3">
    </audio>
    <audio id="notifikasi_radius">
        <source src="{{ asset('assets/sound/radius.mp3') }}" type="audio/mp3">
    </audio>
@endsection
@push('myscript')
    <script>
        var notifikasi_in = document.getElementById('notifikasi_in') //variabel untuk notifikasi audio in
        var notifikasi_out = document.getElementById('notifikasi_out') //variabel untuk notifikasi audio out
        var notifikasi_radius = document.getElementById('notifikasi_radius') //variabel untuk notifikasi audio out
        /*Webcam.set({
                height: 480,
                width: 640,
                image_format: 'jpeg',
                jpeg_quality: 80
            });

            Webcam.attach('.webcam-capture');    */
        var lokasi = document.getElementById('lokasi');
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
        }

        function successCallback(position) {
            lokasi.value = position.coords.latitude + "," + position.coords.longitude;
            var map = L.map('map').setView([position.coords.latitude, position.coords.longitude], 18);
            var lokasi_kantor = "{{ $konfigurasi_kantor->lokasi_kantor }}";
            var lok = lokasi_kantor.split(",");
            var lat_kantor = lok[0];
            var long_kantor = lok[1];
            var radius = "{{ $konfigurasi_kantor->radius }}";
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);
            // mengambil titik user
            var marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);
            // mengambil titik koordinat kantor
            // -7.260346743098588, 112.58408245896344

            var circle = L.circle([lat_kantor, long_kantor], {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.5,
                radius: radius
            }).addTo(map);
        }

        function errorCallback() {

        }
        $("#takeabsen").click(function(e) {
            // Webcam.snap(function(uri) {
            //     image = uri;
            // });
            var lokasi = $("#lokasi").val();
            $.ajax({
                type: 'POST',
                url: '/presensi/store',
                data: {
                    _token: "{{ csrf_token() }}",
                    // image: image,
                    lokasi: lokasi,
                },
                cache: false,
                success: function(respond) {
                    var status = respond.split("|");
                    if (status[0] == "success") {
                        // notifikasi audio
                        if (status[2] == "in") {
                            notifikasi_in.play();
                        } else {
                            notifikasi_out.play();
                        }
                        // notifikasi audio end
                        Swal.fire({
                            title: "Berhasih!",
                            text: status[1],
                            icon: "success",
                        });
                        setTimeout("location.href='/dashboard'", 3000);
                    } else {
                        // notifikasi audio
                        if (status[2] == "radius") {
                            notifikasi_radius.play();
                        }
                        //notifikasi audio end
                        Swal.fire({
                            title: "Error!",
                            text: status[1],
                            icon: "error",
                        });
                    }
                }
            });
        });
    </script>
    <script type="text/javascript">
        window.onload = function() {
            jam();
        }

        function jam() {
            var e = document.getElementById('jam'),
                d = new Date(),
                h, m, s;
            h = d.getHours();
            m = set(d.getMinutes());
            s = set(d.getSeconds());

            e.innerHTML = h + ':' + m + ':' + s;

            setTimeout('jam()', 1000);
        }

        function set(e) {
            e = e < 10 ? '0' + e : e;
            return e;
        }
    </script>
@endpush
