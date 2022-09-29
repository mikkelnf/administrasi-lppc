<?php

namespace App\Http\Controllers;

use App\Models\Angkatan;
use App\Models\Detailtugas;
use App\Models\Semesterkuliah;
use App\Models\Kelulusanpeserta;
use App\Models\RaporKelulusan;
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

use function PHPUnit\Framework\returnSelf;

class TugasPesertaController extends Controller
{
    public function index(Angkatan $angkatan)
    {
        $peserta = \App\Models\Peserta::where('id_angkatan', $angkatan->id)->get()->sortBy('nama_peserta');
        $semester = \App\Models\Semesterkuliah::ALL();
        $t_a = $angkatan->tahun_angkatan;
        $angkatan_aktif = \App\Models\Angkatan::where('status_angkatan', 'Aktif')->get()->sortBy('tahun_angkatan');
        $checker = $angkatan_aktif->contains('tahun_angkatan', $t_a);

        $skema_all = \App\Models\Skema::orderBy('id')->get();
        $skemafirst_id = \App\Models\Skema::first()->id;
        $skemas1 = \App\Models\Skema::where('nama_skema', 'Pembuat Ide Gerak & Cerita (Generalist)')->first();
        $skemad3 = \App\Models\Skema::where('nama_skema', '3D Illustration Artist')->first();

        return view('tugas.v_tugas-angkatan', compact( 'peserta', 't_a', 'angkatan_aktif', 'checker', 'semester', 'angkatan', 'skemafirst_id'));
    }

