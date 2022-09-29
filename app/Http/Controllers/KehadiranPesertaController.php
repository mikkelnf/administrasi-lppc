<?php

namespace App\Http\Controllers;

use App\Models\Angkatan;
use App\Models\Peserta;
use App\Models\Kelulusanpeserta;
use App\Models\Semesterkuliah;
use App\Models\Skema;
use Illuminate\Http\Request;

class KehadiranPesertaController extends Controller
{
    public function index(Angkatan $angkatan)
    {
        $peserta = \App\Models\Peserta::where('id_angkatan', $angkatan->id)->get()->sortBy('nama_peserta');
        $jurusan = \App\Models\Jurusan::ALL();
        $semester = \App\Models\Semesterkuliah::ALL();
        $t_a = $angkatan->tahun_angkatan;
        $angkatan_aktif = \App\Models\Angkatan::where('status_angkatan', 'Aktif')->get()->sortBy('tahun_angkatan');
        $checker = $angkatan_aktif->contains('tahun_angkatan', $t_a);
        $peserta_id = $peserta->map(function ($user) {
            return collect($user->toArray())
                ->only(['id'])
                ->all();
        });
        $kehadiran = \App\Models\KehadiranPeserta::whereIn('id_peserta', $peserta_id)
        ->orderBy(function ($query) {
            $query->select('nama_peserta')
            ->from('peserta')
            ->whereColumn('id', 'id_peserta');
        })
        ->paginate(20);

        $peserta_all = \App\Models\Peserta::all();
        
        foreach ($peserta_all as $data){
            $data->semesterkehadiran()->sync([1,2,3,4,5,6,7,8]);
        }

        $skema_all = \App\Models\Skema::orderBy('id')->get();
        $skemafirst_id = \App\Models\Skema::first()->id;
        $skemas1 = \App\Models\Skema::where('nama_skema', 'Pembuat Ide Gerak & Cerita (Generalist)')->first();
        $skemad3 = \App\Models\Skema::where('nama_skema', '3D Illustration Artist')->first();

        return view('kehadiran.v_kehadiran-angkatan', compact( 'peserta', 'jurusan', 't_a', 'angkatan_aktif', 'checker', 'semester', 'kehadiran', 'angkatan', 'skemafirst_id'));
    }

    public function show(Angkatan $angkatan, Skema $skema, Semesterkuliah $semester)
    {
        $peserta = \App\Models\Peserta::where('id_angkatan', $angkatan->id)->get()->sortBy('nama');
        $jurusan = \App\Models\Jurusan::ALL();
        $semester_all = \App\Models\Semesterkuliah::ALL();
        $i_s = $semester->id;
        $t_a = $angkatan->tahun_angkatan;
        $angkatan_aktif = \App\Models\Angkatan::where('status_angkatan', 'Aktif')->get()->sortBy('tahun_angkatan');
        $checker = $angkatan_aktif->contains('tahun_angkatan', $t_a);
    
        $peserta_all = \App\Models\Peserta::all();
        
        foreach ($peserta_all as $data){
            $data->semesterkehadiran()->sync([1,2,3,4,5,6,7,8]);
        }

        $peserta_id = $peserta->map(function ($user) {
            return collect($user->toArray())
                ->only(['id'])
                ->all();
        });

        $skema_all = \App\Models\Skema::orderBy('id')->get();
        $skemafirst_id = \App\Models\Skema::first()->id;
        $skemacurrent_id = $skema->id;
        $skemacurrent_nama = $skema->nama_skema;
        $skemas1 = \App\Models\Skema::where('nama_skema', 'Pembuat Ide Gerak & Cerita (Generalist)')->first();
        $skemad3 = \App\Models\Skema::where('nama_skema', '3D Illustration Artist')->first();

        $pesertaskema = \App\Models\Peserta::where('id_angkatan', $angkatan->id)->where('id_skema', $skemacurrent_id)->get()->sortBy('nama_peserta');
        $pesertaskema_id = $pesertaskema->map(function ($user) {
            return collect($user->toArray())
            ->only(['id'])
            ->all();
        });

        $kehadiran = \App\Models\KehadiranPeserta::where('id_semesterkuliah', $i_s)->whereIn('id_peserta', $pesertaskema_id)
        ->orderBy(function ($query) {
            $query->select('nama_peserta')
            ->from('peserta')
            ->whereColumn('id', 'id_peserta');
        })
        ->get();

        return view('kehadiran.v_kehadiran', 
        compact( 'peserta', 'jurusan', 't_a', 'angkatan_aktif', 'checker', 'semester_all', 'i_s', 'kehadiran', 'angkatan', 'skema', 'skema_all', 'skemafirst_id', 'skemacurrent_id', 'skemas1', 'skemad3')); 
    }

