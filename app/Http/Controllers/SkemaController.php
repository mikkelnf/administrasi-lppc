<?php

namespace App\Http\Controllers;

use App\Models\Skema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class SkemaController extends Controller
{
    public function index()
    {
        return redirect('/pengaturan');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nama_skema' => 'required|unique:skema|min:5',
        ]);

        if($validator->fails()){
            return response()->json(['status'=>0, 'error'=>$validator->errors()->toArray()]);
        }
        else{
            $skema = new Skema;
            $skema->nama_skema = $request->nama_skema;
            
            $query = $skema->save();
            
            if ($query){
                return response()->json(['status'=>1, 'msg'=>'Skema berhasil ditambah']);
            }
        }        
    }

    public function edit(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'nama_skema' => 'required|unique:skema,nama_skema,'.$id.'|min:5',
        ]);

        if($validator->fails()){
            return response()->json(['status'=>0, 'error'=>$validator->errors()->toArray()]);
        }
        else{
            $skema = Skema::find($id);
            $skema->nama_skema = $request->nama_skema;

            $query = $skema->save();
            if ($query){
                return response()->json(['status'=>1, 'msg'=>'Skema berhasil diedit']);
            }
        }
    }  
    

    public function destroy($id)
    {
        DB::delete('delete from skema where id = ?',[$id]);
        return redirect('/pengaturan')->with('pesan-skema', 'Skema berhasil dihapus');
    }
}
