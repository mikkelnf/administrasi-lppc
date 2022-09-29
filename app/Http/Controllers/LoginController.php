<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('v_login');
    }

    public function loginuser(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            return redirect('/');
        }
        return back()->with('pesan', 'Data login Tidak Valid');
    }

    public function logoutuser()
    {
        Auth::logout();
        return redirect('/login');
    }
}
