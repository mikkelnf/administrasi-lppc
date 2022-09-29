<?php

namespace App\Http\Controllers;

use App\Models\Angkatan;
use App\Models\Detailtugas;
use App\Models\Evaluasitugas;
use App\Models\Evaluasitugasd3;
use App\Models\Semesterkuliah;
use App\Models\Kelulusanpeserta;
use App\Models\Skema;
use App\Models\TugasPeserta;
use App\Models\TugasPesertaSem1;
use App\Models\TugasPesertaSem2;
use App\Models\TugasPesertaSem3;
use App\Models\TugasPesertaSem4;
use App\Models\TugasPesertaSem5;
use App\Models\TugasPesertaSem6;
use App\Models\TugasPesertaSem7;
use App\Models\TugasPesertaSem8;
use Illuminate\Http\Request;

class EvaluasiTugasController extends Controller
{
    public function menu_angkatan()
    {
        $angkatan_aktif = \App\Models\Angkatan::where('status_angkatan', 'Aktif')->get()->sortBy('tahun_angkatan');
        $skemafirst_id = \App\Models\Skema::first()->id;

        return view('tugas.v_evaluasi-angkatan-menu', compact('angkatan_aktif', 'skemafirst_id'));
    }

    public function menu_modul(Angkatan $angkatan, Skema $skema)
    {
        $peserta = \App\Models\Peserta::where('id_angkatan', $angkatan->id)->get()->sortBy('nama_peserta');
        $semester = \App\Models\Semesterkuliah::ALL();
        $t_a = $angkatan->tahun_angkatan;
        $angkatan_aktif = \App\Models\Angkatan::where('status_angkatan', 'Aktif')->get()->sortBy('tahun_angkatan');
        $checker = $angkatan_aktif->contains('tahun_angkatan', $t_a);

        $skemafirst_id = \App\Models\Skema::first()->id;

        return view('tugas.v_evaluasi-angkatan', compact( 'peserta', 't_a', 'angkatan_aktif', 'checker', 'semester', 'angkatan', 'skemafirst_id'));
    }

    public function show(Angkatan $angkatan, Skema $skema, Semesterkuliah $semester)
    {
        $peserta = \App\Models\Peserta::where('id_angkatan', $angkatan->id)->get()->sortBy('nama_peserta');
        $semester_all = \App\Models\Semesterkuliah::ALL();
        $i_s = $semester->id;
        $t_a = $angkatan->tahun_angkatan;
        $angkatan_aktif = \App\Models\Angkatan::where('status_angkatan', 'Aktif')->get()->sortBy('tahun_angkatan');
        $checker = $angkatan_aktif->contains('tahun_angkatan', $t_a);
        
        $skema_all = \App\Models\Skema::orderBy('id')->get();
        $skemafirst_id = \App\Models\Skema::first()->id;
        $skemacurrent_id = $skema->id;
        $skemacurrent_nama = $skema->nama_skema;
        $skemas1 = \App\Models\Skema::where('nama_skema', 'Pembuat Ide Gerak & Cerita (Generalist)')->first();
        $skemad3 = \App\Models\Skema::where('nama_skema', '3D Illustration Artist')->first();

        if($skema->nama_skema == '3D Illustration Artist'){
            $detail = \App\Models\DetailEvaluasitugasd3::where('id_semesterkuliah', $i_s)->get();
        }
        else{
            $detail = \App\Models\DetailEvaluasitugas::where('id_semesterkuliah', $i_s)->get();
        }

        $peserta_all = \App\Models\Peserta::all();
        $peserta_id = $peserta->map(function ($user) {
            return collect($user->toArray())
                ->only(['id'])
                ->all();
        });

        $pesertaskema = \App\Models\Peserta::where('id_angkatan', $angkatan->id)->where('id_skema', $skemacurrent_id)->orderBy('nama_peserta')->get();
        $pesertaskema_id = $pesertaskema->map(function ($user) {
            return collect($user->toArray())
            ->only(['id'])
            ->all();
        });
        
        foreach ($semester_all as $data){
            if($data->id == 1){
                $data->evaluasisemester()->sync([1,2,3,4,5,6,7,8,9,10,11,12,13,14]);
                $data->evaluasisemesterd3()->sync([1,2,3,4,5,6,7,8]);
            }
            if($data->id == 2){
                $data->evaluasisemester()->sync([1,2,3,4,5,6]);
                $data->evaluasisemesterd3()->sync([1,2,3,4,5,6]);
            }
            if($data->id == 3){
                $data->evaluasisemester()->sync([1,2,3]);
                $data->evaluasisemesterd3()->sync([1,2,3]);
            }
            if($data->id == 4){
                $data->evaluasisemester()->sync([1,2,3,4]);
                $data->evaluasisemesterd3()->sync([1,2,3,4,5,6]);
            }
            if($data->id == 5){
                $data->evaluasisemester()->sync([1,2,3,4,5,6]);
                $data->evaluasisemesterd3()->sync([1,2,3,4]);
            }
            if($data->id == 6){
                $data->evaluasisemester()->sync([1,2]);
                $data->evaluasisemesterd3()->sync([1]);
            }
            if($data->id == 7){
                $data->evaluasisemester()->sync([1,2]);
            }
            if($data->id == 8){
                $data->evaluasisemester()->sync([1,2,3]);
            }
        }

        $evaluasis1 = \App\Models\Evaluasitugas::get();
        $evaluasid3 = \App\Models\Evaluasitugasd3::get();

        return view('tugas.v_evaluasi', 
        compact( 'peserta', 't_a', 'angkatan_aktif', 'checker', 'semester_all', 'i_s', 'angkatan', 
        'skema', 'skema_all', 'skemafirst_id', 'skemacurrent_id', 'skemas1', 'skemad3', 'detail', 'evaluasis1', 'evaluasid3', 'pesertaskema')); 
    }

