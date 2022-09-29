<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Angkatan;
use App\Models\AsistenpenilaiRaporPeserta;
use App\Models\CatatanRaporPeserta;
use App\Models\TanggalperiksaRaporPeserta;
use App\Models\Semesterkuliah;
use App\Models\SemesterperiodeAngkatan;
use App\Models\RaporPeserta;
use App\Models\TugasPeserta;
use App\Models\Peserta;
use App\Models\Rapord3;
use App\Models\Kelulusanpeserta;
use App\Models\RaporKelulusan;
use App\Models\Skema;
use App\Models\TugasPesertaSem1;
use App\Models\TugasPesertaSem2;
use App\Models\TugasPesertaSem3;
use App\Models\TugasPesertaSem4;
use App\Models\TugasPesertaSem5;
use App\Models\TugasPesertaSem6;
use App\Models\TugasPesertaSem7;
use App\Models\TugasPesertaSem8;
use Illuminate\Http\Request;

class RaporPesertaController extends Controller
{
    public function index(Angkatan $angkatan, Skema $skema)
    {
        $peserta = \App\Models\Peserta::where('id_angkatan', $angkatan->id)->get()->sortBy('nama_peserta');
        $semester = \App\Models\Semesterkuliah::ALL();
        $t_a = $angkatan->tahun_angkatan;
        $angkatan_aktif = \App\Models\Angkatan::where('status_angkatan', 'Aktif')->get()->sortBy('tahun_angkatan');
        $checker = $angkatan_aktif->contains('tahun_angkatan', $t_a);
        foreach ($peserta as $data){
            $data->rapor()->sync([1,2,3,4,5,6,7,8]);
        }
        foreach ($semester as $data){
            $data->rapord3()->sync([1,2,3,4,5,6,7,8,9,10]);
        }
        $skemafirst_id = \App\Models\Skema::first()->id;
        return view('rapor.v_rapor-angkatan', compact( 'peserta', 't_a', 'angkatan_aktif', 'checker', 'semester', 'angkatan', 'skemafirst_id'));
    }

