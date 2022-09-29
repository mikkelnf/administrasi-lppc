<?php

namespace App\Http\Controllers;

use App\Models\Angkatan;
use Illuminate\Http\Request;

class TugasController extends Controller
{
    public function index()
    {
        $angkatan_aktif = \App\Models\Angkatan::where('status_angkatan', 'Aktif')->get()->sortBy('tahun_angkatan');
        $skemafirst_id = \App\Models\Skema::first()->id;

        return view('tugas.v_tugas-angkatan-menu', compact('angkatan_aktif', 'skemafirst_id'));
    }
    public function show(Angkatan $angkatan)
    {
        return redirect('/tugas/angkatan/'.$angkatan->tahun_angkatan.'/semester/');
    }
}
