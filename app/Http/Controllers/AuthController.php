<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\siswa;
use App\models\admin;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view('login');
    }
    public function dashboardSiswa()
    {
        return view('siswa.dashboard_siswa');
    }
    public function dashboardAdmin(){
        return view('admin.dashboard_admin');
    }

    public function login(Request $request){
        $request->validate([
            'identifier' => 'required',
            'password' => 'required',
        ],[
            'identifier.required' => 'Nis atau username harus diisi',
            'password.required' => 'password harus diisi'
            ]);
        $identifier = $request->identifier;
        $password = $request->password;

        //jika angka login siswa
        if(is_numeric($identifier)){
            $siswa = Siswa::where('nis', $identifier)
            ->where('password', $password)
            ->first();
        if($siswa){
            Auth::guard('siswa')->login($siswa);
            return redirect()->route('siswa.dashboard_siswa');
        }
        return redirect()->back()->withErrors([
            'login' => 'nis atau password salah'
        ])->withInput($request->only('identifier'));
        }
        $admin = admin::where('username', $identifier)
                ->where('password', $password)
                ->first();

        if($admin){
             Auth::guard('admin')->login($admin);
            return redirect()->route('admin.dashboard_admin');
        }
        return redirect()->back()->withErrors([
            'login' => 'username atau password salah'
        ])->withInput($request->only('identifier'));
    }
    //logout
    public function logout(Request $request){
        Auth::guard('siswa')->logout();
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}