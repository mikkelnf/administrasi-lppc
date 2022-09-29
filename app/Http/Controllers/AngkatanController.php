<?php

namespace App\Http\Controllers;

use App\Models\Angkatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AngkatanController extends Controller
{
    public function index()
    {
        return redirect('/pengaturan');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'tahun_angkatan' => 'required|unique:angkatan|digits:4',
        ]);

        if($validator->fails()){
            return response()->json(['status'=>0, 'error'=>$validator->errors()->toArray()]);
        }
        else{
            $angkatan = new Angkatan;
            $angkatan->tahun_angkatan = $request->tahun_angkatan;
            $angkatan->status_angkatan = $request->status;
            
            $query = $angkatan->save();
            
            if ($query){
                return response()->json(['status'=>1, 'msg'=>'Angkatan berhasil ditambah']);
            }
        }        
    }

    public function edit(Request $request, $id)
    {
        $angkatan_aktif = \App\Models\Angkatan::where('status_angkatan', 'Aktif')->get();
        $angkatanpilih = \App\Models\Angkatan::where('id', $id)->first();

        $angkatan = Angkatan::find($id);
        $angkatan->status_angkatan = $request->status;
        $angkatan->semester_aktif = $request->semester_aktif;

        if($angkatan_aktif->count() == 4){

            if($angkatanpilih->status_angkatan == "Tidak Aktif"){

                return redirect('/pengaturan')->with('pesan-angkatan-error', 'Gagal edit! Angkatan bertatus Aktif sudah mencapai batas maksimum : 4');
            
            }
            else{

                $query = $angkatan->save();
                if ($query){
                    return redirect('/pengaturan')->with('pesan-angkatan', 'Angkatan berhasil diedit');
                }

            }

        }
        elseif($angkatan_aktif->count() < 4){

            $query = $angkatan->save();
            if ($query){
                return redirect('/pengaturan')->with('pesan-angkatan', 'Angkatan berhasil diedit');
            }

        }
    }  
    

    public function destroy($id)
    {
        DB::delete('delete from angkatan where id = ?',[$id]);
        return redirect('/pengaturan')->with('pesan-angkatan', 'Angkatan berhasil dihapus');
    }
}
