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
        return back()->with('message', 'Email atau Password Salah!');
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    public function loginAPI(Request $request){
        $request->validate([
            'login'    => 'required|string', // Ini bisa berisi email atau NIP
            'password' => 'required|string',
        ]);

        // Tentukan apakah input adalah email atau nip
        $loginType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'NIP';

        $credentials = [
            $loginType => $request->login,
            'password' => $request->password,
        ];

        if(Auth::attempt($credentials)){
            $user = Auth::user();

            $user->load('bidang.skpd');
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => [
                    'user_id' => $user->user_id,
                    'nama'    => $user->Nama_Pengguna,
                    'email'   => $user->email,
                    'NIP'     => $user->NIP,
                    'bidang'  => $user->bidang->nama_bidang ?? 'Tanpa Bidang',
                    'skpd'    => $user->bidang->skpd->nama ?? 'Tanpa SKPD',
                ]
            ]);
        }

        return response()->json(['message' => 'Invalid login credentials'], 401);
    }


}
