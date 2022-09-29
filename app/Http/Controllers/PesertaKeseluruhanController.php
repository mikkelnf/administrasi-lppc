<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PesertaKeseluruhanController extends Controller
{
    public function index()
    {
        $angkatan_aktif = \App\Models\Angkatan::where('status_angkatan', 'Aktif')->get('id')->toArray();
        $semua_peserta = \App\Models\Peserta::ALL();
        $peserta = \App\Models\Peserta::whereIn('id_angkatan', $angkatan_aktif)->orderBy('id_angkatan')->orderBy('nama_peserta')->get();
        $peserta_aktif = \App\Models\Peserta::whereIn('id_angkatan', $angkatan_aktif)->orderByDesc(function ($query){
            $query->select('tahun_angkatan')
            ->from('angkatan')
            ->whereColumn('id', 'id_angkatan');
        })->orderBy('nama_peserta')->get();
        $angkatan_aktif_id = \App\Models\Angkatan::where('status_angkatan', 'Aktif')->get('tahun_angkatan');
        $angkatan_aktif_all = \App\Models\Angkatan::where('status_angkatan', 'Aktif')->get();
        $jml_angkatan_aktif = \App\Models\Angkatan::where('status_angkatan', 'Aktif')->get('tahun_angkatan')->count();
        $jml_peserta_aktif = $peserta->count();

        return view('peserta.v_peserta-keseluruhan', 
        compact('peserta', 'semua_peserta', 'peserta_aktif', 'angkatan_aktif', 'jml_peserta_aktif', 'angkatan_aktif_id', 'angkatan_aktif_all'));
    }
}
