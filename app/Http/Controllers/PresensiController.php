<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class PresensiController extends Controller
{
    public function create()
    {
        $hariIni = date("Y-m-d");
        $nik = Auth::guard('karyawan')->user()->nik;
        $cek = DB::table('presensi')->where('tgl_presensi', $hariIni)->where('nik', $nik)->count();
        return view('presensi.create', compact('cek'));
    }
    public function store(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $tgl_presensi = date("Y-m-d");
        $jam = date("H:i:s");
        // -7.260346743098588, 112.58408245896344

        $latitudeKantor = -7.536763458128994;
        $longitudeKantor = 112.56982620381542;
        $lokasi = $request->lokasi;
        $lokasiUser = explode(",", $lokasi);
        $latitudeUser = $lokasiUser[0];
        $longitudeUser = $lokasiUser[1];
        $jarak = $this->distance($latitudeKantor, $longitudeKantor, $latitudeUser, $longitudeUser);
        $radius = round($jarak["meters"]);
        $cek = DB::table('presensi')->where('tgl_presensi', $tgl_presensi)->where('nik', $nik)->count();
        if ($cek > 0) {
            $ket = "out";
        } else {
            $ket = "in";
        }
        $image = $request->image;
        $folderPath = "public/uploads/absensi/";
        $formatName = $nik . "-" . $tgl_presensi . "-" . $ket;
        $image_parts = explode(";base64", $image);
        $image_base64 = base64_decode($image_parts[1]);
        $filename = $formatName . ".png";
        $file = $folderPath . $filename;
        if ($radius > 50) {
            echo "error|maaf Anda berada diluar radius, jarak Anda " . $radius . " meter dari kantor|radius";
        } else {
            if ($cek > 0) {
                $data_pulang = [
                    'nik' => $nik,
                    'jam_out' => $jam,
                    'foto_out' => $filename,
                    'lokasi_out' => $lokasi
                ];
                $update = DB::table('presensi')->where('tgl_presensi', $tgl_presensi)->where('nik', $nik)->update($data_pulang);
                if ($update) {
                    echo "success|Terima kasih! Hati-hati di jalan|out";
                    Storage::put($file, $image_base64);
                } else {
                    echo "error|Maaf sistem error, absen gagal, hubungi tim IT|out";
                }
            } else {
                $data = [
                    'nik' => $nik,
                    'tgl_presensi' => $tgl_presensi,
                    'jam_in' => $jam,
                    'foto_in' => $filename,
                    'lokasi_in' => $lokasi
                ];
                $simpan = DB::table('presensi')->insert($data);
                if ($simpan) {
                    Storage::put($file, $image_base64);
                    echo "success|Terima Kasih, Selamat Bekerja|in";
                } else {
                    echo "error|Maaf sistem error, absen gagal, hubungi tim IT|in";
                }
            }
        }
    }

    //Menghitung Jarak/radius
    function distance($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $feet = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;
        return compact('meters');
    }

    public function editProfile()
    {
        $nik =  Auth::guard('karyawan')->user()->nik;
        $karyawan = DB::table('karyawan')->where('nik', $nik)->first();
        return view('presensi.editprofile', \compact('karyawan'));
    }
    public function updateProfile(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $nama_lengkap = $request->nama_lengkap;
        $no_hp = $request->no_hp;
        $password = Hash::make($request->password);
        $karywan = DB::table('karyawan')->where('nik', $nik)->first();
        if ($request->hasFile('foto')) {
            $foto = $nik . "." . $request->file('foto')->getClientOriginalExtension();
        } else {
            $foto = $karywan->foto;
        }
        if (empty($password)) {
            $data = [
                'nama_lengkap' => $nama_lengkap,
                'no_hp' => $no_hp,
                'foto' => $foto
            ];
        } else {
            $data = [
                'nama_lengkap' => $nama_lengkap,
                'no_hp' => $no_hp,
                'password' => $password,
                'foto' => $foto
            ];
        }
        $update = DB::table('karyawan')->where('nik', $nik)
            ->update($data);
        if ($update) {
            if ($request->hasFile('foto')) {
                $folderPath = "public/uploads/karyawan/";
                $request->file('foto')->storeAs($folderPath, $foto);
            }
            return Redirect::back()->with(['success' => 'Profile berhasil di update']);
        } else {
            return Redirect::back()->with(['error' => 'Profile gagal di update']);
        }
    }
    public function history()
    {
        $namaBulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        return view('presensi.history', compact('namaBulan'));
    }
    public function gethistori(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $nik = Auth::guard('karyawan')->user()->nik;
        $histori = DB::table('presensi')
            ->whereRaw('MONTH(tgl_presensi)="' . $bulan . '"')
            ->whereRaw('YEAR(tgl_presensi)="' . $tahun . '"')
            ->where('nik', $nik)
            ->orderBy('tgl_presensi')->get();
        return view('presensi.gethistori', compact('histori'));
    }
}
