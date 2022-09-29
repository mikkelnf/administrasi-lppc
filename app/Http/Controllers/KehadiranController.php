<?php

namespace App\Http\Controllers;

use App\Models\Angkatan;
use Illuminate\Http\Request;

class KehadiranController extends Controller
{
    public function index()
    {
        $angkatan_aktif = \App\Models\Angkatan::where('status_angkatan', 'Aktif')->get()->sortBy('tahun_angkatan');
        $skemafirst_id = \App\Models\Skema::first()->id;

        return view('kehadiran.v_kehadiran-angkatan-menu', compact('angkatan_aktif', 'skemafirst_id'));
    }
    public function show(Angkatan $angkatan)
    {
        return redirect('/kehadiran/angkatan/'.$angkatan->tahun_angkatan.'/semester/');
    }
}
