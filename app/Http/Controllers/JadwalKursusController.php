<?php

namespace App\Http\Controllers;

use App\Models\Angkatan;
use App\Models\Jadwalkursus;
use App\Models\Kelulusanpeserta;
use App\Models\Peserta;
use App\Models\Semesterkuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Validator as FacadesValidator;

use PDF;

class JadwalkursusController extends Controller
{
    public function index()
    {
        $angkatan_aktif = \App\Models\Angkatan::where('status_angkatan', 'Aktif')->get()->sortBy('tahun_angkatan');
        return view('jadwal_kursus.v_jadwal-angkatan-menu', compact('angkatan_aktif'));
    }

    public function semester_menu(Angkatan $angkatan)
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
        return view('jadwal_kursus.v_jadwal-semester-menu', compact( 'peserta', 'jurusan', 't_a', 'angkatan_aktif', 'checker', 'semester', 'angkatan'));
    }

    public function jadwal_menu(Angkatan $angkatan, Semesterkuliah $semester)
    {
        $t_a = $angkatan->tahun_angkatan;
        $i_s = $semester->id;
        $a = \App\Models\Angkatan::where('id', $angkatan->id)->first();
        $a->semesterkuliah()->sync([1,2,3,4,5,6,7,8]);
        $catatan = \App\Models\Catatanjadwal::where('id_angkatan', $angkatan->id)->where('id_semesterkuliah', $i_s)->first()->catatan;
        $angkatan_aktif = \App\Models\Angkatan::where('status_angkatan', 'Aktif')->get()->sortBy('tahun_angkatan');
        $checker = $angkatan_aktif->contains('tahun_angkatan', $t_a);
        $semester = \App\Models\Semesterkuliah::ALL();
        $peserta = \App\Models\Peserta::where('id_angkatan', $angkatan->id)->get()->sortBy('nama_peserta');
        $pesertadijadwal = \App\Models\PesertaJadwalkursus::all();
        $jadwal_semester = \App\Models\Jadwalkursus::where('id_semesterkuliah', $i_s)->where('id_angkatan', $angkatan->id)->get('id')->toArray();
        $jadwal_kursus = \App\Models\Jadwalkursus::where('id_semesterkuliah', $i_s)->where('id_angkatan', $angkatan->id)->get();
        $peserta_id = $peserta->map(function ($user) {
            return collect($user->toArray())
                ->only(['id'])
                ->all();
        });
        $pesertasudahadajadwal = \App\Models\PesertaJadwalkursus::whereIn('id_jadwalkursus', $jadwal_semester)->whereIn('id_peserta', $peserta_id)->get();
        $pesertasudahadajadwal_id = $pesertasudahadajadwal->map(function ($user) {
            return collect($user->toArray())
                ->only(['id_peserta'])
                ->all();
        });
        $pesertabelumadajadwal = \App\Models\Peserta::where('id_angkatan', $angkatan->id)->whereNotIn('id', $pesertasudahadajadwal_id)->orderBy('nama_peserta')->get();

        return view('jadwal_kursus.v_jadwal-menu', compact( 'catatan', 'peserta', 'pesertadijadwal', 'pesertabelumadajadwal', 't_a', 'i_s', 'angkatan_aktif', 'checker', 'semester', 'jadwal_kursus', 'angkatan'));
    }

    public function edit_catatan(Request $request, Angkatan $angkatan, Semesterkuliah $semester)
    {
        $i_a = $angkatan->id;
        $i_s = $semester->id;
        $catatan = \App\Models\Catatanjadwal::where('id_angkatan', $i_a)->where('id_semesterkuliah', $i_s)->first();
        $catatan->catatan = $request->catatan;
        $query = $catatan->save();
        if ($query){
            return back()->with('pesan', 'Catatan berhasil diedit');
        }    
    }

    public function tambah_jadwal(Request $request, Angkatan $angkatan, Semesterkuliah $semester)
    {
        $validator = Validator::make($request->all(),[
            'jam' => 'required|min:5',
            'link' => 'required|min:10',
        ]);

        if($validator->fails()){
            return response()->json(['status'=>0, 'error'=>$validator->errors()->toArray()]);
        }else{
            $jadwal = new Jadwalkursus;
            $jadwal->hari = $request->hari;
            $jadwal->jam = $request->jam;
            $jadwal->link = $request->link;
            $jadwal->id_angkatan = $angkatan->id;
            $jadwal->id_semesterkuliah = $semester->id;
            
            $query = $jadwal->save();
            if ($query){
                return response()->json(['status'=>1, 'msg'=>'Jadwal berhasil ditambah']);
            }
        }    
    }

    public function edit_jadwal(Request $request, Angkatan $angkatan, Semesterkuliah $semester, Jadwalkursus $jadwal_kursus)
    {
        $validator = Validator::make($request->all(),[
            'jam' => 'required|min:5',
            'link' => 'required|min:10',
        ]);

        if($validator->fails()){
            return response()->json(['status'=>0, 'error'=>$validator->errors()->toArray()]);
        }else{
            $jadwal = Jadwalkursus::find($jadwal_kursus->id);
            $jadwal->hari = $request->hari;
            $jadwal->jam = $request->jam;
            $jadwal->link = $request->link;
            $jadwal->id_angkatan = $angkatan->id;
            $jadwal->id_semesterkuliah = $semester->id;
            
            $query = $jadwal->save();
            if ($query){
                return response()->json(['status'=>1, 'msg'=>'Jadwal berhasil diedit']);
            }
        }    
    }

    public function hapus_jadwal(Request $request, Angkatan $angkatan, Semesterkuliah $semester, Jadwalkursus $jadwal_kursus)
    {
        $i_j = $jadwal_kursus->id;
        DB::table('jadwalkursus')->where('id', $i_j)->delete();

        return back()->with('pesan', 'Jadwal berhasil dihapus');
    }

    public function jadwal_detail(Angkatan $angkatan, Semesterkuliah $semester, Jadwalkursus $jadwal_kursus)
    {
        $t_a = $angkatan->tahun_angkatan;
        $i_s = $semester->id;
        $i_j = $jadwal_kursus->id;
        $angkatan_aktif = \App\Models\Angkatan::where('status_angkatan', 'Aktif')->get()->sortBy('tahun_angkatan');
        $checker = $angkatan_aktif->contains('tahun_angkatan', $t_a);
        $semester_all = \App\Models\Semesterkuliah::ALL();
        $jadwal_semester = \App\Models\Jadwalkursus::where('id_semesterkuliah', $i_s)->where('id_angkatan', $angkatan->id)->get('id')->toArray();
        $jadwal = \App\Models\Jadwalkursus::where('id_semesterkuliah', $i_s)->where('id', $i_j)->first();
        $peserta = \App\Models\Peserta::where('id_angkatan', $angkatan->id)->orderBy('nama_peserta')->get();
        $peserta_id = $peserta->map(function ($user) {
            return collect($user->toArray())
                ->only(['id'])
                ->all();
        });
        $pesertadijadwal = \App\Models\PesertaJadwalkursus::where('id_jadwalkursus', $i_j)
        ->orderBy(function ($query){
            $query->select('nama_peserta')
            ->from('peserta')
            ->whereColumn('id', 'id_peserta');
        })->get();
        $pesertadijadwal_id = $pesertadijadwal->map(function ($user) {
            return collect($user->toArray())
                ->only(['id_peserta'])
                ->all();
        });
        $pesertasudahadajadwal = \App\Models\PesertaJadwalkursus::whereIn('id_jadwalkursus', $jadwal_semester)->whereIn('id_peserta', $peserta_id)->get();
        $pesertasudahadajadwal_id = $pesertasudahadajadwal->map(function ($user) {
            return collect($user->toArray())
            ->only(['id_peserta'])
            ->all();
        });
        $pesertabelumadajadwal = \App\Models\Peserta::where('id_angkatan', $angkatan->id)->whereNotIn('id', $pesertasudahadajadwal_id)->orderBy('nama_peserta')->get();
        
        $kehadiran = \App\Models\KehadiranPeserta::where('id_semesterkuliah', $i_s)->whereIn('id_peserta', $pesertadijadwal_id)
        ->orderBy(function ($query){
            $query->select('nama_peserta')
            ->from('peserta')
            ->whereColumn('id', 'id_peserta');
        })->get();

        if (array_search($i_j, array_column($jadwal_semester, 'id')) !== false) { 
            return view('jadwal_kursus.v_jadwal-detail', compact( 'peserta', 'pesertadijadwal', 'pesertabelumadajadwal', 't_a', 'i_j', 'i_s', 'angkatan_aktif', 'checker', 'semester_all', 'jadwal', 'angkatan', 'semester', 'angkatan', 'kehadiran'));
        }
        else {
            return abort(404);
        }
    }

    public function semua_jadwal(Angkatan $angkatan, Semesterkuliah $semester)
    {
        $t_a = $angkatan->tahun_angkatan;
        $i_s = $semester->id;
        $angkatan_aktif = \App\Models\Angkatan::where('status_angkatan', 'Aktif')->get()->sortBy('tahun_angkatan');
        $checker = $angkatan_aktif->contains('tahun_angkatan', $t_a);
        $semester_all = \App\Models\Semesterkuliah::ALL();
        $jadwal_semester = \App\Models\Jadwalkursus::where('id_semesterkuliah', $i_s)->where('id_angkatan', $angkatan->id)->get('id')->toArray();
        $jadwal = \App\Models\Jadwalkursus::where('id_semesterkuliah', $i_s)->where('id_angkatan', $angkatan->id)->get();
        $jadwal_id = \App\Models\Jadwalkursus::where('id_semesterkuliah', $i_s)->where('id_angkatan', $angkatan->id)->get('id')->toArray();
        $peserta = \App\Models\Peserta::where('id_angkatan', $angkatan->id_angkatan)->orderBy('nama_peserta')->get();
        $peserta_id = $peserta->map(function ($user) {
            return collect($user->toArray())
                ->only(['id'])
                ->all();
        });
        $pesertadijadwal = \App\Models\PesertaJadwalkursus::
        orderBy(function ($query){
            $query->select('nama_peserta')
            ->from('peserta')
            ->whereColumn('id', 'id_peserta');
        })->get();
        $pesertasudahadajadwal = \App\Models\PesertaJadwalkursus::whereIn('id_jadwalkursus', $jadwal_semester)->whereIn('id_peserta', $peserta_id)->get();
        $pesertasudahadajadwal_id = $pesertasudahadajadwal->map(function ($user) {
            return collect($user->toArray())
                ->only(['id_peserta'])
                ->all();
        });
        $pesertabelumadajadwal = \App\Models\Peserta::where('id_angkatan', $angkatan->id)->whereNotIn('id', $pesertasudahadajadwal_id)->orderBy('nama_peserta')->get();

        $pdf = PDF::loadView('jadwal_kursus.v_jadwal-semua', compact( 'peserta', 'pesertadijadwal', 'pesertabelumadajadwal', 't_a', 'i_s', 'angkatan_aktif', 'checker', 'semester_all', 'jadwal', 'angkatan', 'semester'));

        return $pdf->setPaper('A4', 'potrait')->download('Jadwal Kursus Angkatan-'.$t_a.' Semester-'.$i_s.'.pdf');
    }

    public function tambah_peserta(Request $request, Angkatan $angkatan, Semesterkuliah $semester, Jadwalkursus $jadwal_kursus)
    {
        $id_peserta = $request['check-box'];
        $jadwalterpilih = \App\Models\Jadwalkursus::where('id', $jadwal_kursus->id)->get();
        $peserta = Peserta::where('id_angkatan', $angkatan->id)->whereIn('id', $id_peserta)->get();
        foreach ($peserta as $data){
            $data->jadwal()->syncWithoutDetaching($jadwalterpilih);
        }
        return back()->with('pesan', 'Peserta berhasil ditambah ke jadwal ini');
    }

    public function hapus_peserta(Request $request, Angkatan $angkatan, Semesterkuliah $semester, Jadwalkursus $jadwal_kursus)
    {
        $id_peserta = $request->peserta_id;
        $i_j = $jadwal_kursus->id;
        DB::table('peserta_jadwalkursus')->where('id_peserta', $id_peserta)->where('id_jadwalkursus', $i_j)->delete();

        return back()->with('pesan', 'Peserta berhasil dihapus dari jadwal ini');
    }

    public function input_kehadiran(Request $request, Angkatan $angkatan, Semesterkuliah $semester, Jadwalkursus $jadwal_kursus)
    {
        $validator = FacadesValidator::make($request->all(),[
            'nomor_pertemuan' => 'required',
        ]);
        if($validator->fails()){
            return response()->json(['status'=>0, 'error'=>$validator->errors()->toArray()]);
        }
        $t_a = $angkatan->tahun_angkatan;
        $i_s = $semester->id;
        $i_j = $jadwal_kursus->id;
        $n_p = $request->nomor_pertemuan;
        $pesertadijadwal = \App\Models\PesertaJadwalkursus::where('id_jadwalkursus', $i_j)
        ->orderBy(function ($query){
            $query->select('nama_peserta')
            ->from('peserta')
            ->whereColumn('id', 'id_peserta');
        })->get();
        $peserta_id = $pesertadijadwal->map(function ($user) {
            return collect($user->toArray())
                ->only(['id'])
                ->all();
        });
        foreach ($pesertadijadwal as $key=>$data){
            $data->peserta->semesterkehadiran()->syncWithoutDetaching([$i_s =>
            [
                "pertemuan_".$n_p => $request->{'k'.$key+1},
            ]]);
            ${"pluck1".$key+1} = \App\Models\KehadiranPeserta::where('id_peserta', $data->id_peserta)->pluck('pertemuan_1');
            ${"pluck2".$key+1} = \App\Models\KehadiranPeserta::where('id_peserta', $data->id_peserta)->pluck('pertemuan_2');
            ${"pluck3".$key+1} = \App\Models\KehadiranPeserta::where('id_peserta', $data->id_peserta)->pluck('pertemuan_3');
            ${"pluck4".$key+1} = \App\Models\KehadiranPeserta::where('id_peserta', $data->id_peserta)->pluck('pertemuan_4');
            ${"pluck5".$key+1} = \App\Models\KehadiranPeserta::where('id_peserta', $data->id_peserta)->pluck('pertemuan_5');
            ${"pluck6".$key+1} = \App\Models\KehadiranPeserta::where('id_peserta', $data->id_peserta)->pluck('pertemuan_6');
            ${"pluck7".$key+1} = \App\Models\KehadiranPeserta::where('id_peserta', $data->id_peserta)->pluck('pertemuan_7');
            ${"pluck8".$key+1} = \App\Models\KehadiranPeserta::where('id_peserta', $data->id_peserta)->pluck('pertemuan_8');
            ${"pluck9".$key+1} = \App\Models\KehadiranPeserta::where('id_peserta', $data->id_peserta)->pluck('pertemuan_9');
            ${"pluck10".$key+1} = \App\Models\KehadiranPeserta::where('id_peserta', $data->id_peserta)->pluck('pertemuan_10');
            ${"a".$key+1} = collect([${"pluck1".$key+1},${"pluck2".$key+1},${"pluck3".$key+1},${"pluck4".$key+1},${"pluck5".$key+1},${"pluck6".$key+1},${"pluck7".$key+1},${"pluck8".$key+1},${"pluck9".$key+1},${"pluck10".$key+1}])->flatten()->toArray();
            ${"tot".$key+1} = array_filter(${"a".$key+1});
            ${"tot2".$key+1} = array_count_values(${"tot".$key+1});
            if(!array_key_exists("Hadir", ${"tot2".$key+1})){
                ${"counter_kehadiran".$key+1} = 0;
            }
            else{
                ${"tot3".$key+1} = ${"tot2".$key+1}["Hadir"];
                ${"counter_kehadiran".$key+1} = ${"tot3".$key+1}/80*100;
            }
            ${"kelengkapan_tugas".$key+1} = \App\Models\Kelulusanpeserta::where('id_peserta', $data->id_peserta)->first()->{"kelengkapan_tugas".$key+1};
            if(${"kelengkapan_tugas".$key+1} >= 56 && ${"counter_kehadiran".$key+1} > 50){
                $status = 'Lulus';
            }
            else{
                $status = 'Tidak Lulus';
            }
            ${"zz".$key+1} = Kelulusanpeserta::where('id_peserta', $data->id_peserta)->first();
            if(!${"zz".$key+1}){
                ${"table".$key+1} = new Kelulusanpeserta;
                ${"table".$key+1}->id_peserta = $data->id_peserta;
                ${"table".$key+1}->kehadiran = ${"counter_kehadiran".$key+1};
                ${"table".$key+1}->status_kelulusan = $status;
                ${"table".$key+1}->save();
            }
            elseif(${"zz".$key+1}){
                ${"table".$key+1} = ${"zz".$key+1};
                ${"table".$key+1}->kehadiran = ${"counter_kehadiran".$key+1};
                ${"table".$key+1}->status_kelulusan = $status;
                ${"table".$key+1}->save();
            }
        }
        

        return response()->json(['status'=>1, 'msg'=>'Kehadiran berhasil diinput']);
    }
}
