<?php

namespace App\Http\Controllers;

use App\Models\Angkatan;
use App\Models\Semesterkuliah;
use Illuminate\Http\Request;

class RaporController extends Controller
{
    public function index()
    {
        $angkatan_aktif = \App\Models\Angkatan::where('status_angkatan', 'Aktif')->get()->sortBy('tahun_angkatan');
        $semester = \App\Models\Semesterkuliah::ALL();
        foreach ($semester as $data){
            $data->rapord3()->sync([1,2,3,4,5,6,7,8,9,10]);
        }
        $skema_id = \App\Models\Skema::first()->id;
        return view('rapor.v_rapor-angkatan-menu', compact('angkatan_aktif','skema_id'));
    }
    public function show(Angkatan $angkatan)
    {
        return redirect('/rapor/angkatan/'.$angkatan->tahun_angkatan.'/semester/');
    }
}