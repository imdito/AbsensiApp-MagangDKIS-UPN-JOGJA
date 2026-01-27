<?php

namespace App\Http\Controllers\auth;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends controller{
    public function index(){
        return view('auth.login');
    }

    public function authenticate(Request $request){

        $credentials = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'

        ]);
        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            return redirect()->intended('/');
        }
        return back()->with('message', 'Login failed!');
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    public function loginAPI(Request $request){
       $credentials  = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'

        ]);

        if(Auth::attempt($credentials)){
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => [
                    'user_id' => $user->user_id,
                    'nama' => $user->Nama_Pengguna,
                    'email' => $user->email,
                    'divisi' => $user->bidang->nama_bidang,
                    'NIP' => $user->NIP,

                ]
            ]);
        }

        return response()->json(['message' => 'Invalid login credentials'], 401);
    }


}
