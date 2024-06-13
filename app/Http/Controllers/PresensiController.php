<?php

namespace App\Http\Controllers;

use App\Models\pengajuanizin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class PresensiController extends Controller
{
    public function getHari()
    {
        $hari = date("D");
        switch ($hari) {
            case 'Sun':
                $hari_ini = "Minggu";
                break;
            case 'Mon':
                $hari_ini = "Senin";
                break;
            case 'Tue':
                $hari_ini = "Selasa";
                break;
            case 'Wed':
                $hari_ini = "Rabu";
                break;
            case 'Thu':
                $hari_ini = "kamis";
                break;
            case 'Fri':
                $hari_ini = "Jumat";
                break;
            case 'Sat':
                $hari_ini = "Sabtu";
                break;
            default:
                $hari_ini = "Tidak di ketahui";
                break;
        }
        return $hari_ini;
    }
    public function create()
    {
        $hariIni = date("Y-m-d");
        $namahari = $this->getHari();
        $nik = Auth::guard('karyawan')->user()->nik;
        $cek = DB::table('presensi')->where('tgl_presensi', $hariIni)->where('nik', $nik)->count();
        $konfigurasi_kantor = DB::table('konfigurasi')->where('id', 1)->first();
        $jamkerja = DB::table('konfigurasi_jamkerja')
            ->join('jam_kerja', 'konfigurasi_jamkerja.kode_jam_kerja', '=', 'jam_kerja.kode_jam_kerja')
            ->where('nik', $nik)
            ->where('hari', $namahari)->first();

        return view('presensi.create', compact('cek', 'konfigurasi_kantor', 'jamkerja'));
    }
    public function store(Request $request)
    {
        $namahari = $this->getHari();
        $nik = Auth::guard('karyawan')->user()->nik;
        $tgl_presensi = date("Y-m-d");
        $jam = date("H:i:s");
        // -8.260346743098588, 112.58408245896344
        $konfigurasi_kantor = DB::table('konfigurasi')->where('id', 1)->first();
        $lok = \explode(",", $konfigurasi_kantor->lokasi_kantor);
        $latitudeKantor = $lok[0];
        $longitudeKantor = $lok[1];
        $lokasi = $request->lokasi;
        $lokasiUser = explode(",", $lokasi);
        $latitudeUser = $lokasiUser[0];
        $longitudeUser = $lokasiUser[1];
        $jarak = $this->distance($latitudeKantor, $longitudeKantor, $latitudeUser, $longitudeUser);
        $radius = round($jarak["meters"]);
        $namahari = $this->getHari();
        $jamkerja = DB::table('konfigurasi_jamkerja')
            ->join('jam_kerja', 'konfigurasi_jamkerja.kode_jam_kerja', '=', 'jam_kerja.kode_jam_kerja')
            ->where('nik', $nik)
            ->where('hari', $namahari)->first();
        // cek jam kerja karyawan
        $cek = DB::table('presensi')->where('tgl_presensi', $tgl_presensi)->where('nik', $nik)->count();
        // if ($cek > 0) {
        //     $ket = "out";
        // } else {
        //     $ket = "in";
        // }
        // $image = $request->image;
        // $folderPath = "public/uploads/absensi/";
        // $formatName = $nik . "-" . $tgl_presensi . "-" . $ket;
        // $image_parts = explode(";base64", $image);
        // $image_base64 = base64_decode($image_parts[1]);
        // $filename = $formatName . ".png";
        // $file = $folderPath . $filename;
        if ($radius > $konfigurasi_kantor->radius) {
            echo "error|maaf Anda berada diluar radius, jarak Anda " . $radius . " meter dari kantor|radius";
        } else {
            if ($cek > 0) {
                if ($jam < $jamkerja->jam_pulang) {
                    echo "error|Maaf Belum Waktunya Pulang|out";
                } else {
                    $data_pulang = [
                        'nik' => $nik,
                        'jam_out' => $jam,
                        // 'foto_out' => $filename,
                        'lokasi_out' => $lokasi
                    ];
                    $update = DB::table('presensi')->where('tgl_presensi', $tgl_presensi)->where('nik', $nik)->update($data_pulang);
                    if ($update) {
                        echo "success|Terima kasih! Hati-hati di jalan|out";
                        // Storage::put($file, $image_base64);
                    } else {
                        echo "error|Maaf sistem error, absen gagal, hubungi tim IT|out";
                    }
                }
            } else {
                if ($jam < $jamkerja->awal_jam_masuk) {
                    echo "error|Maaf Belum Waktunya Absen|in";
                } else if ($jam > $jamkerja->akhir_jam_masuk) {
                    echo "error|Maaf Waktu Absen Berakhir|in";
                } else {
                    $data = [
                        'nik' => $nik,
                        'tgl_presensi' => $tgl_presensi,
                        'jam_in' => $jam,
                        // 'foto_in' => $filename,
                        'lokasi_in' => $lokasi,
                        'kode_jam_kerja' => $jamkerja->kode_jam_kerja
                    ];
                    $simpan = DB::table('presensi')->insert($data);
                    if ($simpan) {
                        // Storage::put($file, $image_base64);
                        echo "success|Terima Kasih, Selamat Bekerja|in";
                    } else {
                        echo "error|Maaf sistem error, absen gagal, hubungi tim IT|in";
                    }
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

    public function Profile()
    {
        $nik =  Auth::guard('karyawan')->user()->nik;
        $karyawan = DB::table('karyawan')->where('nik', $nik)->first();
        return view('presensi.profile', \compact('karyawan'));
    }

    public function editProfile()
    {
        $nik =  Auth::guard('karyawan')->user()->nik;
        $karyawan = DB::table('karyawan')->where('nik', $nik)->first();
        return view('presensi.editprofile', \compact('karyawan'));
    }
    public function gantipassword()
    {
        $nik =  Auth::guard('karyawan')->user()->nik;
        $karyawan = DB::table('karyawan')->where('nik', $nik)->first();
        return view('presensi.gantipassword', \compact('karyawan'));
    }
    public function updateProfile(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $nama_lengkap = $request->nama_lengkap;
        $no_hp = $request->no_hp;
        $old_foto = $request->old_foto;
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
        // \dd($data, $old_foto);
        $update = DB::table('karyawan')->where('nik', $nik)
            ->update($data);
        if ($update) {
            if ($request->hasFile('foto')) {
                $folderPath = "public/uploads/karyawan/";
                $folderPathold = "public/uploads/karyawan/" . $old_foto;
                if (file_exists($folderPathold)) {

                    @unlink($folderPathold);
                }
                // Storage::delete($folderPathold);
                $request->file('foto')->move($folderPath, $foto);
            }
            return Redirect('/profile')->with(['success' => 'Profile berhasil di update']);
        } else {
            return Redirect('/profile')->with(['error' => 'Profile gagal di update']);
        }
    }
    public function updatePassword(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'min:5', 'confirmed']
        ], [
            'current_password.required' => 'password lama harus diisi',
            'password.min' => 'Password Baru Minimal 5 karakter',
            'password.confirmed' => 'Konfirmasi Password berbeda'
        ]);
        $karywan = DB::table('karyawan')->where('nik', $nik)->first();
        $currentPasswordStatus = Hash::check($request->current_password, $karywan->password);
        // \dd($request->current_password, $request->password, $nik, $karywan->password, $currentPasswordStatus);
        if ($currentPasswordStatus) {
            // $konfirmasiPasswordStatus = Hash::check($request->current_password, $request->confirm_password);
            // if ($konfirmasiPasswordStatus) {
            //     $request->validate([
            //         'confirm_password' => 'required|unique:posts|max:255',
            //         'author.name' => 'required',
            //         'author.description' => 'required',
            //     ]);
            // }
            $data = [
                'password' => Hash::make($request->password)
            ];
            DB::table('karyawan')->where('nik', $nik)
                ->update($data);
            return Redirect::back()->with(['success' => 'Password Berhasil Di Update']);
        } else {
            return Redirect::back()->with(['error' => 'Password Lama Anda Salah']);
        }
    }
    public function history()
    {
        $konfigurasi_kantor = DB::table('konfigurasi')->where('id', 1)->first();
        $namaBulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        return view('presensi.history', compact('namaBulan', 'konfigurasi_kantor'));
    }
    public function gethistori(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $konfigurasi_kantor = DB::table('konfigurasi')->where('id', 1)->first();
        $nik = Auth::guard('karyawan')->user()->nik;
        $histori = DB::table('presensi')
            ->leftJoin('jam_kerja', 'presensi.kode_jam_kerja', '=', 'jam_kerja.kode_jam_kerja')
            ->where('nik', $nik)
            ->whereRaw('MONTH(tgl_presensi)="' . $bulan . '"')
            ->whereRaw('YEAR(tgl_presensi)="' . $tahun . '"')
            ->orderBy('tgl_presensi')->get();
        return view('presensi.gethistori', compact('histori', 'konfigurasi_kantor'));
    }
    public function monitoring()
    {
        return \view('presensi.monitoring');
    }
    public function getpresensi(Request $request)
    {
        $tanggal = $request->tanggal;
        $konfigurasi_kantor = DB::table('konfigurasi')->where('id', 1)->first();
        $presensi = DB::table('presensi')
            ->select('presensi.*', 'nama_lengkap', 'nama_dept', 'jam_masuk', 'nama_jam_kerja', 'jam_masuk', 'jam_pulang')
            ->leftJoin('jam_kerja', 'presensi.kode_jam_kerja', '=', 'jam_kerja.kode_jam_kerja')
            ->join('karyawan', 'presensi.nik', '=', 'karyawan.nik')
            ->join('departemen', 'karyawan.kode_dept', '=', 'departemen.kode_dept')
            ->where('tgl_presensi', $tanggal)
            ->get();
        return \view('presensi.getpresensi', \compact('presensi', 'konfigurasi_kantor'));
    }
    public function tampilkanpeta(Request $request)
    {
        $id = $request->id;
        $presensi = DB::table('presensi')->where('id', $id)
            ->join('karyawan', 'presensi.nik', '=', 'karyawan.nik')
            ->first();
        return \view('presensi.showmap', \compact('presensi'));
    }
    public function laporan()
    {
        $konfigurasi_kantor = DB::table('konfigurasi')->where('id', 1)->first();
        $namaBulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $karyawan = DB::table('karyawan')->orderBy('nama_lengkap')->get();
        return view('presensi.laporan', \compact('namaBulan', 'karyawan', 'konfigurasi_kantor'));
    }
    public function cetaklaporan(Request $request)
    {
        $nik = $request->nik;
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $konfigurasi_kantor = DB::table('konfigurasi')->where('id', 1)->first();
        $namaBulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $karyawan = DB::table('karyawan')->where('nik', $nik)
            ->join('departemen', 'karyawan.kode_dept', '=', 'departemen.kode_dept')->first();
        $presensi = DB::table('presensi')
            ->leftJoin('jam_kerja', 'presensi.kode_jam_kerja', '=', 'jam_kerja.kode_jam_kerja')
            ->where('nik', $nik)
            ->whereRaw('MONTH(tgl_presensi)="' . $bulan . '"')
            ->whereRaw('YEAR(tgl_presensi)="' . $tahun . '"')
            ->orderBy('tgl_presensi')->get();
        return \view('presensi.cetaklaporan', \compact('bulan', 'tahun', 'namaBulan', 'karyawan', 'presensi', 'konfigurasi_kantor'));
    }
    public function rekap()
    {
        $namaBulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $konfigurasi_kantor = DB::table('konfigurasi')->where('id', 1)->first();
        return view('presensi.rekap', \compact('namaBulan', 'konfigurasi_kantor'));
    }
    public function cetakrekap(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $konfigurasi_kantor = DB::table('konfigurasi')->where('id', 1)->first();
        $rekap = DB::table('presensi')
            ->selectRaw('presensi.nik,nama_lengkap,jam_masuk,jam_pulang,
        MAX(IF(DAY(tgl_presensi)=1,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_1,
        MAX(IF(DAY(tgl_presensi)=2,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_2,
        MAX(IF(DAY(tgl_presensi)=3,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_3,
        MAX(IF(DAY(tgl_presensi)=4,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_4,
        MAX(IF(DAY(tgl_presensi)=5,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_5,
        MAX(IF(DAY(tgl_presensi)=6,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_6,
        MAX(IF(DAY(tgl_presensi)=7,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_7,
        MAX(IF(DAY(tgl_presensi)=8,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_8,
        MAX(IF(DAY(tgl_presensi)=9,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_9,
        MAX(IF(DAY(tgl_presensi)=10,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_10,
        MAX(IF(DAY(tgl_presensi)=11,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_11,
        MAX(IF(DAY(tgl_presensi)=12,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_12,
        MAX(IF(DAY(tgl_presensi)=13,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_13,
        MAX(IF(DAY(tgl_presensi)=14,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_14,
        MAX(IF(DAY(tgl_presensi)=15,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_15,
        MAX(IF(DAY(tgl_presensi)=16,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_16,
        MAX(IF(DAY(tgl_presensi)=17,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_17,
        MAX(IF(DAY(tgl_presensi)=18,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_18,
        MAX(IF(DAY(tgl_presensi)=19,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_19,
        MAX(IF(DAY(tgl_presensi)=20,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_20,
        MAX(IF(DAY(tgl_presensi)=21,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_21,
        MAX(IF(DAY(tgl_presensi)=22,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_22,
        MAX(IF(DAY(tgl_presensi)=23,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_23,
        MAX(IF(DAY(tgl_presensi)=24,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_24,
        MAX(IF(DAY(tgl_presensi)=25,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_25,
        MAX(IF(DAY(tgl_presensi)=26,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_26,
        MAX(IF(DAY(tgl_presensi)=27,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_27,
        MAX(IF(DAY(tgl_presensi)=28,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_28,
        MAX(IF(DAY(tgl_presensi)=29,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_29,
        MAX(IF(DAY(tgl_presensi)=30,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_30,
        MAX(IF(DAY(tgl_presensi)=31,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_31')
            ->join('karyawan', 'presensi.nik', '=', 'karyawan.nik')
            ->leftJoin('jam_kerja', 'presensi.kode_jam_kerja', '=', 'jam_kerja.kode_jam_kerja')
            ->whereRaw('MONTH(tgl_presensi)="' . $bulan . '"')
            ->whereRaw('YEAR(tgl_presensi)="' . $tahun . '"')
            ->groupByRaw('presensi.nik,nama_lengkap,jam_masuk,jam_pulang')->get();
        $namaBulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

        return \view('presensi.cetakrekap', \compact('bulan', 'tahun', 'namaBulan', 'rekap', 'konfigurasi_kantor'));
    }
    public function izin()
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $dataizin = DB::table('pengajuan_izin')->where('nik', $nik)->get();
        return view('presensi.izin', \compact('dataizin'));
    }
    public function buatizin()
    {
        return view('presensi.buatizin');
    }
    public function storeizin(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $tgl_izin = $request->tgl_izin;
        $status = $request->status;
        $keterangan = $request->keterangan;
        $data = [
            'nik' => $nik,
            'tgl_izin' => $tgl_izin,
            'status' => $status,
            'keterangan' => $keterangan
        ];
        $simpan = DB::table('pengajuan_izin')->insert($data);
        if ($simpan) {
            return \redirect('/presensi/izin')->with(['success' => ' Data Berhasil Disimpan']);
        } else {
            return \redirect('/presensi/izin')->with(['error' => ' Data Gagal Disimpan']);
        }
    }

    public function izinsakit(Request $request)
    {
        $query = Pengajuanizin::query();
        $query->select('id', 'tgl_izin', 'pengajuan_izin.nik', 'nama_lengkap', 'jabatan', 'status', 'status_approved', 'keterangan');
        $query->join('karyawan', 'pengajuan_izin.nik', '=', 'karyawan.nik');
        if (!empty($request->dari) && !empty($request->sampai)) {
            $query->whereBetween('tgl_izin', [$request->dari, $request->sampai]);
        }
        if (!empty($request->nik)) {
            $query->where('pengajuan_izin.nik', $request->nik);
        }
        if (!empty($request->nama_lengkap)) {
            $query->where('nama_lengkap', 'like', '%' . $request->nama_lengkap . '%');
        }
        if ($request->status_approved === "0" || $request->status_approved === "1" || !$request->status_approved === "2") {
            $query->where('status_approved', $request->status_approved);
        }
        $query->orderBy('tgl_izin', 'desc');
        $izinsakit = $query->paginate(20);
        $izinsakit->appends($request->all());
        return \view("presensi.izinsakit", \compact('izinsakit'));
    }
    public function approveizinsakit(Request $Request)
    {
        $status_approved = $Request->status_approved;
        $id_izinsakit_form = $Request->id_izinsakit_form;
        $update = DB::table('pengajuan_izin')->where('id', $id_izinsakit_form)->update([
            'status_approved' => $status_approved
        ]);
        if ($update) {
            return Redirect::back()->with(['success' => 'Data Berhasil Di Update']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Gagal Di Update']);
        };
    }
    public function batalkanizinsakit($id)
    {
        $update = DB::table('pengajuan_izin')->where('id', $id)->update([
            'status_approved' => 0
        ]);
        if ($update) {
            return Redirect::back()->with(['success' => 'Data Berhasil Di Update']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Gagal Di Update']);
        };
    }
    public function cekpengajuanizin(Request $request)
    {
        $tgl_izin = $request->tgl_izin;
        $nik = Auth::guard('karyawan')->user()->nik;
        $cek = DB::table('pengajuan_izin')->where('nik', $nik)->where('tgl_izin', $tgl_izin)->count();
        return $cek;
    }
}
