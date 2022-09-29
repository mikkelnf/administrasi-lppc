<?php

namespace App\Http\Controllers;

use App\Models\User;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class ProfilController extends Controller
{
    public function index()
    {
        return view('akun.v_akun-profil');
    }

    public function update(Request $request, $id)
    {
        $validator = FacadesValidator::make($request->all(),[
            'nama' => 'required|unique:user,nama_user,'.$id.'|min:5',
            'username' => 'required|unique:user,username,'.$id.'|min:5|alpha_dash',
        ]);

        if($validator->fails()){
            return response()->json(['status'=>0, 'error'=>$validator->errors()->toArray()]);
        }
        else {
            $user = User::find($id);
            $user->nama_user = $request->nama;
            $user->username = $request->username;
            
            $query = $user->save();

            if ($query){
                return response()->json(['status'=>1, 'msg'=>'Profil berhasil diubah']);
            }
        }
    }
}
