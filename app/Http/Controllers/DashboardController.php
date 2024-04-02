<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    //
    public function index()
    {
        $hariIni = date("Y-m-d");
        $bulanIni = date("m") * 1;
        $tahunIni = date("Y");
        $konfigurasi_kantor = DB::table('konfigurasi')->where('id', 1)->first();
        $nik = Auth::guard('karyawan')->user()->nik;
        $presensiHariIni = DB::table('presensi')->where('nik', $nik)->where('tgl_presensi', $hariIni)->first();
        $historyBulanIni = DB::table('presensi')
            ->leftJoin('jam_kerja', 'presensi.kode_jam_kerja', '=', 'jam_kerja.kode_jam_kerja')
            ->where('nik', $nik)
            ->whereRaw('MONTH(tgl_presensi)="' . $bulanIni . '"')
            ->whereRaw('YEAR(tgl_presensi)="' . $tahunIni . '"')
            ->orderBy('tgl_presensi')->get();
        $rekapPresensi = DB::table('presensi')
            ->selectRaw('COUNT(nik) as jmlHadir, SUM(IF(jam_in>jam_masuk,1,0)) as jmlTerlambat')
            ->join('jam_kerja', 'presensi.kode_jam_kerja', '=', 'jam_kerja.kode_jam_kerja')
            ->where('nik', $nik)->whereRaw('MONTH(tgl_presensi)="' . $bulanIni . '"')
            ->whereRaw('YEAR(tgl_presensi)="' . $tahunIni . '"')->first();
        $leaderboard = DB::table('presensi')
            ->join('karyawan', 'presensi.nik', '=', 'karyawan.nik')
            ->where('tgl_presensi', $hariIni)->get();
        $namaBulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $rekapizin = DB::table('pengajuan_izin')->selectRaw('SUM(IF(status="i",1,0)) as jmlizin,SUM(IF(status="s",1,0)) as jmlsakit')->where('nik', $nik)->whereRaw('MONTH(tgl_izin)="' . $bulanIni . '"')
            ->whereRaw('YEAR(tgl_izin)="' . $tahunIni . '"')->where('status_approved', 1)->first();
        return view('dashboard.dashboard', compact('presensiHariIni', 'historyBulanIni', 'namaBulan', 'bulanIni', 'tahunIni', 'rekapPresensi', 'leaderboard', 'rekapizin'));
    }

    public function dashboardAdmin()
    {
        $hariIni = date("Y-m-d");
        $jmlkaryawan = DB::table('karyawan')->get();
        $konfigurasi_kantor = DB::table('konfigurasi')->where('id', 1)->first();
        $rekapPresensi = DB::table('presensi')
            ->selectRaw('COUNT(nik) as jmlHadir, SUM(IF(jam_in>jam_masuk,1,0)) as jmlTerlambat')
            ->join('jam_kerja', 'presensi.kode_jam_kerja', '=', 'jam_kerja.kode_jam_kerja')
            ->where('tgl_presensi', $hariIni)
            ->first();
        $rekapizin = DB::table('pengajuan_izin')->selectRaw('SUM(IF(status="i",1,0)) as jmlizin,SUM(IF(status="s",1,0)) as jmlsakit')->where('tgl_izin', $hariIni)->where('status_approved', 1)->first();
        return view('dashboard.dashboardadmin', \compact('rekapPresensi', 'rekapizin', 'jmlkaryawan'));
    }
}
