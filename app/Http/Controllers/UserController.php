<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        return redirect('/pengaturan');
    }

    public function store_admin(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nama' => 'required|unique:user,nama_user|min:5',
            'username' => 'required|unique:user,username|min:5|alpha_dash',
            'password' => 'required|min:5|confirmed',
            'password_confirmation' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['status'=>0, 'error'=>$validator->errors()->toArray()]);
        }
        else{
            $user = new User;
            $user->nama_user = $request->nama;
            $user->username = $request->username;
            $user->password = Hash::make($request->password);
            $user->status = $request->status;
            $user->id_role = $request->id_role;
            
            $query = $user->save();
            if ($query){
                return response()->json(['status'=>1, 'msg'=>'Administrator Berhasil Ditambah']);
            }
        }        
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nama' => 'required|unique:user,nama_user|min:5',
            'username' => 'required|unique:user,username|min:5|alpha_dash',
            'password' => 'required|min:5|confirmed',
            'password_confirmation' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['status'=>0, 'error'=>$validator->errors()->toArray()]);
        }
        else{
            $user = new User;
            $user->nama_user = $request->nama;
            $user->username = $request->username;
            $user->password = Hash::make($request->password);
            $user->status = 'Mahasiswa';
            $user->id_role = 2;
            
            $query = $user->save();
            if ($query){
                return response()->json(['status'=>1, 'msg'=>'Administrator Berhasil Ditambah']);
            }
        }        
    }

    public function edit(Request $request, $id)
    {
        $user = User::find($id);
        $user->status = $request->status;
        $user->id_role = $request->id_role;
            
        $query = $user->save();
        if ($query){
            return redirect('/pengaturan')->with('pesan-administrator', 'Administrator berhasil diedit');
        }     
    }

    public function destroy($id)
    {
        DB::delete('delete from user where id = ?',[$id]);
        return redirect('/pengaturan')->with('pesan-administrator', 'Administrator Berhasil Dihapus');
    }
}
