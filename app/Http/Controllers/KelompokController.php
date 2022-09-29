<?php

namespace App\Http\Controllers;

use App\Models\Detailtugas;
use App\Models\Peserta;
use App\Models\Kelulusanpeserta;
use App\Models\Semesterkuliah;
use App\Models\TugasPeserta;
use App\Models\User;
use App\Models\TugasPesertaSem1;
use App\Models\TugasPesertaSem2;
use App\Models\TugasPesertaSem3;
use App\Models\TugasPesertaSem4;
use App\Models\TugasPesertaSem5;
use App\Models\TugasPesertaSem6;
use App\Models\TugasPesertaSem7;
use App\Models\TugasPesertaSem8;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class KelompokController extends Controller
{
    public function index()
    {
        $asisten = User::where('id_role', 2)->get()->sortBy('nama_user');
        $angkatan_aktif = \App\Models\Angkatan::where('status_angkatan', 'Aktif')->get('id')->toArray();
        $peserta = Peserta::whereIn('id_angkatan', $angkatan_aktif)->where('id_asisten', null)->get();

        return view('kelompok.v_kelompok-menu', compact('asisten', 'peserta', 'angkatan_aktif'));
    }

    public function peserta(User $user)
    {
        $asisten = User::where('id', $user->id)->first();
        $angkatan_aktif = \App\Models\Angkatan::where('status_angkatan', 'Aktif')->get('id')->toArray();
        $angkatan_tidakaktif = \App\Models\Angkatan::where('status_angkatan', 'Tidak Aktif')->get('id')->toArray();
        $peserta_kelompok = Peserta::whereIn('id_angkatan', $angkatan_aktif)->where('id_asisten', $user->id)->orderBy('id_angkatan')->orderBy('nama_peserta')->get();
        $peserta_kelompok_ta = Peserta::whereIn('id_angkatan', $angkatan_tidakaktif)->where('id_asisten', $user->id)->orderBy('id_angkatan')->orderBy('nama_peserta')->get();
        $peserta = Peserta::whereIn('id_angkatan', $angkatan_aktif)->where('id_asisten', null)->get();

        return view('kelompok.v_kelompok-peserta', compact('asisten', 'peserta', 'user', 'peserta_kelompok', 'peserta_kelompok_ta'));
    }

    public function peserta_tambah(Request $request, User $user)
    {
        $id_peserta = $request['check-box'];
        Peserta::whereIn('id', $id_peserta)->update(['id_asisten' => $user->id]);
        return back()->with('pesan', 'Peserta berhasil ditambah ke kelompok ini');
    }

    public function peserta_edit(Request $request, User $user, $id)
    {
        $peserta = Peserta::where('id_asisten', $user->id)->where('id', $id)->first();
        $peserta->id_asisten = $request->id_asisten;
        $query = $peserta->save();
        if ($query){
            return back()->with('pesan', 'Peserta berhasil dihapus dari kelompok ini');
        }
    }

    public function kehadiran(User $user)
    {
        $asisten = User::where('id', $user->id)->first();
        $semester = \App\Models\Semesterkuliah::ALL();
        $angkatan_aktif = \App\Models\Angkatan::where('status_angkatan', 'Aktif')->get('id')->toArray();
        $peserta_kelompok = Peserta::whereIn('id_angkatan', $angkatan_aktif)->where('id_asisten', $user->id)->orderBy('id_angkatan')->orderBy('nama_peserta')->get();
        $peserta = Peserta::where('id_asisten', $user->id)->orderBy('id_angkatan')->orderBy('nama_peserta')->get();

        return view('kelompok.v_kelompok-kehadiran', compact('asisten', 'peserta', 'peserta_kelompok', 'user', 'semester'));
    }

    public function kehadiran_semester(User $user, Semesterkuliah $semester)
    {
        $asisten = User::where('id', $user->id)->first();
        $angkatan_aktif = \App\Models\Angkatan::where('status_angkatan', 'Aktif')->get('id')->toArray();
        $peserta_kelompok = Peserta::whereIn('id_angkatan', $angkatan_aktif)->where('id_asisten', $user->id)->orderBy('id_angkatan')->orderBy('nama_peserta')->get();
        $peserta = Peserta::whereIn('id_angkatan', $angkatan_aktif)->where('id_asisten', $user->id)->orderBy('id_angkatan')->orderBy('nama_peserta')->get();        
        $semester_all = \App\Models\Semesterkuliah::ALL();
        $i_s = $semester->id;
        $peserta_id = $peserta->map(function ($user) {
            return collect($user->toArray())
                ->only(['id'])
                ->all();
        });
        $peserta_all = \App\Models\Peserta::all();
        
        foreach ($peserta_all as $data){
            $data->semesterkehadiran()->sync([1,2,3,4,5,6,7,8]);
        }

        $kehadiran = \App\Models\KehadiranPeserta::where('id_semesterkuliah', $i_s)->whereIn('id_peserta', $peserta_id)
        ->orderBy(function ($query){
            $query->select('id_angkatan')
            ->from('peserta')
            ->whereColumn('id', 'id_peserta');
        })
        ->orderBy(function ($query){
            $query->select('nama_peserta')
            ->from('peserta')
            ->whereColumn('id', 'id_peserta');
        })->get();

        return view('kelompok.v_kelompok-kehadiran-semester', compact('asisten', 'peserta', 'peserta_kelompok', 'user', 'semester_all', 'i_s', 'kehadiran'));
    }

    public function edit_kehadiran(Request $request, $tahun_angkatan, $id_semester, $id)
    {
        $i_s = $id_semester;
        
        $cek = Kelulusanpeserta::where('id_peserta', $id)->first();
        if(!$cek){
            $table = new Kelulusanpeserta;
            $table->id_peserta = $id;
            $query = $table->save();
        }

        $peserta = Peserta::where('id', $id)->first();

        $query = $peserta->semesterkehadiran()->syncWithoutDetaching([$id_semester =>
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
            $tot3 = $tot2["Hadir"];
            $counter_kehadiran = $tot3/80*100;
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

    public function tugas(User $user)
    {
        $asisten = User::where('id', $user->id)->first();
        $semester = \App\Models\Semesterkuliah::ALL();
        $angkatan_aktif = \App\Models\Angkatan::where('status_angkatan', 'Aktif')->get('id')->toArray();
        $peserta_kelompok = Peserta::whereIn('id_angkatan', $angkatan_aktif)->where('id_asisten', $user->id)->orderBy('id_angkatan')->orderBy('nama_peserta')->get();
        $peserta = Peserta::where('id_asisten', $user->id)->orderBy('id_angkatan')->orderBy('nama_peserta')->get();

        return view('kelompok.v_kelompok-tugas', compact('asisten', 'peserta', 'peserta_kelompok', 'user', 'semester'));
    }

    public function tugas_semester(User $user, Semesterkuliah $semester)
    {
        $asisten = User::where('id', $user->id)->first();
        $angkatan_aktif = \App\Models\Angkatan::where('status_angkatan', 'Aktif')->get('id')->toArray();
        $peserta_kelompok = Peserta::whereIn('id_angkatan', $angkatan_aktif)->where('id_asisten', $user->id)->orderBy('id_angkatan')->orderBy('nama_peserta')->get();
        $peserta = Peserta::whereIn('id_angkatan', $angkatan_aktif)->where('id_asisten', $user->id)->orderBy('id_angkatan')->orderBy('nama_peserta')->get();        
        $semester_all = \App\Models\Semesterkuliah::ALL();
        $detail_tugas = Detailtugas::where('id_semesterkuliah', $semester->id)->get();
        $i_s = $semester->id;
        $peserta_id = $peserta->map(function ($user) {
            return collect($user->toArray())
                ->only(['id'])
                ->all();
        });

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

        foreach ($peserta_kelompok as $data){
            $a = $tugas_sem1->where('id_peserta', $data->id)->first();
            $b = $tugas_sem2->where('id_peserta', $data->id)->first();
            $c = $tugas_sem3->where('id_peserta', $data->id)->first();
            $d = $tugas_sem4->where('id_peserta', $data->id)->first();
            $e = $tugas_sem5->where('id_peserta', $data->id)->first();
            $f = $tugas_sem6->where('id_peserta', $data->id)->first();
            $g = $tugas_sem7->where('id_peserta', $data->id)->first();
            $h = $tugas_sem8->where('id_peserta', $data->id)->first();
            if($a === null){
                $table1 = new TugasPesertaSem1;
                $table1->id_peserta = $data->id;
                $table1->id_semesterkuliah = 1;
                $query = $table1->save();
            }
            if($b === null){
                $table2 = new TugasPesertaSem2;
                $table2->id_peserta = $data->id;
                $table2->id_semesterkuliah = 2;
                $query = $table2->save();
            }
            if($c === null){
                $table3 = new TugasPesertaSem3;
                $table3->id_peserta = $data->id;
                $table3->id_semesterkuliah = 3;
                $query = $table3->save();
            }
            if($d === null){
                $table4 = new TugasPesertaSem4;
                $table4->id_peserta = $data->id;
                $table4->id_semesterkuliah = 4;
                $query = $table4->save();
            }
            if($e === null){
                $table5 = new TugasPesertaSem5;
                $table5->id_peserta = $data->id;
                $table5->id_semesterkuliah = 5;
                $query = $table5->save();
            }
            if($f === null){
                $table6 = new TugasPesertaSem6;
                $table6->id_peserta = $data->id;
                $table6->id_semesterkuliah = 6;
                $query = $table6->save();
            }
            if($g === null){
                $table7 = new TugasPesertaSem7;
                $table7->id_peserta = $data->id;
                $table7->id_semesterkuliah = 7;
                $query = $table7->save();
            }
            if($h === null){
                $table8 = new TugasPesertaSem8;
                $table8->id_peserta = $data->id;
                $table8->id_semesterkuliah = 8;
                $query = $table8->save();
            }
        }

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

        return view('kelompok.v_kelompok-tugas-semester', compact('asisten', 'peserta', 'peserta_kelompok', 'user', 'semester_all', 'i_s', 'tugas', 'detail_tugas'));
    }

    public function edit_tugas(Request $request, $tahun_angkatan, Semesterkuliah $semester, $id)
    {
        $i_s = $semester->id;
        $tugas_p = \App\Models\TugasPeserta::all();

        $cek = Kelulusanpeserta::where('id_peserta', $id)->first();
        if(!$cek){
            $table = new Kelulusanpeserta;
            $table->id_peserta = $id;
            $query = $table->save();
        }

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

        $query = $tugas->save();

        if ($query){
            $counter_tugas = \App\Models\TugasPeserta::where('id_peserta', $id)->count()/80*100;
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
                $query = $table2->save();
            }
            elseif($zz){
                $table2 = $zz;
                $table2->kelengkapan_tugas = $counter_tugas;
                $table2->status_kelulusan = $status;
                $query = $table2->save();
            }

            return back()->with('pesan', 'Tugas peserta berhasil diedit');
        }
    }
}