    public function show(Angkatan $angkatan, Skema $skema, Semesterkuliah $semester)
    {
        $peserta = \App\Models\Peserta::where('id_angkatan', $angkatan->id)->get()->sortBy('nama_peserta');
        $semester_all = \App\Models\Semesterkuliah::ALL();
        $i_s = $semester->id;
        $t_a = $angkatan->tahun_angkatan;
        $angkatan_aktif = \App\Models\Angkatan::where('status_angkatan', 'Aktif')->get()->sortBy('tahun_angkatan');
        $checker = $angkatan_aktif->contains('tahun_angkatan', $t_a);
        $detail_tugas = Detailtugas::where('id_semesterkuliah', $semester->id)->get();
        $peserta_all = \App\Models\Peserta::all();
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
        
        $rapor_kelulusan = \App\Models\RaporKelulusan::all();
        $tugas_p = \App\Models\TugasPeserta::all();
        $tugas_sem1 = \App\Models\TugasPesertaSem1::all();
        $tugas_sem2 = \App\Models\TugasPesertaSem2::all();
        $tugas_sem3 = \App\Models\TugasPesertaSem3::all();
        $tugas_sem4 = \App\Models\TugasPesertaSem4::all();
        $tugas_sem5 = \App\Models\TugasPesertaSem5::all();
        $tugas_sem6 = \App\Models\TugasPesertaSem6::all();
        $tugas_sem7 = \App\Models\TugasPesertaSem7::all();
        $tugas_sem8 = \App\Models\TugasPesertaSem8::all();
        
        foreach ($semester_all as $data){
            $data->semesterdetail()->sync([1,2,3,4,5,6,7,8,9,10]);
        }

        if($i_s == 1){
            $tugas = \App\Models\TugasPesertaSem1::whereIn('id_peserta', $pesertaskema_id)
            ->orderBy(function ($query){
                $query->select('nama_peserta')
                ->from('peserta')
                ->whereColumn('id', 'id_peserta');
            })->get();
            foreach ($peserta as $data){
                $c = $tugas_sem1->where('id_peserta', $data->id)->first();
                $b = $rapor_kelulusan->where('id_peserta', $data->id)->where('id_semesterkuliah', $i_s)->first();
                $pluck1 = $tugas_sem1->where('id_peserta', $data->id)->pluck('tugas_1');
                $pluck2 = $tugas_sem1->where('id_peserta', $data->id)->pluck('tugas_2');
                $pluck3 = $tugas_sem1->where('id_peserta', $data->id)->pluck('tugas_3');
                $pluck4 = $tugas_sem1->where('id_peserta', $data->id)->pluck('tugas_4');
                $pluck5 = $tugas_sem1->where('id_peserta', $data->id)->pluck('tugas_5');
                $pluck6 = $tugas_sem1->where('id_peserta', $data->id)->pluck('tugas_6');
                $pluck7 = $tugas_sem1->where('id_peserta', $data->id)->pluck('tugas_7');
                $pluck8 = $tugas_sem1->where('id_peserta', $data->id)->pluck('tugas_8');
                $pluck9 = $tugas_sem1->where('id_peserta', $data->id)->pluck('tugas_9');
                $pluck10 = $tugas_sem1->where('id_peserta', $data->id)->pluck('tugas_10');
                $a = collect([$pluck1,$pluck2,$pluck3,$pluck4,$pluck5,$pluck6,$pluck7,$pluck8,$pluck9,$pluck10])->flatten()->toArray();
                $tot = array_filter($a);
                $tot2 = array_count_values($tot);
                if(!array_key_exists("Selesai", $tot2)){
                    $counter_selesai = 0;
                }
                else{
                    $tot3 = $tot2["Selesai"];
                    $counter_selesai = $tot3;
                }
                if($c === null){
                    $table1 = new TugasPesertaSem1;
                    $table1->id_peserta = $data->id;
                    $table1->id_semesterkuliah = $i_s;
                    $query = $table1->save();
                }
                if($b === null){
                    $table2 = new RaporKelulusan;
                    $table2->id_peserta = $data->id;
                    $table2->id_semesterkuliah = $i_s;
                    $table2->kelengkapan_tugas = $counter_selesai;
                    if($counter_selesai == 10){
                        $table2->status_kelulusan = 'Lulus';
                        $query2 = $table2->save();
                    }
                    else{
                        $table2->status_kelulusan = 'Tidak Lulus';
                        $query2 = $table2->save();
                    }
                }
                elseif($b){
                    $table2 = $b;
                    $table2->kelengkapan_tugas = $counter_selesai;
                    if($counter_selesai == 10){
                        $table2->status_kelulusan = 'Lulus';
                        $query2 = $table2->save();
                    }
                    else{
                        $table2->status_kelulusan = 'Tidak Lulus';
                        $query2 = $table2->save();
                    }
                }
            }
        }
        if($i_s == 2){
            $tugas = \App\Models\TugasPesertaSem2::whereIn('id_peserta', $pesertaskema_id)
            ->orderBy(function ($query){
                $query->select('nama_peserta')
                ->from('peserta')
                ->whereColumn('id', 'id_peserta');
            })->get();
            foreach ($peserta as $data){
                $c = $tugas_sem2->where('id_peserta', $data->id)->first();
                $b = $rapor_kelulusan->where('id_peserta', $data->id)->where('id_semesterkuliah', $i_s)->first();
                $pluck1 = $tugas_sem2->where('id_peserta', $data->id)->pluck('tugas_1');
                $pluck2 = $tugas_sem2->where('id_peserta', $data->id)->pluck('tugas_2');
                $pluck3 = $tugas_sem2->where('id_peserta', $data->id)->pluck('tugas_3');
                $pluck4 = $tugas_sem2->where('id_peserta', $data->id)->pluck('tugas_4');
                $pluck5 = $tugas_sem2->where('id_peserta', $data->id)->pluck('tugas_5');
                $pluck6 = $tugas_sem2->where('id_peserta', $data->id)->pluck('tugas_6');
                $pluck7 = $tugas_sem2->where('id_peserta', $data->id)->pluck('tugas_7');
                $pluck8 = $tugas_sem2->where('id_peserta', $data->id)->pluck('tugas_8');
                $pluck9 = $tugas_sem2->where('id_peserta', $data->id)->pluck('tugas_9');
                $pluck10 = $tugas_sem2->where('id_peserta', $data->id)->pluck('tugas_10');
                $a = collect([$pluck1,$pluck2,$pluck3,$pluck4,$pluck5,$pluck6,$pluck7,$pluck8,$pluck9,$pluck10])->flatten()->toArray();
                $tot = array_filter($a);
                $tot2 = array_count_values($tot);
                if(!array_key_exists("Selesai", $tot2)){
                    $counter_selesai = 0;
                }
                else{
                    $tot3 = $tot2["Selesai"];
                    $counter_selesai = $tot3;
                }
                if($c === null){
                    $table1 = new TugasPesertaSem2;
                    $table1->id_peserta = $data->id;
                    $table1->id_semesterkuliah = $i_s;
                    $query = $table1->save();
                }
                if($b === null){
                    $table2 = new RaporKelulusan;
                    $table2->id_peserta = $data->id;
                    $table2->id_semesterkuliah = $i_s;
                    $table2->kelengkapan_tugas = $counter_selesai;
                    if($counter_selesai == 10){
                        $table2->status_kelulusan = 'Lulus';
                        $query2 = $table2->save();
                    }
                    else{
                        $table2->status_kelulusan = 'Tidak Lulus';
                        $query2 = $table2->save();
                    }
                }
                elseif($b){
                    $table2 = $b;
                    $table2->kelengkapan_tugas = $counter_selesai;
                    if($counter_selesai == 10){
                        $table2->status_kelulusan = 'Lulus';
                        $query2 = $table2->save();
                    }
                    else{
                        $table2->status_kelulusan = 'Tidak Lulus';
                        $query2 = $table2->save();
                    }
                }
            }
        }
        if($i_s == 3){
            $tugas = \App\Models\TugasPesertaSem3::whereIn('id_peserta', $pesertaskema_id)
            ->orderBy(function ($query){
                $query->select('nama_peserta')
                ->from('peserta')
                ->whereColumn('id', 'id_peserta');
            })->get();
            foreach ($peserta as $data){
                $c = $tugas_sem3->where('id_peserta', $data->id)->first();
                $b = $rapor_kelulusan->where('id_peserta', $data->id)->where('id_semesterkuliah', $i_s)->first();
                $pluck1 = $tugas_sem3->where('id_peserta', $data->id)->pluck('tugas_1');
                $pluck2 = $tugas_sem3->where('id_peserta', $data->id)->pluck('tugas_2');
                $pluck3 = $tugas_sem3->where('id_peserta', $data->id)->pluck('tugas_3');
                $pluck4 = $tugas_sem3->where('id_peserta', $data->id)->pluck('tugas_4');
                $pluck5 = $tugas_sem3->where('id_peserta', $data->id)->pluck('tugas_5');
                $pluck6 = $tugas_sem3->where('id_peserta', $data->id)->pluck('tugas_6');
                $pluck7 = $tugas_sem3->where('id_peserta', $data->id)->pluck('tugas_7');
                $pluck8 = $tugas_sem3->where('id_peserta', $data->id)->pluck('tugas_8');
                $pluck9 = $tugas_sem3->where('id_peserta', $data->id)->pluck('tugas_9');
                $pluck10 = $tugas_sem3->where('id_peserta', $data->id)->pluck('tugas_10');
                $a = collect([$pluck1,$pluck2,$pluck3,$pluck4,$pluck5,$pluck6,$pluck7,$pluck8,$pluck9,$pluck10])->flatten()->toArray();
                $tot = array_filter($a);
                $tot2 = array_count_values($tot);
                if(!array_key_exists("Selesai", $tot2)){
                    $counter_selesai = 0;
                }
                else{
                    $tot3 = $tot2["Selesai"];
                    $counter_selesai = $tot3;
                }
                if($c === null){
                    $table1 = new TugasPesertaSem3;
                    $table1->id_peserta = $data->id;
                    $table1->id_semesterkuliah = $i_s;
                    $query = $table1->save();
                }
                if($b === null){
                    $table2 = new RaporKelulusan;
                    $table2->id_peserta = $data->id;
                    $table2->id_semesterkuliah = $i_s;
                    $table2->kelengkapan_tugas = $counter_selesai;
                    if($counter_selesai == 10){
                        $table2->status_kelulusan = 'Lulus';
                        $query2 = $table2->save();
                    }
                    else{
                        $table2->status_kelulusan = 'Tidak Lulus';
                        $query2 = $table2->save();
                    }
                }
                elseif($b){
                    $table2 = $b;
                    $table2->kelengkapan_tugas = $counter_selesai;
                    if($counter_selesai == 10){
                        $table2->status_kelulusan = 'Lulus';
                        $query2 = $table2->save();
                    }
                    else{
                        $table2->status_kelulusan = 'Tidak Lulus';
                        $query2 = $table2->save();
                    }
                }
            }
        }
        if($i_s == 4){
            $tugas = \App\Models\TugasPesertaSem4::whereIn('id_peserta', $pesertaskema_id)
            ->orderBy(function ($query){
                $query->select('nama_peserta')
                ->from('peserta')
                ->whereColumn('id', 'id_peserta');
            })->get();
            foreach ($peserta as $data){
                $c = $tugas_sem4->where('id_peserta', $data->id)->first();
                $b = $rapor_kelulusan->where('id_peserta', $data->id)->where('id_semesterkuliah', $i_s)->first();
                $pluck1 = $tugas_sem4->where('id_peserta', $data->id)->pluck('tugas_1');
                $pluck2 = $tugas_sem4->where('id_peserta', $data->id)->pluck('tugas_2');
                $pluck3 = $tugas_sem4->where('id_peserta', $data->id)->pluck('tugas_3');
                $pluck4 = $tugas_sem4->where('id_peserta', $data->id)->pluck('tugas_4');
                $pluck5 = $tugas_sem4->where('id_peserta', $data->id)->pluck('tugas_5');
                $pluck6 = $tugas_sem4->where('id_peserta', $data->id)->pluck('tugas_6');
                $pluck7 = $tugas_sem4->where('id_peserta', $data->id)->pluck('tugas_7');
                $pluck8 = $tugas_sem4->where('id_peserta', $data->id)->pluck('tugas_8');
                $pluck9 = $tugas_sem4->where('id_peserta', $data->id)->pluck('tugas_9');
                $pluck10 = $tugas_sem4->where('id_peserta', $data->id)->pluck('tugas_10');
                $a = collect([$pluck1,$pluck2,$pluck3,$pluck4,$pluck5,$pluck6,$pluck7,$pluck8,$pluck9,$pluck10])->flatten()->toArray();
                $tot = array_filter($a);
                $tot2 = array_count_values($tot);
                if(!array_key_exists("Selesai", $tot2)){
                    $counter_selesai = 0;
                }
                else{
                    $tot3 = $tot2["Selesai"];
                    $counter_selesai = $tot3;
                }
                if($c === null){
                    $table1 = new TugasPesertaSem4;
                    $table1->id_peserta = $data->id;
                    $table1->id_semesterkuliah = $i_s;
                    $query = $table1->save();
                }
                if($b === null){
                    $table2 = new RaporKelulusan;
                    $table2->id_peserta = $data->id;
                    $table2->id_semesterkuliah = $i_s;
                    $table2->kelengkapan_tugas = $counter_selesai;
                    if($counter_selesai == 10){
                        $table2->status_kelulusan = 'Lulus';
                        $query2 = $table2->save();
                    }
                    else{
                        $table2->status_kelulusan = 'Tidak Lulus';
                        $query2 = $table2->save();
                    }
                }
                elseif($b){
                    $table2 = $b;
                    $table2->kelengkapan_tugas = $counter_selesai;
                    if($counter_selesai == 10){
                        $table2->status_kelulusan = 'Lulus';
                        $query2 = $table2->save();
                    }
                    else{
                        $table2->status_kelulusan = 'Tidak Lulus';
                        $query2 = $table2->save();
                    }
                }
            }
        }
        if($i_s == 5){
            $tugas = \App\Models\TugasPesertaSem5::whereIn('id_peserta', $pesertaskema_id)
            ->orderBy(function ($query){
                $query->select('nama_peserta')
                ->from('peserta')
                ->whereColumn('id', 'id_peserta');
            })->get();
            foreach ($peserta as $data){
                $c = $tugas_sem5->where('id_peserta', $data->id)->first();
                $b = $rapor_kelulusan->where('id_peserta', $data->id)->where('id_semesterkuliah', $i_s)->first();
                $pluck1 = $tugas_sem5->where('id_peserta', $data->id)->pluck('tugas_1');
                $pluck2 = $tugas_sem5->where('id_peserta', $data->id)->pluck('tugas_2');
                $pluck3 = $tugas_sem5->where('id_peserta', $data->id)->pluck('tugas_3');
                $pluck4 = $tugas_sem5->where('id_peserta', $data->id)->pluck('tugas_4');
                $pluck5 = $tugas_sem5->where('id_peserta', $data->id)->pluck('tugas_5');
                $pluck6 = $tugas_sem5->where('id_peserta', $data->id)->pluck('tugas_6');
                $pluck7 = $tugas_sem5->where('id_peserta', $data->id)->pluck('tugas_7');
                $pluck8 = $tugas_sem5->where('id_peserta', $data->id)->pluck('tugas_8');
                $pluck9 = $tugas_sem5->where('id_peserta', $data->id)->pluck('tugas_9');
                $pluck10 = $tugas_sem5->where('id_peserta', $data->id)->pluck('tugas_10');
                $a = collect([$pluck1,$pluck2,$pluck3,$pluck4,$pluck5,$pluck6,$pluck7,$pluck8,$pluck9,$pluck10])->flatten()->toArray();
                $tot = array_filter($a);
                $tot2 = array_count_values($tot);
                if(!array_key_exists("Selesai", $tot2)){
                    $counter_selesai = 0;
                }
                else{
                    $tot3 = $tot2["Selesai"];
                    $counter_selesai = $tot3;
                }
                if($c === null){
                    $table1 = new TugasPesertaSem5;
                    $table1->id_peserta = $data->id;
                    $table1->id_semesterkuliah = $i_s;
                    $query = $table1->save();
                }
                if($b === null){
                    $table2 = new RaporKelulusan;
                    $table2->id_peserta = $data->id;
                    $table2->id_semesterkuliah = $i_s;
                    $table2->kelengkapan_tugas = $counter_selesai;
                    if($counter_selesai == 10){
                        $table2->status_kelulusan = 'Lulus';
                        $query2 = $table2->save();
                    }
                    else{
                        $table2->status_kelulusan = 'Tidak Lulus';
                        $query2 = $table2->save();
                    }
                }
                elseif($b){
                    $table2 = $b;
                    $table2->kelengkapan_tugas = $counter_selesai;
                    if($counter_selesai == 10){
                        $table2->status_kelulusan = 'Lulus';
                        $query2 = $table2->save();
                    }
                    else{
                        $table2->status_kelulusan = 'Tidak Lulus';
                        $query2 = $table2->save();
                    }
                }
            }
        }
        if($i_s == 6){
            $tugas = \App\Models\TugasPesertaSem6::whereIn('id_peserta', $pesertaskema_id)
            ->orderBy(function ($query){
                $query->select('nama_peserta')
                ->from('peserta')
                ->whereColumn('id', 'id_peserta');
            })->get();
            foreach ($peserta as $data){
                $c = $tugas_sem6->where('id_peserta', $data->id)->first();
                $b = $rapor_kelulusan->where('id_peserta', $data->id)->where('id_semesterkuliah', $i_s)->first();
                $pluck1 = $tugas_sem6->where('id_peserta', $data->id)->pluck('tugas_1');
                $pluck2 = $tugas_sem6->where('id_peserta', $data->id)->pluck('tugas_2');
                $pluck3 = $tugas_sem6->where('id_peserta', $data->id)->pluck('tugas_3');
                $pluck4 = $tugas_sem6->where('id_peserta', $data->id)->pluck('tugas_4');
                $pluck5 = $tugas_sem6->where('id_peserta', $data->id)->pluck('tugas_5');
                $pluck6 = $tugas_sem6->where('id_peserta', $data->id)->pluck('tugas_6');
                $pluck7 = $tugas_sem6->where('id_peserta', $data->id)->pluck('tugas_7');
                $pluck8 = $tugas_sem6->where('id_peserta', $data->id)->pluck('tugas_8');
                $pluck9 = $tugas_sem6->where('id_peserta', $data->id)->pluck('tugas_9');
                $pluck10 = $tugas_sem6->where('id_peserta', $data->id)->pluck('tugas_10');
                $a = collect([$pluck1,$pluck2,$pluck3,$pluck4,$pluck5,$pluck6,$pluck7,$pluck8,$pluck9,$pluck10])->flatten()->toArray();
                $tot = array_filter($a);
                $tot2 = array_count_values($tot);
                if(!array_key_exists("Selesai", $tot2)){
                    $counter_selesai = 0;
                }
                else{
                    $tot3 = $tot2["Selesai"];
                    $counter_selesai = $tot3;
                }
                if($c === null){
                    $table1 = new TugasPesertaSem6;
                    $table1->id_peserta = $data->id;
                    $table1->id_semesterkuliah = $i_s;
                    $query = $table1->save();
                }
                if($b === null){
                    $table2 = new RaporKelulusan;
                    $table2->id_peserta = $data->id;
                    $table2->id_semesterkuliah = $i_s;
                    $table2->kelengkapan_tugas = $counter_selesai;
                    if($counter_selesai == 10){
                        $table2->status_kelulusan = 'Lulus';
                        $query2 = $table2->save();
                    }
                    else{
                        $table2->status_kelulusan = 'Tidak Lulus';
                        $query2 = $table2->save();
                    }
                }
                elseif($b){
                    $table2 = $b;
                    $table2->kelengkapan_tugas = $counter_selesai;
                    if($counter_selesai == 10){
                        $table2->status_kelulusan = 'Lulus';
                        $query2 = $table2->save();
                    }
                    else{
                        $table2->status_kelulusan = 'Tidak Lulus';
                        $query2 = $table2->save();
                    }
                }
            }    
        }
        if($i_s == 7){
            $tugas = \App\Models\TugasPesertaSem7::whereIn('id_peserta', $pesertaskema_id)
            ->orderBy(function ($query){
                $query->select('nama_peserta')
                ->from('peserta')
                ->whereColumn('id', 'id_peserta');
            })->get();
            foreach ($peserta as $data){
                $c = $tugas_sem7->where('id_peserta', $data->id)->first();
                $b = $rapor_kelulusan->where('id_peserta', $data->id)->where('id_semesterkuliah', $i_s)->first();
                $pluck1 = $tugas_sem7->where('id_peserta', $data->id)->pluck('tugas_1');
                $pluck2 = $tugas_sem7->where('id_peserta', $data->id)->pluck('tugas_2');
                $pluck3 = $tugas_sem7->where('id_peserta', $data->id)->pluck('tugas_3');
                $pluck4 = $tugas_sem7->where('id_peserta', $data->id)->pluck('tugas_4');
                $pluck5 = $tugas_sem7->where('id_peserta', $data->id)->pluck('tugas_5');
                $pluck6 = $tugas_sem7->where('id_peserta', $data->id)->pluck('tugas_6');
                $pluck7 = $tugas_sem7->where('id_peserta', $data->id)->pluck('tugas_7');
                $pluck8 = $tugas_sem7->where('id_peserta', $data->id)->pluck('tugas_8');
                $pluck9 = $tugas_sem7->where('id_peserta', $data->id)->pluck('tugas_9');
                $pluck10 = $tugas_sem7->where('id_peserta', $data->id)->pluck('tugas_10');
                $a = collect([$pluck1,$pluck2,$pluck3,$pluck4,$pluck5,$pluck6,$pluck7,$pluck8,$pluck9,$pluck10])->flatten()->toArray();
                $tot = array_filter($a);
                $tot2 = array_count_values($tot);
                if(!array_key_exists("Selesai", $tot2)){
                    $counter_selesai = 0;
                }
                else{
                    $tot3 = $tot2["Selesai"];
                    $counter_selesai = $tot3;
                }
                if($c === null){
                    $table1 = new TugasPesertaSem7;
                    $table1->id_peserta = $data->id;
                    $table1->id_semesterkuliah = $i_s;
                    $query = $table1->save();
                }
                if($b === null){
                    $table2 = new RaporKelulusan;
                    $table2->id_peserta = $data->id;
                    $table2->id_semesterkuliah = $i_s;
                    $table2->kelengkapan_tugas = $counter_selesai;
                    if($counter_selesai == 10){
                        $table2->status_kelulusan = 'Lulus';
                        $query2 = $table2->save();
                    }
                    else{
                        $table2->status_kelulusan = 'Tidak Lulus';
                        $query2 = $table2->save();
                    }
                }
                elseif($b){
                    $table2 = $b;
                    $table2->kelengkapan_tugas = $counter_selesai;
                    if($counter_selesai == 10){
                        $table2->status_kelulusan = 'Lulus';
                        $query2 = $table2->save();
                    }
                    else{
                        $table2->status_kelulusan = 'Tidak Lulus';
                        $query2 = $table2->save();
                    }
                }
            }
        }
        if($i_s == 8){
            $tugas = \App\Models\TugasPesertaSem8::whereIn('id_peserta', $pesertaskema_id)
            ->orderBy(function ($query){
                $query->select('nama_peserta')
                ->from('peserta')
                ->whereColumn('id', 'id_peserta');
            })->get();
            foreach ($peserta as $data){
                $c = $tugas_sem8->where('id_peserta', $data->id)->first();
                $b = $rapor_kelulusan->where('id_peserta', $data->id)->where('id_semesterkuliah', $i_s)->first();
                $pluck1 = $tugas_sem8->where('id_peserta', $data->id)->pluck('tugas_1');
                $pluck2 = $tugas_sem8->where('id_peserta', $data->id)->pluck('tugas_2');
                $pluck3 = $tugas_sem8->where('id_peserta', $data->id)->pluck('tugas_3');
                $pluck4 = $tugas_sem8->where('id_peserta', $data->id)->pluck('tugas_4');
                $pluck5 = $tugas_sem8->where('id_peserta', $data->id)->pluck('tugas_5');
                $pluck6 = $tugas_sem8->where('id_peserta', $data->id)->pluck('tugas_6');
                $pluck7 = $tugas_sem8->where('id_peserta', $data->id)->pluck('tugas_7');
                $pluck8 = $tugas_sem8->where('id_peserta', $data->id)->pluck('tugas_8');
                $pluck9 = $tugas_sem8->where('id_peserta', $data->id)->pluck('tugas_9');
                $pluck10 = $tugas_sem8->where('id_peserta', $data->id)->pluck('tugas_10');
                $a = collect([$pluck1,$pluck2,$pluck3,$pluck4,$pluck5,$pluck6,$pluck7,$pluck8,$pluck9,$pluck10])->flatten()->toArray();
                $tot = array_filter($a);
                $tot2 = array_count_values($tot);
                if(!array_key_exists("Selesai", $tot2)){
                    $counter_selesai = 0;
                }
                else{
                    $tot3 = $tot2["Selesai"];
                    $counter_selesai = $tot3;
                }
                if($c === null){
                    $table1 = new TugasPesertaSem8;
                    $table1->id_peserta = $data->id;
                    $table1->id_semesterkuliah = $i_s;
                    $query = $table1->save();
                }
                if($b === null){
                    $table2 = new RaporKelulusan;
                    $table2->id_peserta = $data->id;
                    $table2->id_semesterkuliah = $i_s;
                    $table2->kelengkapan_tugas = $counter_selesai;
                    if($counter_selesai == 10){
                        $table2->status_kelulusan = 'Lulus';
                        $query2 = $table2->save();
                    }
                    else{
                        $table2->status_kelulusan = 'Tidak Lulus';
                        $query2 = $table2->save();
                    }
                }
                elseif($b){
                    $table2 = $b;
                    $table2->kelengkapan_tugas = $counter_selesai;
                    if($counter_selesai == 10){
                        $table2->status_kelulusan = 'Lulus';
                        $query2 = $table2->save();
                    }
                    else{
                        $table2->status_kelulusan = 'Tidak Lulus';
                        $query2 = $table2->save();
                    }
                }
            }
        }

        return view('tugas.v_tugas', compact( 'peserta', 't_a', 'angkatan_aktif', 'checker', 'semester_all', 'i_s', 'tugas', 'detail_tugas', 'angkatan', 
        'skema', 'skema_all', 'skemafirst_id', 'skemacurrent_id', 'skemas1', 'skemad3')); 
    }

