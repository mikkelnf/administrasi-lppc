<?php

namespace App\Http\Controllers;

use App\Models\Semesterberjalan;
use Illuminate\Http\Request;

class PengaturanController extends Controller
{
    public function index()
    {
        $administrator = \App\Models\User::ALL()->sortBy('nama_user');
        $super_admin = \App\Models\User::where('id_role', 0)->orderBy('nama_user')->get();
        $admin = \App\Models\User::where('id_role', 1)->orderBy('nama_user')->get();
        $asisten = \App\Models\User::where('id_role', 2)->orderBy('nama_user')->get();
        $semua_angkatan = \App\Models\Angkatan::ALL()->sortByDesc('tahun_angkatan');
        $angkatan_aktif = \App\Models\Angkatan::where('status_angkatan', 'Aktif')->get();
        $semua_semesterperiode = \App\Models\Semesterperiode::orderByDesc('id')->get();
        $semesterperiode_aktif = \App\Models\Semesterperiode::where('status_semesterperiode', 'Aktif')->get()->sortBy('id');
        $kursus_sekarang = \App\Models\Semesterberjalan::first();
        $kursus_id = $kursus_sekarang->id;
        $skema = \App\Models\Skema::orderBy('id')->get();

        return view('pengaturan.v_pengaturan', 
        compact('administrator', 'super_admin', 'admin', 'asisten', 'semua_angkatan', 'angkatan_aktif', 'semua_semesterperiode', 'semesterperiode_aktif', 'kursus_sekarang', 'kursus_id', 'skema'));
    }

    public function edit_semesterberjalan(Request $request, $id)
    {
        $semester = Semesterberjalan::find($id);
        $semester->id_semesterperiode = $request->id_semesterperiode;
            
        $query = $semester->save();
        if ($query){
            return back()->with('pesan', 'Semester berjalan berhasil diedit');
        }
    }
}
