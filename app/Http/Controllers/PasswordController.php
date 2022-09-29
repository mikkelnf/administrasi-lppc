<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PasswordController extends Controller
{
    public function index()
    {
        return view('akun.v_akun-password');
    }

    public function update(Request $request, $id)
    {
        $old_password = auth()->user()->password;
        $password = $request->old_password;

        if(Hash::check($password, $old_password)){
            $validator = Validator::make($request->all(),[
                'password' => 'required|min:5|confirmed',
                'password_confirmation' => 'required',
            ]);

            if($validator->fails()){
                return back()->with('pesan-password-error', $validator->errors()->first());
            }
            else {
                $user = User::find($id);
                $user->password = Hash::make($request->password);
                
                $query = $user->save();
    
                if ($query){
                    return back()->with('pesan-akun', 'Password berhasil diubah');
                }
            }
        }
        else if($password == ''){
            return back()->with('pesan-password-error', 'Isi password Lama');
        }
        else if(!Hash::check($password, $old_password)){
            return back()->with('pesan-password-error', 'Password lama tidak valid');
        }
    }
}
