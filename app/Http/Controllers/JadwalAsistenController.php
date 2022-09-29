<?php

namespace App\Http\Controllers;

use App\Models\Jadwalasisten;
use App\Models\AsistenJadwalasisten;
use App\Models\Pertemuankursus;
use App\Models\Semesterperiode;
use App\Models\PeriodePertemuan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class JadwalAsistenController extends Controller
{
    public function index()
    {
        $s_periode = Semesterperiode::where('status_semesterperiode', 'Aktif')->get();

        return view('jadwal_asisten.v_jadwal-semester-menu', compact('s_periode'));
    }

    public function pertemuan_menu(Semesterperiode $semesterperiode)
    {
        $i_s = $semesterperiode->id;
        $n_s = $semesterperiode->nama_semesterperiode;
        $s_periode = Semesterperiode::where('status_semesterperiode', 'Aktif')->get();
        $checker = $s_periode->contains('id', $i_s);
        $pertemuan = Pertemuankursus::all();

        return view('jadwal_asisten.v_jadwal-pertemuan-menu', compact('s_periode', 'i_s', 'n_s', 's_periode', 'checker', 'pertemuan'));
    }

    public function jadwal_menu(Semesterperiode $semesterperiode, Pertemuankursus $pertemuan)
    {
        $i_s = $semesterperiode->id;
        $i_p = $pertemuan->id;
        $n_s = $semesterperiode->nama_semesterperiode;
        $s_periode = Semesterperiode::where('status_semesterperiode', 'Aktif')->get();
        $checker = $s_periode->contains('id', $i_s);
        $pertemuan_all = Pertemuankursus::all();
        $jadwal_asisten = Jadwalasisten::where('id_semesterperiode', $i_s)->where('id_pertemuankursus', $i_p)->get();
        $jadwal_asisten_id = Jadwalasisten::where('id_semesterperiode', $i_s)->where('id_pertemuankursus', $i_p)->get('id')->toArray();
        $pesertadijadwal = \App\Models\PesertaJadwalkursus::all();
        $jadwalkursus = \App\Models\Jadwalkursus::orderBy('id_angkatan')->orderBy('id_semesterkuliah')->get();
        
        $a = Semesterperiode::where('id', $i_s)->first();
        $a->pertemuankursus()->sync([1,2,3,4,5,6,7,8,9,10]);

        $jadwal_id = Jadwalasisten::where('id_pertemuankursus', $i_p)->where('id_semesterperiode', $i_s)->get('id')->toArray();

        $b = AsistenJadwalasisten::get();

        $c = Jadwalasisten::where('id_pertemuankursus', $i_p)->where('id_semesterperiode', $i_s);

        $periode = PeriodePertemuan::where('id_semesterperiode', $i_s)->where('id_pertemuankursus', $i_p)->first();

        $asisten = User::whereIn('id_role', [1, 2])->get();

        return view('jadwal_asisten.v_jadwal-menu', compact(
            's_periode', 'i_s', 'i_p', 'n_s', 's_periode', 'checker', 'pertemuan_all', 'jadwal_asisten', 'pesertadijadwal', 'periode', 'b', 'c',
            'asisten', 'jadwalkursus'
        ));
    }

    public function semua_jadwal(Semesterperiode $semesterperiode, Pertemuankursus $pertemuan)
    {
        $i_s = $semesterperiode->id;
        $i_p = $pertemuan->id;
        $n_s = $semesterperiode->nama_semesterperiode;
        $s_periode = Semesterperiode::where('status_semesterperiode', 'Aktif')->get();
        $checker = $s_periode->contains('id', $i_s);
        $pertemuan_all = Pertemuankursus::all();
        $jadwal_asisten = Jadwalasisten::where('id_semesterperiode', $i_s)->where('id_pertemuankursus', $i_p)->get();
        $jadwal_asisten_id = Jadwalasisten::where('id_semesterperiode', $i_s)->where('id_pertemuankursus', $i_p)->get('id')->toArray();
        $pesertadijadwal = \App\Models\PesertaJadwalkursus::all();
        $jadwalkursus = \App\Models\Jadwalkursus::orderBy('id_angkatan')->orderBy('id_semesterkuliah')->get();
        
        $a = Semesterperiode::where('id', $i_s)->first();
        $a->pertemuankursus()->sync([1,2,3,4,5,6,7,8,9,10]);

        $jadwal_id = Jadwalasisten::where('id_pertemuankursus', $i_p)->where('id_semesterperiode', $i_s)->get('id')->toArray();

        $b = AsistenJadwalasisten::get();

        $c = Jadwalasisten::where('id_pertemuankursus', $i_p)->where('id_semesterperiode', $i_s);

        $periode = PeriodePertemuan::where('id_semesterperiode', $i_s)->where('id_pertemuankursus', $i_p)->first();

        $asisten = User::whereIn('id_role', [1, 2])->get();

        return view('jadwal_asisten.v_jadwal-semua', compact(
            's_periode', 'i_s', 'i_p', 'n_s', 's_periode', 'checker', 'pertemuan_all', 'jadwal_asisten', 'pesertadijadwal', 'periode', 'b', 'c',
            'asisten', 'jadwalkursus'
        ));
    }

    public function edit_periode(Request $request, Semesterperiode $semesterperiode, Pertemuankursus $pertemuan)
    {
        $i_s = $semesterperiode->id;
        $i_p = $pertemuan->id;
        $semester = Semesterperiode::where('id', $i_s)->first();
        $query = $semester->pertemuankursus()->syncWithoutDetaching([$i_p =>
        [
        'periode' => $request->periode
        ]]);

        if ($query){
            return back()->with('pesan', 'Periode berhasil diedit');
        }    
    }

    public function tambah_jadwal(Request $request, Semesterperiode $semesterperiode, Pertemuankursus $pertemuan)
    {
        $id_kursus = $request->id_kursus;
        $id_ast = $request['asisten'];
        $i_s = $semesterperiode->id;
        $i_p = $pertemuan->id;

        $jadwal = new Jadwalasisten;
        $jadwal->id_semesterperiode = $i_s;
        $jadwal->id_pertemuankursus = $i_p;
        $jadwal->id_jadwalkursus = $id_kursus;
        $jadwal->host = $request->host;
        $jadwal->instruktur = $request->instruktur;
        
        $query = $jadwal->save();

        $a = Jadwalasisten::where('id', $jadwal->id)->first();
        $a->asisten()->syncWithoutDetaching($id_ast);

        if ($query){
            return response()->json(['status'=>1, 'msg'=>'Jadwal berhasil ditambah']);
        }
    }

    public function edit_jadwal(Request $request, Semesterperiode $semesterperiode, Pertemuankursus $pertemuan, Jadwalasisten $jadwal_asisten)
    {
        $id_kursus = $request->id_kursus;
        $id_ast = $request['asisten'];
        $i_s = $semesterperiode->id;
        $i_p = $pertemuan->id;

        $jadwal = Jadwalasisten::find($jadwal_asisten->id);
        $jadwal->id_semesterperiode = $i_s;
        $jadwal->id_pertemuankursus = $i_p;
        $jadwal->id_jadwalkursus = $id_kursus;
        $jadwal->host = $request->host;
        $jadwal->instruktur = $request->instruktur;
        
        $jadwal->save();

        $a = Jadwalasisten::where('id', $jadwal->id)->first();
        $a->asisten()->sync($id_ast);

        return response()->json(['status'=>1, 'msg'=>'Jadwal berhasil diedit']);

    }

    public function hapus_jadwal(Semesterperiode $semesterperiode, Pertemuankursus $pertemuan, Jadwalasisten $jadwal_asisten)
    {
        $i_j = $jadwal_asisten->id;
        DB::table('asisten_jadwalasisten')->where('id_jadwalasisten', $i_j)->delete();
        DB::table('jadwalasisten')->where('id', $i_j)->delete();

        return back()->with('pesan', 'Jadwal berhasil dihapus');
    }
}