    public function edit(Request $request, Angkatan $angkatan, Skema $skema, Semesterkuliah $semester, $id)
    {    
        $i_s = $semester->id;
        $evaluasi = \App\Models\Evaluasitugas::get();
        $evaluasid3 = \App\Models\Evaluasitugasd3::get();

        if($skema->nama_skema == '3D Illustration Artist' ){
            foreach($request->all() as $key => $req){
                if($req==null){
                    if($evaluasid3->where('id_tugas', $key)->where('id_peserta', $id)->first()){
                        \App\Models\Evaluasitugasd3::where('id_tugas', $key)->where('id_peserta', $id)->delete();
                    }
                }
                elseif($req=='selesai'){
                    if(!$evaluasid3->where('id_tugas', $key)->where('id_peserta', $id)->first()){
                        $table = new Evaluasitugasd3;
                        $table->id_tugas = $key;
                        $table->id_peserta = $id;
                        $table->save();
                    }
                }
            }
            $counter_tugas = \App\Models\Evaluasitugasd3::where('id_peserta', $id)->count()/28*100;
        }
        else{
            foreach($request->all() as $key => $req){
                if($req==null){
                    if($evaluasi->where('id_tugas', $key)->where('id_peserta', $id)->first()){
                        \App\Models\Evaluasitugas::where('id_tugas', $key)->where('id_peserta', $id)->delete();
                    }
                }
                elseif($req=='selesai'){
                    if(!$evaluasi->where('id_tugas', $key)->where('id_peserta', $id)->first()){
                        $table = new Evaluasitugas;
                        $table->id_tugas = $key;
                        $table->id_peserta = $id;
                        $table->save();
                    }
                }
            }
            $counter_tugas = \App\Models\Evaluasitugas::where('id_peserta', $id)->count()/40*100;
        }

        $kehadiran = \App\Models\Kelulusanpeserta::where('id_peserta', $id)->first()->kehadiran;
        if($counter_tugas >= 56 && $kehadiran > 50){
            $status = 'Lulus';
        }
        else{
            $status = 'Tidak Lulus';
        }
        $zz = Kelulusanpeserta::where('id_peserta', $id)->first();
        if(!$zz){
            $table2 = new Kelulusanpeserta;
            $table2->id_peserta = $id;
            $table2->kelengkapan_tugas = $counter_tugas;
            $table2->status_kelulusan = $status;
            $table2->save();
        }
        elseif($zz){
            $table2 = $zz;
            $table2->kelengkapan_tugas = $counter_tugas;
            $table2->status_kelulusan = $status;
            $table2->save();
        }

        return back()->with('pesan', 'Evaluasi tugas peserta berhasil diedit');
    }