    public function laporan_tugas(Angkatan $angkatan, Skema $skema, Semesterkuliah $semester)
    {
        $peserta = \App\Models\Peserta::where('id_angkatan', $angkatan->id)->get()->sortBy('nama_peserta');
        $jurusan = \App\Models\Jurusan::ALL();
        $semester_all = \App\Models\Semesterkuliah::ALL();
        $i_s = $semester->id;
        $t_a = $angkatan->tahun_angkatan;
        $angkatan_aktif = \App\Models\Angkatan::where('status_angkatan', 'Aktif')->get()->sortBy('tahun_angkatan');
        $checker = $angkatan_aktif->contains('tahun_angkatan', $t_a);
        $detail_tugas = Detailtugas::where('id_semesterkuliah', $semester->id)->get();
        $peserta_all = \App\Models\Peserta::all();

        $peserta_id = $peserta->map(function ($user) {
            return collect($user->toArray())
                ->only(['id'])
                ->all();
        });

        if($i_s == 1){
            $tugas = \App\Models\TugasPesertaSem1::whereIn('id_peserta', $peserta_id)
            ->orderBy(function ($query){
                $query->select('nama_peserta')
                ->from('peserta')
                ->whereColumn('id', 'id_peserta');
            })->get();
        }
        if($i_s == 2){
            $tugas = \App\Models\TugasPesertaSem2::whereIn('id_peserta', $peserta_id)
            ->orderBy(function ($query){
                $query->select('nama_peserta')
                ->from('peserta')
                ->whereColumn('id', 'id_peserta');
            })->get();
        }
        if($i_s == 3){
            $tugas = \App\Models\TugasPesertaSem3::whereIn('id_peserta', $peserta_id)
            ->orderBy(function ($query){
                $query->select('nama_peserta')
                ->from('peserta')
                ->whereColumn('id', 'id_peserta');
            })->get();
        }
        if($i_s == 4){
            $tugas = \App\Models\TugasPesertaSem4::whereIn('id_peserta', $peserta_id)
            ->orderBy(function ($query){
                $query->select('nama_peserta')
                ->from('peserta')
                ->whereColumn('id', 'id_peserta');
            })->get();
        }
        if($i_s == 5){
            $tugas = \App\Models\TugasPesertaSem5::whereIn('id_peserta', $peserta_id)
            ->orderBy(function ($query){
                $query->select('nama_peserta')
                ->from('peserta')
                ->whereColumn('id', 'id_peserta');
            })->get();
        }
        if($i_s == 6){
            $tugas = \App\Models\TugasPesertaSem6::whereIn('id_peserta', $peserta_id)
            ->orderBy(function ($query){
                $query->select('nama_peserta')
                ->from('peserta')
                ->whereColumn('id', 'id_peserta');
            })->get();
        }
        if($i_s == 7){
            $tugas = \App\Models\TugasPesertaSem7::whereIn('id_peserta', $peserta_id)
            ->orderBy(function ($query){
                $query->select('nama_peserta')
                ->from('peserta')
                ->whereColumn('id', 'id_peserta');
            })->get();
        }
        if($i_s == 8){
            $tugas = \App\Models\TugasPesertaSem8::whereIn('id_peserta', $peserta_id)
            ->orderBy(function ($query){
                $query->select('nama_peserta')
                ->from('peserta')
                ->whereColumn('id', 'id_peserta');
            })->get();
        }

        return view('tugas.v_tugas-laporan', compact( 'peserta', 'jurusan', 't_a', 'angkatan_aktif', 'checker', 'semester_all', 'i_s', 'tugas', 'detail_tugas')); 
    }

