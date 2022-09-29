<?php

namespace App\Http\Controllers;

use App\Models\Peserta;
use App\Models\Angkatan;
use App\Models\Kelulusanpeserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class PesertaAngkatanController extends Controller
{
    public function index()
    {
        $angkatan_aktif = \App\Models\Angkatan::where('status_angkatan', 'Aktif')->get()->sortBy('tahun_angkatan');
        return view('peserta.v_peserta-angkatan-menu', compact('angkatan_aktif'));
    }
    
    public function store(Request $request)
    {
        $request->all();
        $validator = Validator::make($request->all(),[
            'npm' => 'required|unique:peserta,npm_peserta|min:8',
            'nama' => 'required|min:5',
            'no_telp' => 'nullable|min:5',
            'email' => 'nullable',
            'kelas' => 'nullable|between:4,5',
            'id_jurusan' => 'required',
            'id_angkatan' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['status'=>0, 'error'=>$validator->errors()->toArray()]);
        }else{
            if($request->id_jurusan == 3){
                $id_skema = \App\Models\Skema::where('nama_skema', '3D Illustration Artist')->first()->id;
            }
            else{
                $id_skema = \App\Models\Skema::where('nama_skema', 'Pembuat Ide Gerak & Cerita (Generalist)')->first()->id;
            }
            $peserta = new Peserta;
            $peserta->npm_peserta = $request->npm;
            $peserta->nama_peserta = $request->nama;
            $peserta->notelp_peserta = $request->no_telp;
            $peserta->email_peserta = $request->email;
            $peserta->kelas_peserta = $request->kelas;
            $peserta->id_jurusan = $request->id_jurusan;
            $peserta->id_angkatan = $request->id_angkatan;
            $peserta->id_skema = $id_skema;
            
            $query = $peserta->save();
            if ($query){
                return response()->json(['status'=>1, 'msg'=>'Peserta berhasil ditambah']);
            }
        }    
    }

    public function show(Angkatan $angkatan)
    {
        $peserta = \App\Models\Peserta::where('id_angkatan', $angkatan->id)->orderBy('nama_peserta')->get();
        $jurusan = \App\Models\Jurusan::ALL();
        $t_a = $angkatan->tahun_angkatan;
        $angkatan_aktif = \App\Models\Angkatan::where('status_angkatan', 'Aktif')->get()->sortBy('tahun_angkatan');
        $checker = $angkatan_aktif->contains('tahun_angkatan', $t_a);
        $skema = \App\Models\Skema::orderBy('id')->get();

        foreach ($peserta as $data){
            $data->semesterkehadiran()->sync([1,2,3,4,5,6,7,8]);
            $cek = Kelulusanpeserta::where('id_peserta', $data->id)->first();
            if(!$cek){
                $table = new Kelulusanpeserta;
                $table->id_peserta = $data->id;
                $query = $table->save();
            }
        }
        
        return view('peserta.v_peserta-angkatan', compact( 'peserta', 'jurusan', 't_a', 'angkatan_aktif', 'checker', 'angkatan', 'skema'));
    }

    
    public function edit(Request $request, $tahun_angkatan, $id)
    {
        $validator = Validator::make($request->all(),[
            'npm' => 'required|unique:peserta,npm_peserta,'.$id.'|digits:8',
            'nama' => 'required|unique:peserta,nama_peserta,'.$id.'',
            'no_telp' => 'nullable|min:5',
            'email' => 'nullable',
            'kelas' => 'nullable|between:4,5',
            'id_jurusan' => 'required',
            'id_angkatan' => 'required',
            'id_skema' => 'nullable',
        ]);

        if($validator->fails()){
            return response()->json(['status'=>0, 'error'=>$validator->errors()->toArray()]);
        }
        else{
            $peserta = Peserta::find($id);
            $peserta->npm_peserta = $request->npm;
            $peserta->nama_peserta = $request->nama;
            $peserta->notelp_peserta = $request->no_telp;
            $peserta->email_peserta = $request->email;
            $peserta->kelas_peserta = $request->kelas;
            $peserta->id_jurusan = $request->id_jurusan;
            $peserta->id_angkatan = $request->id_angkatan;
            $peserta->id_skema = $request->id_skema;

            $query = $peserta->save();

            if(Peserta::where('id', $id)->first()->skema->nama_skema == '3D Illustration Artist'){
                $kehadiran = \App\Models\Kelulusanpeserta::where('id_peserta', $id)->first()->kehadiran;
                $counter_tugas = \App\Models\Evaluasitugasd3::where('id_peserta', $id)->count()/28*100;
            }
            else{
                $kehadiran = \App\Models\Kelulusanpeserta::where('id_peserta', $id)->first()->kehadiran;
                $counter_tugas = \App\Models\Evaluasitugas::where('id_peserta', $id)->count()/40*100;
            }
            if($counter_tugas >= 56 && $kehadiran > 50){
                $status = 'Lulus';
            }
            else{
                $status = 'Tidak Lulus';
            }
            $cek = Kelulusanpeserta::where('id_peserta', $id)->first();
            if(!$cek){
                $table = new Kelulusanpeserta;
                $table->id_peserta = $id;
                $query = $table->save();
            }
            elseif($cek){
                $table = $cek;
                $table->kehadiran = $kehadiran;
                $table->kelengkapan_tugas = $counter_tugas;
                $table->status_kelulusan = $status;
                $table->save();
            }

            if ($query){
                return response()->json(['status'=>1, 'msg'=>'Peserta berhasil diedit']);
            }
        }
    }

    public function destroy($tahun_angkatan, $id)
    {
        DB::delete('delete from peserta where id = ?', [$id]);
        DB::delete('delete from peserta_jadwalkursus where id_peserta = ?', [$id]);
        return back()->with('pesan', 'Peserta berhasil dihapus');
    }
}
