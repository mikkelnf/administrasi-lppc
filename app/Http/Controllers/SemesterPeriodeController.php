<?php

namespace App\Http\Controllers;

use App\Models\Semesterperiode;
use App\Models\Semesterberjalan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class SemesterPeriodeController extends Controller
{
    public function index()
    {
        return redirect('/pengaturan');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nama_semesterperiode' => 'required|unique:semesterperiode|min:10',
        ]);

        if($validator->fails()){
            return response()->json(['status'=>0, 'error'=>$validator->errors()->toArray()]);
        }
        else{
            $semester = new Semesterperiode;
            $semester->nama_semesterperiode = $request->nama_semesterperiode;
            $semester->status_semesterperiode = $request->status;
            
            $query = $semester->save();
            
            if ($query){
                return response()->json(['status'=>1, 'msg'=>'Semester periode berhasil ditambah']);
            }
        }        
    }

    public function edit(Request $request, $id)
    {
        $semester_aktif = \App\Models\Semesterperiode::where('status_semesterperiode', 'Aktif')->get();

        $semester = Semesterperiode::find($id);
        $semester->status_semesterperiode = $request->status;

        if($semester_aktif->count() == 2){

            if($semester->status_semesterperiode == "Aktif"){
                return redirect('/pengaturan')->with('pesan-semester-error', 'Gagal edit! Semester periode bertatus Aktif sudah mencapai batas maksimum : 2');
            }
            elseif($semester->status_semesterperiode == "Tidak Aktif"){

                $query = $semester->save();
                if ($query){
                    $semesterberjalan = Semesterberjalan::first();
                    if($semesterberjalan->id_semesterperiode == $semester->id){
                        $semesterberjalan->id_semesterperiode = null;
                        $semesterberjalan->save();
                    }
                    return redirect('/pengaturan')->with('pesan-semester', 'Semester periode berhasil diedit');
                }

            }

        }
        elseif($semester_aktif->count() < 2){

            if($semester->status_semesterperiode == "Tidak Aktif"){
                $query = $semester->save();
                if ($query){
                    $semesterberjalan = Semesterberjalan::first();
                    if($semesterberjalan->id_semesterperiode == $semester->id){
                        $semesterberjalan->id_semesterperiode = null;
                        $semesterberjalan->save();
                    }
                    return redirect('/pengaturan')->with('pesan-semester', 'Semester periode berhasil diedit');
                }
            }
        
            $query = $semester->save();
            if ($query){
                return redirect('/pengaturan')->with('pesan-semester', 'Semester periode berhasil diedit');
            }
        }
    }  

    public function destroy($id)
    {
        DB::table('periode_pertemuan')->where('id_semesterperiode', $id)->delete();
        DB::table('semesterperiode')->where('id', $id)->delete();
        return redirect('/pengaturan')->with('pesan-semester', 'Semester periode berhasil dihapus');
    }
}