    public function laporan(Angkatan $angkatan, Skema $skema, Semesterkuliah $semester)
    {
        $peserta = \App\Models\Peserta::where('id_angkatan', $angkatan->id)->get()->sortBy('nama_peserta');
        $semester_all = \App\Models\Semesterkuliah::ALL();
        $i_s = $semester->id;
        $t_a = $angkatan->tahun_angkatan;
        $angkatan_aktif = \App\Models\Angkatan::where('status_angkatan', 'Aktif')->get()->sortBy('tahun_angkatan');
        $checker = $angkatan_aktif->contains('tahun_angkatan', $t_a);
        
        $skema_all = \App\Models\Skema::orderBy('id')->get();
        $skemafirst_id = \App\Models\Skema::first()->id;
        $skemacurrent_id = $skema->id;
        $skemacurrent_nama = $skema->nama_skema;
        $skemas1 = \App\Models\Skema::where('nama_skema', 'Pembuat Ide Gerak & Cerita (Generalist)')->first();
        $skemad3 = \App\Models\Skema::where('nama_skema', '3D Illustration Artist')->first();

        if($skema->nama_skema == '3D Illustration Artist'){
            $detail = \App\Models\DetailEvaluasitugasd3::where('id_semesterkuliah', $i_s)->get();
        }
        else{
            $detail = \App\Models\DetailEvaluasitugas::where('id_semesterkuliah', $i_s)->get();
        }

        $peserta_all = \App\Models\Peserta::all();
        $peserta_id = $peserta->map(function ($user) {
            return collect($user->toArray())
                ->only(['id'])
                ->all();
        });

        $pesertaskema = \App\Models\Peserta::where('id_angkatan', $angkatan->id)->where('id_skema', $skemacurrent_id)->orderBy('nama_peserta')->get();
        $pesertaskema_id = $pesertaskema->map(function ($user) {
            return collect($user->toArray())
            ->only(['id'])
            ->all();
        });
        
        foreach ($semester_all as $data){
            if($data->id == 1){
                $data->evaluasisemester()->sync([1,2,3,4,5,6,7,8,9,10,11,12,13,14]);
                $data->evaluasisemesterd3()->sync([1,2,3,4,5,6,7,8]);
            }
            if($data->id == 2){
                $data->evaluasisemester()->sync([1,2,3,4,5,6]);
                $data->evaluasisemesterd3()->sync([1,2,3,4,5,6]);
            }
            if($data->id == 3){
                $data->evaluasisemester()->sync([1,2,3]);
                $data->evaluasisemesterd3()->sync([1,2,3]);
            }
            if($data->id == 4){
                $data->evaluasisemester()->sync([1,2,3,4]);
                $data->evaluasisemesterd3()->sync([1,2,3,4,5,6]);
            }
            if($data->id == 5){
                $data->evaluasisemester()->sync([1,2,3,4,5,6]);
                $data->evaluasisemesterd3()->sync([1,2,3,4]);
            }
            if($data->id == 6){
                $data->evaluasisemester()->sync([1,2]);
                $data->evaluasisemesterd3()->sync([1]);
            }
            if($data->id == 7){
                $data->evaluasisemester()->sync([1,2]);
            }
            if($data->id == 8){
                $data->evaluasisemester()->sync([1,2,3]);
            }
        }

        $evaluasis1 = \App\Models\Evaluasitugas::get();
        $evaluasid3 = \App\Models\Evaluasitugasd3::get();

        return view('tugas.v_evaluasi-laporan', 
        compact( 'peserta', 't_a', 'angkatan_aktif', 'checker', 'semester_all', 'i_s', 'angkatan', 
        'skema', 'skema_all', 'skemafirst_id', 'skemacurrent_id', 'skemas1', 'skemad3', 'detail', 'evaluasis1', 'evaluasid3', 'pesertaskema')); 
    }
}
