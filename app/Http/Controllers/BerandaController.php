<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BerandaController extends Controller
{
    public function index() 
    {
        $angkatan_aktif = \App\Models\Angkatan::where('status_angkatan', 'Aktif')->get('id')->toArray();
        $peserta_aktif = \App\Models\Peserta::whereIn('id_angkatan', $angkatan_aktif)->get();
        $jml_peserta_aktif = $peserta_aktif->count();
        $jml_user = \App\Models\User::all()->count();
        $jml_asisten = \App\Models\User::where('id_role', 2)->orderBy('nama_user')->get()->count();
        $semesterberjalan = \App\Models\Semesterberjalan::find(1);
        if(!$semesterberjalan->id_semesterperiode == null){
            $semesterberjalan_nama = $semesterberjalan->semesterperiode()->first()->nama_semesterperiode;
            $semesterberjalan_id = $semesterberjalan->semesterperiode()->first()->id;
        }
        elseif($semesterberjalan->id_semester_kursus == null){
            $semesterberjalan_nama = '-';
            $semesterberjalan_id = null;
        }
        
        return view('v_beranda', compact('jml_user', 'jml_asisten', 'jml_peserta_aktif', 'semesterberjalan_nama', 'semesterberjalan_id', 'semesterberjalan'));
    }
}