    public function laporan_kehadiran(Angkatan $angkatan, Skema $skema, Semesterkuliah $semester)
    {
        $peserta = \App\Models\Peserta::where('id_angkatan', $angkatan->id)->get()->sortBy('nama_peserta');
        $jurusan = \App\Models\Jurusan::ALL();
        $semester_all = \App\Models\Semesterkuliah::ALL();
        $i_s = $semester->id;
        $t_a = $angkatan->tahun_angkatan;
        $angkatan_aktif = \App\Models\Angkatan::where('status_angkatan', 'Aktif')->get()->sortBy('tahun_angkatan');
        $checker = $angkatan_aktif->contains('tahun_angkatan', $t_a);
        
        $peserta_all = \App\Models\Peserta::all();
        
        foreach ($peserta_all as $data){
            $data->semesterkehadiran()->sync([1,2,3,4,5,6,7,8]);
        }

        $peserta_id = $peserta->map(function ($user) {
            return collect($user->toArray())
                ->only(['id'])
                ->all();
        });

        $kehadiran = \App\Models\KehadiranPeserta::where('id_semesterkuliah', $i_s)->whereIn('id_peserta', $peserta_id)
        ->orderBy(function ($query) {
            $query->select('nama_peserta')
            ->from('peserta')
            ->whereColumn('id', 'id_peserta');
        })
        ->get();

        return view('kehadiran.v_kehadiran-laporan', compact( 'peserta', 'jurusan', 't_a', 'angkatan_aktif', 'checker', 'semester_all', 'i_s', 'kehadiran')); 
    }

    public function edit(Request $request, Angkatan $angkatan, Skema $skema, Semesterkuliah $semester, $id)
    {
        $i_s = $semester->id;
        
        $cek = Kelulusanpeserta::where('id_peserta', $id)->first();
        if(!$cek){
            $table = new Kelulusanpeserta;
            $table->id_peserta = $id;
            $query = $table->save();
        }

        $peserta = Peserta::where('id', $id)->first();

        $query = $peserta->semesterkehadiran()->syncWithoutDetaching([$i_s =>
        [
        'pertemuan_1' => $request->pertemuan_1,
        'pertemuan_2' => $request->pertemuan_2,
        'pertemuan_3' => $request->pertemuan_3,
        'pertemuan_4' => $request->pertemuan_4,
        'pertemuan_5' => $request->pertemuan_5,
        'pertemuan_6' => $request->pertemuan_6,
        'pertemuan_7' => $request->pertemuan_7,
        'pertemuan_8' => $request->pertemuan_8,
        'pertemuan_9' => $request->pertemuan_9,
        'pertemuan_10' => $request->pertemuan_10
        ]]);

        if ($query){
            $pluck1 = \App\Models\KehadiranPeserta::where('id_peserta', $id)->pluck('pertemuan_1');
            $pluck2 = \App\Models\KehadiranPeserta::where('id_peserta', $id)->pluck('pertemuan_2');
            $pluck3 = \App\Models\KehadiranPeserta::where('id_peserta', $id)->pluck('pertemuan_3');
            $pluck4 = \App\Models\KehadiranPeserta::where('id_peserta', $id)->pluck('pertemuan_4');
            $pluck5 = \App\Models\KehadiranPeserta::where('id_peserta', $id)->pluck('pertemuan_5');
            $pluck6 = \App\Models\KehadiranPeserta::where('id_peserta', $id)->pluck('pertemuan_6');
            $pluck7 = \App\Models\KehadiranPeserta::where('id_peserta', $id)->pluck('pertemuan_7');
            $pluck8 = \App\Models\KehadiranPeserta::where('id_peserta', $id)->pluck('pertemuan_8');
            $pluck9 = \App\Models\KehadiranPeserta::where('id_peserta', $id)->pluck('pertemuan_9');
            $pluck10 = \App\Models\KehadiranPeserta::where('id_peserta', $id)->pluck('pertemuan_10');
            $a = collect([$pluck1,$pluck2,$pluck3,$pluck4,$pluck5,$pluck6,$pluck7,$pluck8,$pluck9,$pluck10])->flatten()->toArray();
            $tot = array_filter($a);
            $tot2 = array_count_values($tot);
            if(!array_key_exists("Hadir", $tot2)){
                $counter_kehadiran = 0;
            }
            else{
                $tot3 = $tot2["Hadir"];
                $counter_kehadiran = $tot3/80*100;
            }
            $kelengkapan_tugas = \App\Models\Kelulusanpeserta::where('id_peserta', $id)->first()->kelengkapan_tugas;
            if($kelengkapan_tugas >= 56 && $counter_kehadiran > 50){
                $status = 'Lulus';
            }
            else{
                $status = 'Tidak Lulus';
            }
            $zz = Kelulusanpeserta::where('id_peserta', $id)->first();
            if(!$zz){
                $table2 = new Kelulusanpeserta;
                $table2->id_peserta = $id;
                $table2->kehadiran = $counter_kehadiran;
                $table2->status_kelulusan = $status;
                $query = $table2->save();
            }
            elseif($zz){
                $table2 = $zz;
                $table2->kehadiran = $counter_kehadiran;
                $table2->status_kelulusan = $status;
                $query = $table2->save();
            }

            return back()->with('pesan', 'Kehadiran peserta berhasil diedit');
        }
    }
}