    public function edit(Request $request, Angkatan $angkatan, Skema $skema, Semesterkuliah $semester, $id)
    {        
        $i_s = $semester->id;
        $tugas_p = \App\Models\TugasPeserta::all();

        if($i_s == 1){
            $tugas = \App\Models\TugasPesertaSem1::where('id_peserta', $id)->first();
            $tugas->tugas_1 = $request->tugas_1;
            $tugas->tugas_2 = $request->tugas_2;
            $tugas->tugas_3 = $request->tugas_3;
            $tugas->tugas_4 = $request->tugas_4;
            $tugas->tugas_5 = $request->tugas_5;
            $tugas->tugas_6 = $request->tugas_6;
            $tugas->tugas_7 = $request->tugas_7;
            $tugas->tugas_8 = $request->tugas_8;
            $tugas->tugas_9 = $request->tugas_9;
            $tugas->tugas_10 = $request->tugas_10;

            for($i=1; $i<11; $i++){
                if($request->{"tugas_".$i} == "Selesai"){
                    if(!$tugas_p->where('id_tugas', $i)->where('id_peserta', $id)->first()){
                        $table = new TugasPeserta;
                        $table->id_tugas = $i;
                        $table->id_peserta = $id;
                        $table->save();
                    }
                }
                if($request->{"tugas_".$i} == "Belum Selesai" || $request->{"tugas_".$i} == null){
                    \App\Models\TugasPeserta::where('id_tugas', $i)->where('id_peserta', $id)->delete();
                }
            }
        }
        if($i_s == 2){
            $tugas = \App\Models\TugasPesertaSem2::where('id_peserta', $id)->first();
            $tugas->tugas_1 = $request->tugas_1;
            $tugas->tugas_2 = $request->tugas_2;
            $tugas->tugas_3 = $request->tugas_3;
            $tugas->tugas_4 = $request->tugas_4;
            $tugas->tugas_5 = $request->tugas_5;
            $tugas->tugas_6 = $request->tugas_6;
            $tugas->tugas_7 = $request->tugas_7;
            $tugas->tugas_8 = $request->tugas_8;
            $tugas->tugas_9 = $request->tugas_9;
            $tugas->tugas_10 = $request->tugas_10;

            for($i=1; $i<11; $i++){
                if($request->{"tugas_".$i} == "Selesai"){
                    if(!$tugas_p->where('id_tugas', $i+10)->where('id_peserta', $id)->first()){
                        $table = new TugasPeserta;
                        $table->id_tugas = $i+10;
                        $table->id_peserta = $id;
                        $table->save();
                    }
                }
                if($request->{"tugas_".$i} == "Belum Selesai" || $request->{"tugas_".$i} == null){
                    \App\Models\TugasPeserta::where('id_tugas', $i+10)->where('id_peserta', $id)->delete();
                }
            }
        }
        if($i_s == 3){
            $tugas = \App\Models\TugasPesertaSem3::where('id_peserta', $id)->first();
            $tugas->tugas_1 = $request->tugas_1;
            $tugas->tugas_2 = $request->tugas_2;
            $tugas->tugas_3 = $request->tugas_3;
            $tugas->tugas_4 = $request->tugas_4;
            $tugas->tugas_5 = $request->tugas_5;
            $tugas->tugas_6 = $request->tugas_6;
            $tugas->tugas_7 = $request->tugas_7;
            $tugas->tugas_8 = $request->tugas_8;
            $tugas->tugas_9 = $request->tugas_9;
            $tugas->tugas_10 = $request->tugas_10;

            for($i=1; $i<11; $i++){
                if($request->{"tugas_".$i} == "Selesai"){
                    if(!$tugas_p->where('id_tugas', $i+20)->where('id_peserta', $id)->first()){
                        $table = new TugasPeserta;
                        $table->id_tugas = $i+20;
                        $table->id_peserta = $id;
                        $table->save();
                    }
                }
                if($request->{"tugas_".$i} == "Belum Selesai" || $request->{"tugas_".$i} == null){
                    \App\Models\TugasPeserta::where('id_tugas', $i+20)->where('id_peserta', $id)->delete();
                }
            }
        }
        if($i_s == 4){
            $tugas = \App\Models\TugasPesertaSem4::where('id_peserta', $id)->first();
            $tugas->tugas_1 = $request->tugas_1;
            $tugas->tugas_2 = $request->tugas_2;
            $tugas->tugas_3 = $request->tugas_3;
            $tugas->tugas_4 = $request->tugas_4;
            $tugas->tugas_5 = $request->tugas_5;
            $tugas->tugas_6 = $request->tugas_6;
            $tugas->tugas_7 = $request->tugas_7;
            $tugas->tugas_8 = $request->tugas_8;
            $tugas->tugas_9 = $request->tugas_9;
            $tugas->tugas_10 = $request->tugas_10;

            for($i=1; $i<11; $i++){
                if($request->{"tugas_".$i} == "Selesai"){
                    if(!$tugas_p->where('id_tugas', $i+30)->where('id_peserta', $id)->first()){
                        $table = new TugasPeserta;
                        $table->id_tugas = $i+30;
                        $table->id_peserta = $id;
                        $table->save();
                    }
                }
                if($request->{"tugas_".$i} == "Belum Selesai" || $request->{"tugas_".$i} == null){
                    \App\Models\TugasPeserta::where('id_tugas', $i+30)->where('id_peserta', $id)->delete();
                }
            }
        }
        if($i_s == 5){
            $tugas = \App\Models\TugasPesertaSem5::where('id_peserta', $id)->first();
            $tugas->tugas_1 = $request->tugas_1;
            $tugas->tugas_2 = $request->tugas_2;
            $tugas->tugas_3 = $request->tugas_3;
            $tugas->tugas_4 = $request->tugas_4;
            $tugas->tugas_5 = $request->tugas_5;
            $tugas->tugas_6 = $request->tugas_6;
            $tugas->tugas_7 = $request->tugas_7;
            $tugas->tugas_8 = $request->tugas_8;
            $tugas->tugas_9 = $request->tugas_9;
            $tugas->tugas_10 = $request->tugas_10;

            for($i=1; $i<11; $i++){
                if($request->{"tugas_".$i} == "Selesai"){
                    if(!$tugas_p->where('id_tugas', $i+40)->where('id_peserta', $id)->first()){
                        $table = new TugasPeserta;
                        $table->id_tugas = $i+40;
                        $table->id_peserta = $id;
                        $table->save();
                    }
                }
                if($request->{"tugas_".$i} == "Belum Selesai" || $request->{"tugas_".$i} == null){
                    \App\Models\TugasPeserta::where('id_tugas', $i+40)->where('id_peserta', $id)->delete();
                }
            }
        }
        if($i_s == 6){
            $tugas = \App\Models\TugasPesertaSem6::where('id_peserta', $id)->first();
            $tugas->tugas_1 = $request->tugas_1;
            $tugas->tugas_2 = $request->tugas_2;
            $tugas->tugas_3 = $request->tugas_3;
            $tugas->tugas_4 = $request->tugas_4;
            $tugas->tugas_5 = $request->tugas_5;
            $tugas->tugas_6 = $request->tugas_6;
            $tugas->tugas_7 = $request->tugas_7;
            $tugas->tugas_8 = $request->tugas_8;
            $tugas->tugas_9 = $request->tugas_9;
            $tugas->tugas_10 = $request->tugas_10;

            for($i=1; $i<11; $i++){
                if($request->{"tugas_".$i} == "Selesai"){
                    if(!$tugas_p->where('id_tugas', $i+50)->where('id_peserta', $id)->first()){
                        $table = new TugasPeserta;
                        $table->id_tugas = $i+50;
                        $table->id_peserta = $id;
                        $table->save();
                    }
                }
                if($request->{"tugas_".$i} == "Belum Selesai" || $request->{"tugas_".$i} == null){
                    \App\Models\TugasPeserta::where('id_tugas', $i+50)->where('id_peserta', $id)->delete();
                }
            }
        }
        if($i_s == 7){
            $tugas = \App\Models\TugasPesertaSem7::where('id_peserta', $id)->first();
            $tugas->tugas_1 = $request->tugas_1;
            $tugas->tugas_2 = $request->tugas_2;
            $tugas->tugas_3 = $request->tugas_3;
            $tugas->tugas_4 = $request->tugas_4;
            $tugas->tugas_5 = $request->tugas_5;
            $tugas->tugas_6 = $request->tugas_6;
            $tugas->tugas_7 = $request->tugas_7;
            $tugas->tugas_8 = $request->tugas_8;
            $tugas->tugas_9 = $request->tugas_9;
            $tugas->tugas_10 = $request->tugas_10;

            for($i=1; $i<11; $i++){
                if($request->{"tugas_".$i} == "Selesai"){
                    if(!$tugas_p->where('id_tugas', $i+60)->where('id_peserta', $id)->first()){
                        $table = new TugasPeserta;
                        $table->id_tugas = $i+60;
                        $table->id_peserta = $id;
                        $table->save();
                    }
                }
                if($request->{"tugas_".$i} == "Belum Selesai" || $request->{"tugas_".$i} == null){
                    \App\Models\TugasPeserta::where('id_tugas', $i+60)->where('id_peserta', $id)->delete();
                }
            }
        }
        if($i_s == 8){
            $tugas = \App\Models\TugasPesertaSem8::where('id_peserta', $id)->first();
            $tugas->tugas_1 = $request->tugas_1;
            $tugas->tugas_2 = $request->tugas_2;
            $tugas->tugas_3 = $request->tugas_3;
            $tugas->tugas_4 = $request->tugas_4;
            $tugas->tugas_5 = $request->tugas_5;
            $tugas->tugas_6 = $request->tugas_6;
            $tugas->tugas_7 = $request->tugas_7;
            $tugas->tugas_8 = $request->tugas_8;
            $tugas->tugas_9 = $request->tugas_9;
            $tugas->tugas_10 = $request->tugas_10;

            for($i=1; $i<11; $i++){
                if($request->{"tugas_".$i} == "Selesai"){
                    if(!$tugas_p->where('id_tugas', $i+70)->where('id_peserta', $id)->first()){
                        $table = new TugasPeserta;
                        $table->id_tugas = $i+70;
                        $table->id_peserta = $id;
                        $table->save();
                    }
                }
                if($request->{"tugas_".$i} == "Belum Selesai" || $request->{"tugas_".$i} == null){
                    \App\Models\TugasPeserta::where('id_tugas', $i+70)->where('id_peserta', $id)->delete();
                }
            }
        }

        $tugas->save();
        return back()->with('pesan', 'Tugas pertemuan peserta berhasil diedit');
    }
}