    public function show(Angkatan $angkatan, Skema $skema, Semesterkuliah $semester)
    {
        global $kehadiran, $rapor_kelulusan, $peserta;
        $peserta = \App\Models\Peserta::where('id_angkatan', $angkatan->id)->get()->sortBy('nama_peserta');
        foreach ($peserta as $data){
            $data->rapor()->sync([1,2,3,4,5,6,7,8]);
        }
        $semester_all = \App\Models\Semesterkuliah::ALL();
        foreach ($semester_all as $data){
            $data->rapord3()->sync([1,2,3,4,5,6,7,8,9,10]);
        }
        $skema_all = \App\Models\Skema::orderBy('id')->get();
        $skemafirst_id = \App\Models\Skema::first()->id;
        $skemacurrent_id = $skema->id;
        $skemacurrent_nama = $skema->nama_skema;
        $skemas1 = \App\Models\Skema::where('nama_skema', 'Pembuat Ide Gerak & Cerita (Generalist)')->first();
        $skemad3 = \App\Models\Skema::where('nama_skema', '3D Illustration Artist')->first();
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
        $rapor_kelulusan = \App\Models\RaporKelulusan::all();
        $raporp_all = \App\Models\RaporPeserta::whereIn('id_peserta', $peserta_id)->where('id_semesterkuliah', $i_s)
        ->orderBy(function ($query){
            $query->select('nama_peserta')
            ->from('peserta')
            ->whereColumn('id', 'id_peserta');
        })->get();
        $spa_check = \App\Models\SemesterperiodeAngkatan::where('id_angkatan', $angkatan->id)->first();
        if($spa_check === null){
            $table = new SemesterperiodeAngkatan;
            $table->id_angkatan = $angkatan->id;
            $query = $table->save();
        }

        $kehadiran = \App\Models\KehadiranPeserta::where('id_semesterkuliah', $i_s)->get();

        function showPersemester($i_s, $tugas_sem, $table){
            global $kehadiran, $rapor_kelulusan, $peserta;

            foreach ($peserta as $data){

                $plucks1 = $kehadiran->where('id_peserta', $data->id)->pluck('pertemuan_1');
                $plucks2 = $kehadiran->where('id_peserta', $data->id)->pluck('pertemuan_2');
                $plucks3 = $kehadiran->where('id_peserta', $data->id)->pluck('pertemuan_3');
                $plucks4 = $kehadiran->where('id_peserta', $data->id)->pluck('pertemuan_4');
                $plucks5 = $kehadiran->where('id_peserta', $data->id)->pluck('pertemuan_5');
                $plucks6 = $kehadiran->where('id_peserta', $data->id)->pluck('pertemuan_6');
                $plucks7 = $kehadiran->where('id_peserta', $data->id)->pluck('pertemuan_7');
                $plucks8 = $kehadiran->where('id_peserta', $data->id)->pluck('pertemuan_8');
                $plucks9 = $kehadiran->where('id_peserta', $data->id)->pluck('pertemuan_9');
                $plucks10 = $kehadiran->where('id_peserta', $data->id)->pluck('pertemuan_10');
                $e = collect([$plucks1,$plucks2,$plucks3,$plucks4,$plucks5,$plucks6,$plucks7,$plucks8,$plucks9,$plucks10])->flatten()->toArray();
                $f = array_filter($e);
                $g = array_count_values($f);
                if(!array_key_exists("Hadir", $g)){
                    $counter_hadir = 0;
                }
                else{
                    $h = $g["Hadir"];
                    $counter_hadir = $h;
                }
                
                $c = $tugas_sem->where('id_peserta', $data->id)->first();
                $b = $rapor_kelulusan->where('id_peserta', $data->id)->where('id_semesterkuliah', $i_s)->first();
                $pluck1 = $tugas_sem->where('id_peserta', $data->id)->pluck('tugas_1');
                $pluck2 = $tugas_sem->where('id_peserta', $data->id)->pluck('tugas_2');
                $pluck3 = $tugas_sem->where('id_peserta', $data->id)->pluck('tugas_3');
                $pluck4 = $tugas_sem->where('id_peserta', $data->id)->pluck('tugas_4');
                $pluck5 = $tugas_sem->where('id_peserta', $data->id)->pluck('tugas_5');
                $pluck6 = $tugas_sem->where('id_peserta', $data->id)->pluck('tugas_6');
                $pluck7 = $tugas_sem->where('id_peserta', $data->id)->pluck('tugas_7');
                $pluck8 = $tugas_sem->where('id_peserta', $data->id)->pluck('tugas_8');
                $pluck9 = $tugas_sem->where('id_peserta', $data->id)->pluck('tugas_9');
                $pluck10 = $tugas_sem->where('id_peserta', $data->id)->pluck('tugas_10');
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
                    $table1 = $table;
                    $table1->id_peserta = $data->id;
                    $table1->id_semesterkuliah = $i_s;
                    $query = $table1->save();
                }
                if($b === null){
                    $table2 = new RaporKelulusan;
                    $table2->id_peserta = $data->id;
                    $table2->id_semesterkuliah = $i_s;
                    $table2->kehadiran = $counter_hadir;
                    $table2->kelengkapan_tugas = $counter_selesai;
                    if($counter_selesai > 4 && $counter_hadir > 4){
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
                    $table2->kehadiran = $counter_hadir;
                    if($counter_selesai > 4 && $counter_hadir > 4){
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

        if($i_s == 1){
            $tugas_sem = \App\Models\TugasPesertaSem1::all();
            $table1 = new TugasPesertaSem1;
            showPersemester(1, $tugas_sem, $table1);
            $rapor = \App\Models\RaporSem1::all();
            $spa =  \App\Models\SemesterperiodeAngkatan::where('id_angkatan', $angkatan->id)->first()->semester_1;
        }
        if($i_s == 2){
            $tugas_sem = \App\Models\TugasPesertaSem2::all();
            $table1 = new TugasPesertaSem2;
            showPersemester(2, $tugas_sem, $table1);
            $rapor = \App\Models\RaporSem2::all();
            $spa =  \App\Models\SemesterperiodeAngkatan::where('id_angkatan', $angkatan->id)->first()->semester_2;
        }
        if($i_s == 3){
            $tugas_sem = \App\Models\TugasPesertaSem3::all();
            $table1 = new TugasPesertaSem3;
            showPersemester(3, $tugas_sem, $table1);
            $rapor = \App\Models\RaporSem3::all();
            $spa =  \App\Models\SemesterperiodeAngkatan::where('id_angkatan', $angkatan->id)->first()->semester_3;
        }
        if($i_s == 4){
            $tugas_sem = \App\Models\TugasPesertaSem4::all();
            $table1 = new TugasPesertaSem4;
            showPersemester(4, $tugas_sem, $table1);
            $rapor = \App\Models\RaporSem4::all();
            $spa =  \App\Models\SemesterperiodeAngkatan::where('id_angkatan', $angkatan->id)->first()->semester_4;
        }
        if($i_s == 5){
            $tugas_sem = \App\Models\TugasPesertaSem5::all();
            $table1 = new TugasPesertaSem5;
            showPersemester(5, $tugas_sem, $table1);
            $rapor = \App\Models\RaporSem5::all();
            $spa =  \App\Models\SemesterperiodeAngkatan::where('id_angkatan', $angkatan->id)->first()->semester_5;
        }
        if($i_s == 6){
            $tugas_sem = \App\Models\TugasPesertaSem6::all();
            $table1 = new TugasPesertaSem6;
            showPersemester(6, $tugas_sem, $table1);
            $rapor = \App\Models\RaporSem6::all();
            $spa =  \App\Models\SemesterperiodeAngkatan::where('id_angkatan', $angkatan->id)->first()->semester_6;
        }
        if($i_s == 7){
            $tugas_sem = \App\Models\TugasPesertaSem7::all();
            $table1 = new TugasPesertaSem7;
            showPersemester(7, $tugas_sem, $table1);
            $rapor = \App\Models\RaporSem7::all();
            $spa =  \App\Models\SemesterperiodeAngkatan::where('id_angkatan', $angkatan->id)->first()->semester_7;
        }
        if($i_s == 8){
            $tugas_sem = \App\Models\TugasPesertaSem8::all();
            $table1 = new TugasPesertaSem8;
            showPersemester(8, $tugas_sem, $table1);
            $rapor = \App\Models\RaporSem8::all();
            $spa =  \App\Models\SemesterperiodeAngkatan::where('id_angkatan', $angkatan->id)->first()->semester_8;
        }
        

        foreach ($raporp_all as $data){
            $a = \App\Models\AsistenpenilaiRaporPeserta::where('id_rapor_peserta', $data->id)->first();
            $b = \App\Models\CatatanRaporPeserta::where('id_rapor_peserta', $data->id)->first();
            $c = \App\Models\TanggalperiksaRaporPeserta::where('id_rapor_peserta', $data->id)->first();
            if(!$a){
                $table = new AsistenpenilaiRaporPeserta;
                $table->id_rapor_peserta = $data->id;
                $table->save();
            }
            if(!$b){
                $table = new CatatanRaporPeserta;
                $table->id_rapor_peserta = $data->id;
                $table->save();
            }
            if(!$c){
                $table = new TanggalperiksaRaporPeserta;
                $table->id_rapor_peserta = $data->id;
                $table->save();
            }
        }
        
        $rapord3 = Rapord3::where('id_semesterkuliah', $i_s)->get();

        $pesertaskema = \App\Models\Peserta::where('id_angkatan', $angkatan->id)->where('id_skema', $skemacurrent_id)->get()->sortBy('nama_peserta');
        $pesertaskema_id = $pesertaskema->map(function ($user) {
            return collect($user->toArray())
            ->only(['id'])
            ->all();
        });
        $raporp = \App\Models\RaporPeserta::whereIn('id_peserta', $pesertaskema_id)->where('id_semesterkuliah', $i_s)
        ->orderBy(function ($query){
            $query->select('nama_peserta')
            ->from('peserta')
            ->whereColumn('id', 'id_peserta');
        })->get();

        return view('rapor.v_rapor', 
        compact( 'peserta', 't_a', 'angkatan_aktif', 'checker', 'semester_all', 'i_s', 'rapor', 'rapord3', 'raporp', 'spa', 'angkatan', 
        'skemafirst_id', 'skema_all', 'skemacurrent_id', 'skemacurrent_nama' ,'skema', 'skemas1', 'skemad3')); 
    }

    public function laporan_semester(Angkatan $angkatan, Skema $skema, Semesterkuliah $semester)
    {
        $peserta = \App\Models\Peserta::where('id_angkatan', $angkatan->id)->get()->sortBy('nama_peserta');
        $peserta_s1 = \App\Models\Peserta::where('id_angkatan', $angkatan->id)->where('id_skema', 1)->get()->sortBy('nama_peserta');
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
        $pesertas1_id = $peserta_s1->map(function ($user) {
            return collect($user->toArray())
                ->only(['id'])
                ->all();
        });
        
        if($i_s == 1){
            $rapor_kelulusan = \App\Models\RaporKelulusan::whereIn('id_peserta', $peserta_id)->where('id_semesterkuliah', $i_s)->orderBy(function ($query){
                $query->select('nama_peserta')
                ->from('peserta')
                ->whereColumn('id', 'id_peserta');
            })->get();
            $spa =  \App\Models\SemesterperiodeAngkatan::where('id_angkatan', $angkatan->id)->first()->semester_1;
        }
        if($i_s == 2){
            $rapor_kelulusan = \App\Models\RaporKelulusan::whereIn('id_peserta', $peserta_id)->where('id_semesterkuliah', $i_s)->orderBy(function ($query){
                $query->select('nama_peserta')
                ->from('peserta')
                ->whereColumn('id', 'id_peserta');
            })->get();            
            $spa =  \App\Models\SemesterperiodeAngkatan::where('id_angkatan', $angkatan->id)->first()->semester_2;
        }
        if($i_s == 3){
            $rapor_kelulusan = \App\Models\RaporKelulusan::whereIn('id_peserta', $peserta_id)->where('id_semesterkuliah', $i_s)->orderBy(function ($query){
                $query->select('nama_peserta')
                ->from('peserta')
                ->whereColumn('id', 'id_peserta');
            })->get();           
            $spa =  \App\Models\SemesterperiodeAngkatan::where('id_angkatan', $angkatan->id)->first()->semester_3;
        }
        if($i_s == 4){
            $rapor_kelulusan = \App\Models\RaporKelulusan::whereIn('id_peserta', $peserta_id)->where('id_semesterkuliah', $i_s)->orderBy(function ($query){
                $query->select('nama_peserta')
                ->from('peserta')
                ->whereColumn('id', 'id_peserta');
            })->get();         
            $spa =  \App\Models\SemesterperiodeAngkatan::where('id_angkatan', $angkatan->id)->first()->semester_4;
        }
        if($i_s == 5){
            $rapor_kelulusan = \App\Models\RaporKelulusan::whereIn('id_peserta', $peserta_id)->where('id_semesterkuliah', $i_s)->orderBy(function ($query){
                $query->select('nama_peserta')
                ->from('peserta')
                ->whereColumn('id', 'id_peserta');
            })->get();        
            $spa =  \App\Models\SemesterperiodeAngkatan::where('id_angkatan', $angkatan->id)->first()->semester_5;
        }
        if($i_s == 6){
            $rapor_kelulusan = \App\Models\RaporKelulusan::whereIn('id_peserta', $peserta_id)->where('id_semesterkuliah', $i_s)->orderBy(function ($query){
                $query->select('nama_peserta')
                ->from('peserta')
                ->whereColumn('id', 'id_peserta');
            })->get();      
            $spa =  \App\Models\SemesterperiodeAngkatan::where('id_angkatan', $angkatan->id)->first()->semester_6;
        }
        if($i_s == 7){
            $rapor_kelulusan = \App\Models\RaporKelulusan::whereIn('id_peserta', $pesertas1_id)->where('id_semesterkuliah', $i_s)->orderBy(function ($query){
                $query->select('nama_peserta')
                ->from('peserta')
                ->whereColumn('id', 'id_peserta');
            })->get();         
            $spa =  \App\Models\SemesterperiodeAngkatan::where('id_angkatan', $angkatan->id)->first()->semester_7;
        }
        if($i_s == 8){
            $rapor_kelulusan = \App\Models\RaporKelulusan::whereIn('id_peserta', $pesertas1_id)->where('id_semesterkuliah', $i_s)->orderBy(function ($query){
                $query->select('nama_peserta')
                ->from('peserta')
                ->whereColumn('id', 'id_peserta');
            })->get(); 
            $spa =  \App\Models\SemesterperiodeAngkatan::where('id_angkatan', $angkatan->id)->first()->semester_8;
        }

        return view('rapor.v_rapor-laporansemester', 
        compact( 'peserta', 't_a', 'angkatan_aktif', 'checker', 'i_s', 'spa', 'angkatan', 'rapor_kelulusan')); 
    }

    public function rangkuman(Angkatan $angkatan)
    {
        $peserta = \App\Models\Peserta::where('id_angkatan', $angkatan->id)->get()->sortBy('nama_peserta');
        $peserta_s1 = \App\Models\Peserta::where('id_angkatan', $angkatan->id)->where('id_skema', 1)->get()->sortBy('nama_peserta');
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
        $pesertas1_id = $peserta_s1->map(function ($user) {
            return collect($user->toArray())
            ->only(['id'])
            ->all();
        });
        $rapor_kelulusan = \App\Models\RaporKelulusan::whereIn('id_peserta', $peserta_id)->orderBy(function ($query){
            $query->select('nama_peserta')
            ->from('peserta')
            ->whereColumn('id', 'id_peserta');
        })->get();    
        $array_totalkelulusan = array();
        foreach ($peserta as $data){
            $total_kelulusan = \App\Models\RaporKelulusan::where('id_peserta', $data->id)->where('status_kelulusan','Lulus')->orderBy(function ($query){
                $query->select('nama_peserta')
                ->from('peserta')
                ->whereColumn('id', 'id_peserta');
            })->count();
            $array_totalkelulusan[] = $total_kelulusan;
        }
        
        return view('rapor.v_rapor-rangkuman', 
        compact( 'peserta', 't_a', 'angkatan_aktif', 'checker', 'angkatan', 'rapor_kelulusan', 'array_totalkelulusan')); 
    }

    public function edit_semesterperiode(Request $request, Angkatan $angkatan, Skema $skema, Semesterkuliah $semester)
    {
        $i_s = $semester->id;
        $spa_check = \App\Models\SemesterperiodeAngkatan::where('id_angkatan', $angkatan->id)->first();

        if($i_s == 1){
            $table = $spa_check;
            $table->semester_1 = $request->nama_semesterperiode;
        }
        if($i_s == 2){
            $table = $spa_check;
            $table->semester_2 = $request->nama_semesterperiode;
        }
        if($i_s == 3){
            $table = $spa_check;
            $table->semester_3 = $request->nama_semesterperiode;
        }
        if($i_s == 4){
            $table = $spa_check;
            $table->semester_4 = $request->nama_semesterperiode;
        }
        if($i_s == 5){
            $table = $spa_check;
            $table->semester_5 = $request->nama_semesterperiode;
        }
        if($i_s == 6){
            $table = $spa_check;
            $table->semester_6 = $request->nama_semesterperiode;
        }
        if($i_s == 7){
            $table = $spa_check;
            $table->semester_7 = $request->nama_semesterperiode;
        }
        if($i_s == 8){
            $table = $spa_check;
            $table->semester_8 = $request->nama_semesterperiode;
        }

        $query = $table->save();

        if ($query){
            return back()->with('pesan', 'Semester periode angkatan berhasil diedit');
        }
    }

    public function edit_pertemuan(Request $request, Angkatan $angkatan, Skema $skema, Semesterkuliah $semester, $id)
    {
        $i_s = $semester->id;

        if($request->exists('nama_tugasd3')){
            $rapor = \App\Models\Rapord3::where('id', $id)->first();
            $table = $rapor;
            $table->nama_pertemuan = $request->nama_pertemuand3;
            $table->nama_tugas = $request->nama_tugasd3; 
        }
        else{
            if($i_s == 1){
                $rapor = \App\Models\RaporSem1::where('id', $id)->first();
                $table = $rapor;
                $table->nama_pertemuan = $request->nama_pertemuan;
                $table->nama_tugas = $request->nama_tugas;
            }
            if($i_s == 2){
                $rapor = \App\Models\RaporSem2::where('id', $id)->first();
                $table = $rapor;
                $table->nama_pertemuan = $request->nama_pertemuan;
                $table->nama_tugas = $request->nama_tugas;
            }
            if($i_s == 3){
                $rapor = \App\Models\RaporSem3::where('id', $id)->first();
                $table = $rapor;
                $table->nama_pertemuan = $request->nama_pertemuan;
                $table->nama_tugas = $request->nama_tugas;
            }
            if($i_s == 4){
                $rapor = \App\Models\RaporSem4::where('id', $id)->first();
                $table = $rapor;
                $table->nama_pertemuan = $request->nama_pertemuan;
                $table->nama_tugas = $request->nama_tugas;
            }
            if($i_s == 5){
                $rapor = \App\Models\RaporSem5::where('id', $id)->first();
                $table = $rapor;
                $table->nama_pertemuan = $request->nama_pertemuan;
                $table->nama_tugas = $request->nama_tugas;
            }
            if($i_s == 6){
                $rapor = \App\Models\RaporSem6::where('id', $id)->first();
                $table = $rapor;
                $table->nama_pertemuan = $request->nama_pertemuan;
                $table->nama_tugas = $request->nama_tugas;
            }
            if($i_s == 7){
                $rapor = \App\Models\RaporSem7::where('id', $id)->first();
                $table = $rapor;
                $table->nama_pertemuan = $request->nama_pertemuan;
                $table->nama_tugas = $request->nama_tugas;
            }
            if($i_s == 8){
                $rapor = \App\Models\RaporSem8::where('id', $id)->first();
                $table = $rapor;
                $table->nama_pertemuan = $request->nama_pertemuan;
                $table->nama_tugas = $request->nama_tugas;
            }
        }

        $query = $table->save();

        if ($query){
            return back()->with('pesan', 'Pertemuan berhasil diedit');
        }
    }

    public function rapor_peserta(Angkatan $angkatan, Skema $skema, Semesterkuliah $semester, RaporPeserta $rapor_peserta)
    {
        global $kehadiran_all, $rapor_kelulusan;

        $peserta = \App\Models\Peserta::where('id_angkatan', $angkatan->id)->get()->sortBy('nama_peserta');
        $semester_all = \App\Models\Semesterkuliah::ALL();
        $i_p = $rapor_peserta->peserta->id;
        $i_r = $rapor_peserta->id;
        $i_s = $semester->id;
        $t_a = $angkatan->tahun_angkatan;
        $angkatan_aktif = \App\Models\Angkatan::where('status_angkatan', 'Aktif')->get()->sortBy('tahun_angkatan');
        $checker = $angkatan_aktif->contains('tahun_angkatan', $t_a);
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
        $rapor_kelulusan = \App\Models\RaporKelulusan::all();
        $asisten = User::whereIn('id_role', [1,2])->orderBy('nama_user')->get();
        $rapor = \App\Models\RaporPeserta::where('id', $i_r)->first();
        $skema_check = \App\Models\Peserta::where('id', $i_p)->first()->id_jurusan;
        $kehadiran_all = \App\Models\KehadiranPeserta::where('id_semesterkuliah', $i_s)->get();
        $kehadiran = \App\Models\KehadiranPeserta::where('id_semesterkuliah', $i_s)->where('id_peserta', $rapor_peserta->peserta->id)->first();

        function showRapor($i_s, $i_p, $tugas_sem){
            global $kehadiran_all, $rapor_kelulusan;

            $plucks1 = $kehadiran_all->where('id_peserta', $i_p)->pluck('pertemuan_1');
            $plucks2 = $kehadiran_all->where('id_peserta', $i_p)->pluck('pertemuan_2');
            $plucks3 = $kehadiran_all->where('id_peserta', $i_p)->pluck('pertemuan_3');
            $plucks4 = $kehadiran_all->where('id_peserta', $i_p)->pluck('pertemuan_4');
            $plucks5 = $kehadiran_all->where('id_peserta', $i_p)->pluck('pertemuan_5');
            $plucks6 = $kehadiran_all->where('id_peserta', $i_p)->pluck('pertemuan_6');
            $plucks7 = $kehadiran_all->where('id_peserta', $i_p)->pluck('pertemuan_7');
            $plucks8 = $kehadiran_all->where('id_peserta', $i_p)->pluck('pertemuan_8');
            $plucks9 = $kehadiran_all->where('id_peserta', $i_p)->pluck('pertemuan_9');
            $plucks10 = $kehadiran_all->where('id_peserta', $i_p)->pluck('pertemuan_10');
            $e = collect([$plucks1,$plucks2,$plucks3,$plucks4,$plucks5,$plucks6,$plucks7,$plucks8,$plucks9,$plucks10])->flatten()->toArray();
            $f = array_filter($e);
            $g = array_count_values($f);
            if(!array_key_exists("Hadir", $g)){
                $counter_hadir = 0;
            }
            else{
                $h = $g["Hadir"];
                $counter_hadir = $h;
            }
            
            $pluck1 = $tugas_sem->where('id_peserta', $i_p)->pluck('tugas_1');
            $pluck2 = $tugas_sem->where('id_peserta', $i_p)->pluck('tugas_2');
            $pluck3 = $tugas_sem->where('id_peserta', $i_p)->pluck('tugas_3');
            $pluck4 = $tugas_sem->where('id_peserta', $i_p)->pluck('tugas_4');
            $pluck5 = $tugas_sem->where('id_peserta', $i_p)->pluck('tugas_5');
            $pluck6 = $tugas_sem->where('id_peserta', $i_p)->pluck('tugas_6');
            $pluck7 = $tugas_sem->where('id_peserta', $i_p)->pluck('tugas_7');
            $pluck8 = $tugas_sem->where('id_peserta', $i_p)->pluck('tugas_8');
            $pluck9 = $tugas_sem->where('id_peserta', $i_p)->pluck('tugas_9');
            $pluck10 = $tugas_sem->where('id_peserta', $i_p)->pluck('tugas_10');
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
            $b = $rapor_kelulusan->where('id_peserta', $i_p)->where('id_semesterkuliah', $i_s)->first();
            if($b){
                $table2 = $b;
                $table2->kelengkapan_tugas = $counter_selesai;
                $table2->kehadiran = $counter_hadir;
                if($counter_selesai > 4 && $counter_hadir > 4){
                    $table2->status_kelulusan = 'Lulus';
                    $query2 = $table2->save();
                }
                else{
                    $table2->status_kelulusan = 'Tidak Lulus';
                    $query2 = $table2->save();
                }
            }

        }

        if($i_s == 1){
            if($skema_check == 3){
                $raporsem = Rapord3::where('id_semesterkuliah', $i_s)->get();
            }
            else{
                $raporsem = \App\Models\RaporSem1::all();
            }
            $spa =  \App\Models\SemesterperiodeAngkatan::where('id_angkatan', $angkatan->id)->first()->semester_1;
            $tugas_sem = \App\Models\TugasPesertaSem1::all();
            $tugas = $tugas_sem->where('id_peserta', $i_p)->first();

            showRapor($i_s, $i_p, $tugas_sem);
        }
        if($i_s == 2){
            if($skema_check == 3){
                $raporsem = Rapord3::where('id_semesterkuliah', $i_s)->get();
            }
            else{
                $raporsem = \App\Models\RaporSem2::all();
            }
            $spa =  \App\Models\SemesterperiodeAngkatan::where('id_angkatan', $angkatan->id)->first()->semester_2;
            $tugas_sem = \App\Models\TugasPesertaSem2::all();
            $tugas = $tugas_sem->where('id_peserta', $i_p)->first();

            showRapor($i_s, $i_p, $tugas_sem);
        }
        if($i_s == 3){
            if($skema_check == 3){
                $raporsem = Rapord3::where('id_semesterkuliah', $i_s)->get();
            }
            else{
                $raporsem = \App\Models\RaporSem3::all();
            }
            $spa =  \App\Models\SemesterperiodeAngkatan::where('id_angkatan', $angkatan->id)->first()->semester_3;
            $tugas_sem = \App\Models\TugasPesertaSem3::all();
            $tugas = $tugas_sem->where('id_peserta', $i_p)->first();

            showRapor($i_s, $i_p, $tugas_sem);
        }
        if($i_s == 4){
            if($skema_check == 3){
                $raporsem = Rapord3::where('id_semesterkuliah', $i_s)->get();
            }
            else{
                $raporsem = \App\Models\RaporSem4::all();
            }
            $spa =  \App\Models\SemesterperiodeAngkatan::where('id_angkatan', $angkatan->id)->first()->semester_4;
            $tugas_sem = \App\Models\TugasPesertaSem4::all();
            $tugas = $tugas_sem->where('id_peserta', $i_p)->first();

            showRapor($i_s, $i_p, $tugas_sem);
        }
        if($i_s == 5){
            if($skema_check == 3){
                $raporsem = Rapord3::where('id_semesterkuliah', $i_s)->get();
            }
            else{
                $raporsem = \App\Models\RaporSem5::all();
            }
            $spa =  \App\Models\SemesterperiodeAngkatan::where('id_angkatan', $angkatan->id)->first()->semester_5;
            $tugas_sem = \App\Models\TugasPesertaSem5::all();
            $tugas = $tugas_sem->where('id_peserta', $i_p)->first();

            showRapor($i_s, $i_p, $tugas_sem);
        }
        if($i_s == 6){
            if($skema_check == 3){
                $raporsem = Rapord3::where('id_semesterkuliah', $i_s)->get();
            }
            else{
                $raporsem = \App\Models\RaporSem6::all();
            }
            $spa =  \App\Models\SemesterperiodeAngkatan::where('id_angkatan', $angkatan->id)->first()->semester_6;
            $tugas_sem = \App\Models\TugasPesertaSem6::all();
            $tugas = $tugas_sem->where('id_peserta', $i_p)->first();

            showRapor($i_s, $i_p, $tugas_sem);
        }
        if($i_s == 7){
            if($skema_check == 3){
                $raporsem = Rapord3::where('id_semesterkuliah', $i_s)->get();
            }
            else{
                $raporsem = \App\Models\RaporSem7::all();
            }
            $spa =  \App\Models\SemesterperiodeAngkatan::where('id_angkatan', $angkatan->id)->first()->semester_7;
            $tugas_sem = \App\Models\TugasPesertaSem7::all();
            $tugas = $tugas_sem->where('id_peserta', $i_p)->first();

            showRapor($i_s, $i_p, $tugas_sem);
        }
        if($i_s == 8){
            if($skema_check == 3){
                $raporsem = Rapord3::where('id_semesterkuliah', $i_s)->get();
            }
            else{
                $raporsem = \App\Models\RaporSem8::all();
            }
            $spa =  \App\Models\SemesterperiodeAngkatan::where('id_angkatan', $angkatan->id)->first()->semester_8;
            $tugas_sem = \App\Models\TugasPesertaSem8::all();
            $tugas = $tugas_sem->where('id_peserta', $i_p)->first();

            showRapor($i_s, $i_p, $tugas_sem);
        }

        $apr = \App\Models\AsistenpenilaiRaporPeserta::where('id_rapor_peserta', $i_r)->first();
        $cr = \App\Models\CatatanRaporPeserta::where('id_rapor_peserta', $i_r)->first();
        $tpr = \App\Models\TanggalperiksaRaporPeserta::where('id_rapor_peserta', $i_r)->first();
        $counter_selesai = \App\Models\RaporKelulusan::where('id_peserta', $i_p)->where('id_semesterkuliah', $i_s)->first()->kelengkapan_tugas;
        $counter_hadir = \App\Models\RaporKelulusan::where('id_peserta', $i_p)->where('id_semesterkuliah', $i_s)->first()->kehadiran;
        $status_kelulusan = \App\Models\RaporKelulusan::where('id_peserta', $i_p)->where('id_semesterkuliah', $i_s)->first()->status_kelulusan;

        return view('rapor.v_rapor-peserta', compact( 'peserta', 'angkatan', 't_a', 'angkatan_aktif', 'checker', 'semester_all', 'i_s', 'i_r', 'asisten', 
        'rapor', 'raporsem', 'spa', 'apr', 'cr', 'tpr', 'kehadiran', 'tugas', 'skema', 'skemacurrent_id', 'skemafirst_id', 'counter_selesai', 'status_kelulusan', 'counter_hadir')); 
    }

    public function edit(Request $request, Angkatan $angkatan, Skema $skema, Semesterkuliah $semester, RaporPeserta $rapor_peserta)
    {
        $i_s = $semester->id;
        $i_r = $rapor_peserta->id;
        $i_p = $rapor_peserta->peserta->id;
        
        // edit_kehadiran
        $cek = Kelulusanpeserta::where('id_peserta', $i_p)->first();
        if(!$cek){
            $table = new Kelulusanpeserta;
            $table->id_peserta = $i_p;
            $query = $table->save();
        }
        $peserta = Peserta::where('id', $i_p)->first();
        $query = $peserta->semesterkehadiran()->syncWithoutDetaching([$i_s =>
        [
        'pertemuan_1' => $request->k1,
        'pertemuan_2' => $request->k2,
        'pertemuan_3' => $request->k3,
        'pertemuan_4' => $request->k4,
        'pertemuan_5' => $request->k5,
        'pertemuan_6' => $request->k6,
        'pertemuan_7' => $request->k7,
        'pertemuan_8' => $request->k8,
        'pertemuan_9' => $request->k9,
        'pertemuan_10' => $request->k10
        ]]);
        if ($query){
            $pluck1 = \App\Models\KehadiranPeserta::where('id_peserta', $i_p)->pluck('pertemuan_1');
            $pluck2 = \App\Models\KehadiranPeserta::where('id_peserta', $i_p)->pluck('pertemuan_2');
            $pluck3 = \App\Models\KehadiranPeserta::where('id_peserta', $i_p)->pluck('pertemuan_3');
            $pluck4 = \App\Models\KehadiranPeserta::where('id_peserta', $i_p)->pluck('pertemuan_4');
            $pluck5 = \App\Models\KehadiranPeserta::where('id_peserta', $i_p)->pluck('pertemuan_5');
            $pluck6 = \App\Models\KehadiranPeserta::where('id_peserta', $i_p)->pluck('pertemuan_6');
            $pluck7 = \App\Models\KehadiranPeserta::where('id_peserta', $i_p)->pluck('pertemuan_7');
            $pluck8 = \App\Models\KehadiranPeserta::where('id_peserta', $i_p)->pluck('pertemuan_8');
            $pluck9 = \App\Models\KehadiranPeserta::where('id_peserta', $i_p)->pluck('pertemuan_9');
            $pluck10 = \App\Models\KehadiranPeserta::where('id_peserta', $i_p)->pluck('pertemuan_10');
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
            $kelengkapan_tugas = \App\Models\Kelulusanpeserta::where('id_peserta', $i_p)->first()->kelengkapan_tugas;
            if($kelengkapan_tugas >= 56 && $counter_kehadiran > 50){
                $status = 'Lulus';
            }
            else{
                $status = 'Tidak Lulus';
            }
            $zz = Kelulusanpeserta::where('id_peserta', $i_p)->first();
            if(!$zz){
                $table2 = new Kelulusanpeserta;
                $table2->id_peserta = $i_p;
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
        }

        // edit_tugas
        $i_s = $semester->id;
        $tugas_p = \App\Models\TugasPeserta::all();

        $cek = Kelulusanpeserta::where('id_peserta', $i_p)->first();
        if(!$cek){
            $table = new Kelulusanpeserta;
            $table->id_peserta = $i_p;
            $query = $table->save();
        }

        if($i_s == 1){
            $tugas = \App\Models\TugasPesertaSem1::where('id_peserta', $i_p)->first();
            $tugas->tugas_1 = $request->t1;
            $tugas->tugas_2 = $request->t2;
            $tugas->tugas_3 = $request->t3;
            $tugas->tugas_4 = $request->t4;
            $tugas->tugas_5 = $request->t5;
            $tugas->tugas_6 = $request->t6;
            $tugas->tugas_7 = $request->t7;
            $tugas->tugas_8 = $request->t8;
            $tugas->tugas_9 = $request->t9;
            $tugas->tugas_10 = $request->t10;

            for($i=1; $i<11; $i++){
                if($request->{"tugas_".$i} == "Selesai"){
                    if(!$tugas_p->where('id_tugas', $i)->where('id_peserta', $i_p)->first()){
                        $table = new TugasPeserta;
                        $table->id_tugas = $i;
                        $table->id_peserta = $i_p;
                        $table->save();
                    }
                }
                if($request->{"tugas_".$i} == "Belum Selesai" || $request->{"tugas_".$i} == null){
                    \App\Models\TugasPeserta::where('id_tugas', $i)->where('id_peserta', $i_p)->delete();
                }
            }
        }
        if($i_s == 2){
            $tugas = \App\Models\TugasPesertaSem2::where('id_peserta', $i_p)->first();
            $tugas->tugas_1 = $request->t1;
            $tugas->tugas_2 = $request->t2;
            $tugas->tugas_3 = $request->t3;
            $tugas->tugas_4 = $request->t4;
            $tugas->tugas_5 = $request->t5;
            $tugas->tugas_6 = $request->t6;
            $tugas->tugas_7 = $request->t7;
            $tugas->tugas_8 = $request->t8;
            $tugas->tugas_9 = $request->t9;
            $tugas->tugas_10 = $request->t10;

            for($i=1; $i<11; $i++){
                if($request->{"tugas_".$i} == "Selesai"){
                    if(!$tugas_p->where('id_tugas', $i+10)->where('id_peserta', $i_p)->first()){
                        $table = new TugasPeserta;
                        $table->id_tugas = $i+10;
                        $table->id_peserta = $i_p;
                        $table->save();
                    }
                }
                if($request->{"tugas_".$i} == "Belum Selesai" || $request->{"tugas_".$i} == null){
                    \App\Models\TugasPeserta::where('id_tugas', $i+10)->where('id_peserta', $i_p)->delete();
                }
            }
        }
        if($i_s == 3){
            $tugas = \App\Models\TugasPesertaSem3::where('id_peserta', $i_p)->first();
            $tugas->tugas_1 = $request->t1;
            $tugas->tugas_2 = $request->t2;
            $tugas->tugas_3 = $request->t3;
            $tugas->tugas_4 = $request->t4;
            $tugas->tugas_5 = $request->t5;
            $tugas->tugas_6 = $request->t6;
            $tugas->tugas_7 = $request->t7;
            $tugas->tugas_8 = $request->t8;
            $tugas->tugas_9 = $request->t9;
            $tugas->tugas_10 = $request->t10;

            for($i=1; $i<11; $i++){
                if($request->{"tugas_".$i} == "Selesai"){
                    if(!$tugas_p->where('id_tugas', $i+20)->where('id_peserta', $i_p)->first()){
                        $table = new TugasPeserta;
                        $table->id_tugas = $i+20;
                        $table->id_peserta = $i_p;
                        $table->save();
                    }
                }
                if($request->{"tugas_".$i} == "Belum Selesai" || $request->{"tugas_".$i} == null){
                    \App\Models\TugasPeserta::where('id_tugas', $i+20)->where('id_peserta', $i_p)->delete();
                }
            }
        }
        if($i_s == 4){
            $tugas = \App\Models\TugasPesertaSem4::where('id_peserta', $i_p)->first();
            $tugas->tugas_1 = $request->t1;
            $tugas->tugas_2 = $request->t2;
            $tugas->tugas_3 = $request->t3;
            $tugas->tugas_4 = $request->t4;
            $tugas->tugas_5 = $request->t5;
            $tugas->tugas_6 = $request->t6;
            $tugas->tugas_7 = $request->t7;
            $tugas->tugas_8 = $request->t8;
            $tugas->tugas_9 = $request->t9;
            $tugas->tugas_10 = $request->t10;

            for($i=1; $i<11; $i++){
                if($request->{"tugas_".$i} == "Selesai"){
                    if(!$tugas_p->where('id_tugas', $i+30)->where('id_peserta', $i_p)->first()){
                        $table = new TugasPeserta;
                        $table->id_tugas = $i+30;
                        $table->id_peserta = $i_p;
                        $table->save();
                    }
                }
                if($request->{"tugas_".$i} == "Belum Selesai" || $request->{"tugas_".$i} == null){
                    \App\Models\TugasPeserta::where('id_tugas', $i+30)->where('id_peserta', $i_p)->delete();
                }
            }
        }
        if($i_s == 5){
            $tugas = \App\Models\TugasPesertaSem5::where('id_peserta', $i_p)->first();
            $tugas->tugas_1 = $request->t1;
            $tugas->tugas_2 = $request->t2;
            $tugas->tugas_3 = $request->t3;
            $tugas->tugas_4 = $request->t4;
            $tugas->tugas_5 = $request->t5;
            $tugas->tugas_6 = $request->t6;
            $tugas->tugas_7 = $request->t7;
            $tugas->tugas_8 = $request->t8;
            $tugas->tugas_9 = $request->t9;
            $tugas->tugas_10 = $request->t10;

            for($i=1; $i<11; $i++){
                if($request->{"tugas_".$i} == "Selesai"){
                    if(!$tugas_p->where('id_tugas', $i+40)->where('id_peserta', $i_p)->first()){
                        $table = new TugasPeserta;
                        $table->id_tugas = $i+40;
                        $table->id_peserta = $i_p;
                        $table->save();
                    }
                }
                if($request->{"tugas_".$i} == "Belum Selesai" || $request->{"tugas_".$i} == null){
                    \App\Models\TugasPeserta::where('id_tugas', $i+40)->where('id_peserta', $i_p)->delete();
                }
            }
        }
        if($i_s == 6){
            $tugas = \App\Models\TugasPesertaSem6::where('id_peserta', $i_p)->first();
            $tugas->tugas_1 = $request->t1;
            $tugas->tugas_2 = $request->t2;
            $tugas->tugas_3 = $request->t3;
            $tugas->tugas_4 = $request->t4;
            $tugas->tugas_5 = $request->t5;
            $tugas->tugas_6 = $request->t6;
            $tugas->tugas_7 = $request->t7;
            $tugas->tugas_8 = $request->t8;
            $tugas->tugas_9 = $request->t9;
            $tugas->tugas_10 = $request->t10;

            for($i=1; $i<11; $i++){
                if($request->{"tugas_".$i} == "Selesai"){
                    if(!$tugas_p->where('id_tugas', $i+50)->where('id_peserta', $i_p)->first()){
                        $table = new TugasPeserta;
                        $table->id_tugas = $i+50;
                        $table->id_peserta = $i_p;
                        $table->save();
                    }
                }
                if($request->{"tugas_".$i} == "Belum Selesai" || $request->{"tugas_".$i} == null){
                    \App\Models\TugasPeserta::where('id_tugas', $i+50)->where('id_peserta', $i_p)->delete();
                }
            }
        }
        if($i_s == 7){
            $tugas = \App\Models\TugasPesertaSem7::where('id_peserta', $i_p)->first();
            $tugas->tugas_1 = $request->t1;
            $tugas->tugas_2 = $request->t2;
            $tugas->tugas_3 = $request->t3;
            $tugas->tugas_4 = $request->t4;
            $tugas->tugas_5 = $request->t5;
            $tugas->tugas_6 = $request->t6;
            $tugas->tugas_7 = $request->t7;
            $tugas->tugas_8 = $request->t8;
            $tugas->tugas_9 = $request->t9;
            $tugas->tugas_10 = $request->t10;

            for($i=1; $i<11; $i++){
                if($request->{"tugas_".$i} == "Selesai"){
                    if(!$tugas_p->where('id_tugas', $i+60)->where('id_peserta', $i_p)->first()){
                        $table = new TugasPeserta;
                        $table->id_tugas = $i+60;
                        $table->id_peserta = $i_p;
                        $table->save();
                    }
                }
                if($request->{"tugas_".$i} == "Belum Selesai" || $request->{"tugas_".$i} == null){
                    \App\Models\TugasPeserta::where('id_tugas', $i+60)->where('id_peserta', $i_p)->delete();
                }
            }
        }
        if($i_s == 8){
            $tugas = \App\Models\TugasPesertaSem8::where('id_peserta', $i_p)->first();
            $tugas->tugas_1 = $request->t1;
            $tugas->tugas_2 = $request->t2;
            $tugas->tugas_3 = $request->t3;
            $tugas->tugas_4 = $request->t4;
            $tugas->tugas_5 = $request->t5;
            $tugas->tugas_6 = $request->t6;
            $tugas->tugas_7 = $request->t7;
            $tugas->tugas_8 = $request->t8;
            $tugas->tugas_9 = $request->t9;
            $tugas->tugas_10 = $request->t10;

            for($i=1; $i<11; $i++){
                if($request->{"tugas_".$i} == "Selesai"){
                    if(!$tugas_p->where('id_tugas', $i+70)->where('id_peserta', $i_p)->first()){
                        $table = new TugasPeserta;
                        $table->id_tugas = $i+70;
                        $table->id_peserta = $i_p;
                        $table->save();
                    }
                }
                if($request->{"tugas_".$i} == "Belum Selesai" || $request->{"tugas_".$i} == null){
                    \App\Models\TugasPeserta::where('id_tugas', $i+70)->where('id_peserta', $i_p)->delete();
                }
            }
        }
        $tugas->save();

        // edit_asistp
        $apr = \App\Models\AsistenpenilaiRaporPeserta::where('id_rapor_peserta', $i_r)->first();
        $apr->pertemuan_1 = $request->asistp1;
        $apr->pertemuan_2 = $request->asistp2;
        $apr->pertemuan_3 = $request->asistp3;
        $apr->pertemuan_4 = $request->asistp4;
        $apr->pertemuan_5 = $request->asistp5;
        $apr->pertemuan_6 = $request->asistp6;
        $apr->pertemuan_7 = $request->asistp7;
        $apr->pertemuan_8 = $request->asistp8;
        $apr->pertemuan_9 = $request->asistp9;
        $apr->pertemuan_10 = $request->asistp10;
        $apr->save();
        
        // edit_catatan
        $cr = \App\Models\CatatanRaporPeserta::where('id_rapor_peserta', $i_r)->first();
        $cr->pertemuan_1 = $request->catatan1;
        $cr->pertemuan_2 = $request->catatan2;
        $cr->pertemuan_3 = $request->catatan3;
        $cr->pertemuan_4 = $request->catatan4;
        $cr->pertemuan_5 = $request->catatan5;
        $cr->pertemuan_6 = $request->catatan6;
        $cr->pertemuan_7 = $request->catatan7;
        $cr->pertemuan_8 = $request->catatan8;
        $cr->pertemuan_9 = $request->catatan9;
        $cr->pertemuan_10 = $request->catatan10;
        $cr->save();

        // edit_tanggal
        $tpr = \App\Models\TanggalperiksaRaporPeserta::where('id_rapor_peserta', $i_r)->first();
        $tpr->pertemuan_1 = $request->tanggal1;
        $tpr->pertemuan_2 = $request->tanggal2;
        $tpr->pertemuan_3 = $request->tanggal3;
        $tpr->pertemuan_4 = $request->tanggal4;
        $tpr->pertemuan_5 = $request->tanggal5;
        $tpr->pertemuan_6 = $request->tanggal6;
        $tpr->pertemuan_7 = $request->tanggal7;
        $tpr->pertemuan_8 = $request->tanggal8;
        $tpr->pertemuan_9 = $request->tanggal9;
        $tpr->pertemuan_10 = $request->tanggal10;
        $tpr->save();


        return back()->with('pesan', 'Rapor peserta berhasil diedit');
    }

    public function print(Angkatan $angkatan, Skema $skema, Semesterkuliah $semester, RaporPeserta $rapor_peserta)
    {
        $peserta = \App\Models\Peserta::where('id_angkatan', $angkatan->id)->get()->sortBy('nama_peserta');
        $semester_all = \App\Models\Semesterkuliah::ALL();
        $i_p = $rapor_peserta->peserta->id;
        $i_r = $rapor_peserta->id;
        $i_s = $semester->id;
        $t_a = $angkatan->tahun_angkatan;
        $nama_peserta = $rapor_peserta->peserta->nama_peserta;
        $angkatan_aktif = \App\Models\Angkatan::where('status_angkatan', 'Aktif')->get()->sortBy('tahun_angkatan');
        $checker = $angkatan_aktif->contains('tahun_angkatan', $t_a);
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
        $tugas_p = \App\Models\TugasPeserta::all();
        $tugas_sem1 = \App\Models\TugasPesertaSem1::all();
        $tugas_sem2 = \App\Models\TugasPesertaSem2::all();
        $tugas_sem3 = \App\Models\TugasPesertaSem3::all();
        $tugas_sem4 = \App\Models\TugasPesertaSem4::all();
        $tugas_sem5 = \App\Models\TugasPesertaSem5::all();
        $tugas_sem6 = \App\Models\TugasPesertaSem6::all();
        $tugas_sem7 = \App\Models\TugasPesertaSem7::all();
        $tugas_sem8 = \App\Models\TugasPesertaSem8::all();
        $asisten = User::whereIn('id_role', [1,2])->orderBy('nama_user')->get();
        $rapor = \App\Models\RaporPeserta::where('id', $i_r)->first();
        if($i_s == 1){
            $raporsem = \App\Models\RaporSem1::all();
            $spa =  \App\Models\SemesterperiodeAngkatan::where('id_angkatan', $angkatan->id)->first()->semester_1;
            $tugas = $tugas_sem1->where('id_peserta', $i_p)->first();

            $pluck1 = $tugas_sem1->where('id_peserta', $i_p)->pluck('tugas_1');
            $pluck2 = $tugas_sem1->where('id_peserta', $i_p)->pluck('tugas_2');
            $pluck3 = $tugas_sem1->where('id_peserta', $i_p)->pluck('tugas_3');
            $pluck4 = $tugas_sem1->where('id_peserta', $i_p)->pluck('tugas_4');
            $pluck5 = $tugas_sem1->where('id_peserta', $i_p)->pluck('tugas_5');
            $pluck6 = $tugas_sem1->where('id_peserta', $i_p)->pluck('tugas_6');
            $pluck7 = $tugas_sem1->where('id_peserta', $i_p)->pluck('tugas_7');
            $pluck8 = $tugas_sem1->where('id_peserta', $i_p)->pluck('tugas_8');
            $pluck9 = $tugas_sem1->where('id_peserta', $i_p)->pluck('tugas_9');
            $pluck10 = $tugas_sem1->where('id_peserta', $i_p)->pluck('tugas_10');
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
        }
        if($i_s == 2){
            $raporsem = \App\Models\RaporSem2::all();
            $spa =  \App\Models\SemesterperiodeAngkatan::where('id_angkatan', $angkatan->id)->first()->semester_2;
            $tugas = $tugas_sem2->where('id_peserta', $i_p)->first();

            $pluck1 = $tugas_sem2->where('id_peserta', $i_p)->pluck('tugas_1');
            $pluck2 = $tugas_sem2->where('id_peserta', $i_p)->pluck('tugas_2');
            $pluck3 = $tugas_sem2->where('id_peserta', $i_p)->pluck('tugas_3');
            $pluck4 = $tugas_sem2->where('id_peserta', $i_p)->pluck('tugas_4');
            $pluck5 = $tugas_sem2->where('id_peserta', $i_p)->pluck('tugas_5');
            $pluck6 = $tugas_sem2->where('id_peserta', $i_p)->pluck('tugas_6');
            $pluck7 = $tugas_sem2->where('id_peserta', $i_p)->pluck('tugas_7');
            $pluck8 = $tugas_sem2->where('id_peserta', $i_p)->pluck('tugas_8');
            $pluck9 = $tugas_sem2->where('id_peserta', $i_p)->pluck('tugas_9');
            $pluck10 = $tugas_sem2->where('id_peserta', $i_p)->pluck('tugas_10');
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
        }
        if($i_s == 3){
            $raporsem = \App\Models\RaporSem3::all();
            $spa =  \App\Models\SemesterperiodeAngkatan::where('id_angkatan', $angkatan->id)->first()->semester_3;
            $tugas = $tugas_sem3->where('id_peserta', $i_p)->first();

            $pluck1 = $tugas_sem3->where('id_peserta', $i_p)->pluck('tugas_1');
            $pluck2 = $tugas_sem3->where('id_peserta', $i_p)->pluck('tugas_2');
            $pluck3 = $tugas_sem3->where('id_peserta', $i_p)->pluck('tugas_3');
            $pluck4 = $tugas_sem3->where('id_peserta', $i_p)->pluck('tugas_4');
            $pluck5 = $tugas_sem3->where('id_peserta', $i_p)->pluck('tugas_5');
            $pluck6 = $tugas_sem3->where('id_peserta', $i_p)->pluck('tugas_6');
            $pluck7 = $tugas_sem3->where('id_peserta', $i_p)->pluck('tugas_7');
            $pluck8 = $tugas_sem3->where('id_peserta', $i_p)->pluck('tugas_8');
            $pluck9 = $tugas_sem3->where('id_peserta', $i_p)->pluck('tugas_9');
            $pluck10 = $tugas_sem3->where('id_peserta', $i_p)->pluck('tugas_10');
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
        }
        if($i_s == 4){
            $raporsem = \App\Models\RaporSem4::all();
            $spa =  \App\Models\SemesterperiodeAngkatan::where('id_angkatan', $angkatan->id)->first()->semester_4;
            $tugas = $tugas_sem4->where('id_peserta', $i_p)->first();

            $pluck1 = $tugas_sem4->where('id_peserta', $i_p)->pluck('tugas_1');
            $pluck2 = $tugas_sem4->where('id_peserta', $i_p)->pluck('tugas_2');
            $pluck3 = $tugas_sem4->where('id_peserta', $i_p)->pluck('tugas_3');
            $pluck4 = $tugas_sem4->where('id_peserta', $i_p)->pluck('tugas_4');
            $pluck5 = $tugas_sem4->where('id_peserta', $i_p)->pluck('tugas_5');
            $pluck6 = $tugas_sem4->where('id_peserta', $i_p)->pluck('tugas_6');
            $pluck7 = $tugas_sem4->where('id_peserta', $i_p)->pluck('tugas_7');
            $pluck8 = $tugas_sem4->where('id_peserta', $i_p)->pluck('tugas_8');
            $pluck9 = $tugas_sem4->where('id_peserta', $i_p)->pluck('tugas_9');
            $pluck10 = $tugas_sem4->where('id_peserta', $i_p)->pluck('tugas_10');
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
        }
        if($i_s == 5){
            $raporsem = \App\Models\RaporSem5::all();
            $spa =  \App\Models\SemesterperiodeAngkatan::where('id_angkatan', $angkatan->id)->first()->semester_5;
            $tugas = $tugas_sem5->where('id_peserta', $i_p)->first();

            $pluck1 = $tugas_sem5->where('id_peserta', $i_p)->pluck('tugas_1');
            $pluck2 = $tugas_sem5->where('id_peserta', $i_p)->pluck('tugas_2');
            $pluck3 = $tugas_sem5->where('id_peserta', $i_p)->pluck('tugas_3');
            $pluck4 = $tugas_sem5->where('id_peserta', $i_p)->pluck('tugas_4');
            $pluck5 = $tugas_sem5->where('id_peserta', $i_p)->pluck('tugas_5');
            $pluck6 = $tugas_sem5->where('id_peserta', $i_p)->pluck('tugas_6');
            $pluck7 = $tugas_sem5->where('id_peserta', $i_p)->pluck('tugas_7');
            $pluck8 = $tugas_sem5->where('id_peserta', $i_p)->pluck('tugas_8');
            $pluck9 = $tugas_sem5->where('id_peserta', $i_p)->pluck('tugas_9');
            $pluck10 = $tugas_sem5->where('id_peserta', $i_p)->pluck('tugas_10');
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
        }
        if($i_s == 6){
            $raporsem = \App\Models\RaporSem6::all();
            $spa =  \App\Models\SemesterperiodeAngkatan::where('id_angkatan', $angkatan->id)->first()->semester_6;
            $tugas = $tugas_sem6->where('id_peserta', $i_p)->first();

            $pluck1 = $tugas_sem6->where('id_peserta', $i_p)->pluck('tugas_1');
            $pluck2 = $tugas_sem6->where('id_peserta', $i_p)->pluck('tugas_2');
            $pluck3 = $tugas_sem6->where('id_peserta', $i_p)->pluck('tugas_3');
            $pluck4 = $tugas_sem6->where('id_peserta', $i_p)->pluck('tugas_4');
            $pluck5 = $tugas_sem6->where('id_peserta', $i_p)->pluck('tugas_5');
            $pluck6 = $tugas_sem6->where('id_peserta', $i_p)->pluck('tugas_6');
            $pluck7 = $tugas_sem6->where('id_peserta', $i_p)->pluck('tugas_7');
            $pluck8 = $tugas_sem6->where('id_peserta', $i_p)->pluck('tugas_8');
            $pluck9 = $tugas_sem6->where('id_peserta', $i_p)->pluck('tugas_9');
            $pluck10 = $tugas_sem6->where('id_peserta', $i_p)->pluck('tugas_10');
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
        }
        if($i_s == 7){
            $raporsem = \App\Models\RaporSem7::all();
            $spa =  \App\Models\SemesterperiodeAngkatan::where('id_angkatan', $angkatan->id)->first()->semester_7;
            $tugas = $tugas_sem7->where('id_peserta', $i_p)->first();

            $pluck1 = $tugas_sem7->where('id_peserta', $i_p)->pluck('tugas_1');
            $pluck2 = $tugas_sem7->where('id_peserta', $i_p)->pluck('tugas_2');
            $pluck3 = $tugas_sem7->where('id_peserta', $i_p)->pluck('tugas_3');
            $pluck4 = $tugas_sem7->where('id_peserta', $i_p)->pluck('tugas_4');
            $pluck5 = $tugas_sem7->where('id_peserta', $i_p)->pluck('tugas_5');
            $pluck6 = $tugas_sem7->where('id_peserta', $i_p)->pluck('tugas_6');
            $pluck7 = $tugas_sem7->where('id_peserta', $i_p)->pluck('tugas_7');
            $pluck8 = $tugas_sem7->where('id_peserta', $i_p)->pluck('tugas_8');
            $pluck9 = $tugas_sem7->where('id_peserta', $i_p)->pluck('tugas_9');
            $pluck10 = $tugas_sem7->where('id_peserta', $i_p)->pluck('tugas_10');
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
        }
        if($i_s == 8){
            $raporsem = \App\Models\RaporSem8::all();
            $spa =  \App\Models\SemesterperiodeAngkatan::where('id_angkatan', $angkatan->id)->first()->semester_8;
            $tugas = $tugas_sem8->where('id_peserta', $i_p)->first();

            $pluck1 = $tugas_sem8->where('id_peserta', $i_p)->pluck('tugas_1');
            $pluck2 = $tugas_sem8->where('id_peserta', $i_p)->pluck('tugas_2');
            $pluck3 = $tugas_sem8->where('id_peserta', $i_p)->pluck('tugas_3');
            $pluck4 = $tugas_sem8->where('id_peserta', $i_p)->pluck('tugas_4');
            $pluck5 = $tugas_sem8->where('id_peserta', $i_p)->pluck('tugas_5');
            $pluck6 = $tugas_sem8->where('id_peserta', $i_p)->pluck('tugas_6');
            $pluck7 = $tugas_sem8->where('id_peserta', $i_p)->pluck('tugas_7');
            $pluck8 = $tugas_sem8->where('id_peserta', $i_p)->pluck('tugas_8');
            $pluck9 = $tugas_sem8->where('id_peserta', $i_p)->pluck('tugas_9');
            $pluck10 = $tugas_sem8->where('id_peserta', $i_p)->pluck('tugas_10');
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
        }

        $apr = \App\Models\AsistenpenilaiRaporPeserta::where('id_rapor_peserta', $i_r)->first();
        $cr = \App\Models\CatatanRaporPeserta::where('id_rapor_peserta', $i_r)->first();
        $tpr = \App\Models\TanggalperiksaRaporPeserta::where('id_rapor_peserta', $i_r)->first();
        $kehadiran = \App\Models\KehadiranPeserta::where('id_semesterkuliah', $i_s)->where('id_peserta', $rapor_peserta->peserta->id)->first();
        $counter_selesai = \App\Models\RaporKelulusan::where('id_peserta', $i_p)->where('id_semesterkuliah', $i_s)->first()->kelengkapan_tugas;
        $counter_hadir = \App\Models\RaporKelulusan::where('id_peserta', $i_p)->where('id_semesterkuliah', $i_s)->first()->kehadiran;
        $status_kelulusan = \App\Models\RaporKelulusan::where('id_peserta', $i_p)->where('id_semesterkuliah', $i_s)->first()->status_kelulusan;

        return view('rapor.v_rapor-print', compact( 'peserta', 't_a', 'angkatan_aktif', 'checker', 'semester_all', 'i_s', 'i_r', 'asisten', 'rapor', 'raporsem', 
        'spa', 'apr', 'cr', 'tpr', 'kehadiran', 'tugas', 'nama_peserta', 'status_kelulusan', 'counter_selesai', 'counter_hadir' )); 
    }
}
