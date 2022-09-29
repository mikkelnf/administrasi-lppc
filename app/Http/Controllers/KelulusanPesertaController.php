<?php

namespace App\Http\Controllers;

use App\Models\Angkatan;
use App\Models\Kelulusanpeserta;
use App\Models\TugasPeserta;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class KelulusanPesertaController extends Controller
{
    public function index()
    {
        $angkatan_aktif = \App\Models\Angkatan::where('status_angkatan', 'Aktif')->get()->sortBy('tahun_angkatan');
        return view('kelulusan.v_kelulusan-angkatan-menu', compact('angkatan_aktif'));
    }

    public function show(Angkatan $angkatan)
    {
        $peserta = \App\Models\Peserta::where('id_angkatan', $angkatan->id)->orderBy('nama_peserta')->get();
        $jurusan = \App\Models\Jurusan::ALL();
        $t_a = $angkatan->tahun_angkatan;
        $angkatan_aktif = \App\Models\Angkatan::where('status_angkatan', 'Aktif')->get()->sortBy('tahun_angkatan');
        $peserta_all = \App\Models\Peserta::all();
        $checker = $angkatan_aktif->contains('tahun_angkatan', $t_a);
        $peserta_id = $peserta->map(function ($user) {
            return collect($user->toArray())
            ->only(['id'])
            ->all();
        });
        $kelulusan = Kelulusanpeserta::whereIn('id_peserta', $peserta_id)->orderBy(function ($query){
            $query->select('nama_peserta')
            ->from('peserta')
            ->whereColumn('id', 'id_peserta');
        })->get();

        foreach ($peserta_all as $data){
            $zz = Kelulusanpeserta::where('id_peserta', $data->id)->first();
            if(!$zz){
                $table = new Kelulusanpeserta;
                $table->id_peserta = $data->id;
                $query = $table->save();
            }
        }
        
        return view('kelulusan.v_kelulusan-angkatan', compact( 'peserta', 'jurusan', 't_a', 'angkatan_aktif', 'checker', 'angkatan', 'kelulusan'));
    }

    public function laporan_kelulusan(Angkatan $angkatan)
    {
        $peserta = \App\Models\Peserta::where('id_angkatan', $angkatan->id)->get()->sortBy('nama_peserta');
        $jurusan = \App\Models\Jurusan::ALL();
        $semester_all = \App\Models\Semesterkuliah::ALL();
        $t_a = $angkatan->tahun_angkatan;
        $angkatan_aktif = \App\Models\Angkatan::where('status_angkatan', 'Aktif')->get()->sortBy('tahun_angkatan');
        $checker = $angkatan_aktif->contains('tahun_angkatan', $t_a);
        $peserta_all = \App\Models\Peserta::all();

        $peserta_id = $peserta->map(function ($user) {
            return collect($user->toArray())
                ->only(['id'])
                ->all();
        });
        $kelulusan = Kelulusanpeserta::whereIn('id_peserta', $peserta_id)->orderBy(function ($query){
            $query->select('nama_peserta')
            ->from('peserta')
            ->whereColumn('id', 'id_peserta');
        })->get();

        return view('kelulusan.v_kelulusan-laporan', compact( 'peserta', 'jurusan', 't_a', 'angkatan_aktif', 'checker', 'angkatan', 'kelulusan')); 
    }
}
    