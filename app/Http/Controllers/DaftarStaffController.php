<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DaftarStaffController extends Controller
{
    public function index()
    {
        $kepala_lab = \App\Models\User::where('status', 'Kepala Lab')->first();
        $staff = \App\Models\User::whereIn('id_role', [0,1,2])->orderBy('id_role')->orderBy('nama_user')->get();
        return view('staff.v_staff', compact('kepala_lab' ,'staff'));
    }
}
