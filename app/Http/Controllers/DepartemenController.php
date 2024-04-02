<?php

namespace App\Http\Controllers;

use App\Models\departemen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class DepartemenController extends Controller
{
    public function index(Request $request)
    {
        $nama_dept = $request->nama_dept;
        $query = departemen::query();
        $query->select('*');
        if (!empty($nama_dept)) {
            $query->where("nama_dept", "like", '%' . $nama_dept . '%');
        }
        $departemen = $query->get();
        return \view('departemen.index', compact('departemen'));
    }
    public function store(Request $request)
    {
        $kode_dept = $request->kode_dept;
        $nama_dept = $request->nama_dept;
        $data = [
            'kode_dept' => $kode_dept,
            'nama_dept' => $nama_dept,
        ];
        $simpan = DB::table('departemen')->insert($data);
        if ($simpan) {
            # code...
            return Redirect::back()->with(['success' => 'Data Berhasil Disimpan']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Gagal Disimpan']);
        }
    }
    public function edit(Request $request)
    {
        $kode_dept = $request->kode_dept;
        $departemen = DB::table('departemen')->where('kode_dept', $kode_dept)->first();
        return \view('departemen.edit', \compact('departemen'));
    }
    public function update($kode_dept, Request $request)
    {
        $nama_dept = $request->nama_dept;
        //code...
        $data = [
            'nama_dept' => $nama_dept,
        ];
        $update = DB::table('departemen')->where('kode_dept', $kode_dept)->update($data);
        if ($update) {
            return Redirect::back()->with(['success' => 'Data Berhasil Diupdate']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Gagal Diupdate']);
        }
    }
    public function delete($kode_dept)
    {
        $delete = DB::table('departemen')->where('kode_dept', $kode_dept)->delete();
        if ($delete) {
            # code...
            return Redirect::back()->with(['success' => 'Data Berhasil Dihapus']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Gagal Dihapus']);
        }
    }
}
