<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; // ← tambahkan ini

class AuthController extends Controller
{
    public function index()
    {
        return view('login');
    }

   public function login(Request $request)
{
    $request->validate([
        'identifier' => 'required',
        'password'   => 'required',
    ], [
        'identifier.required' => 'NIS atau username harus diisi',
        'password.required'   => 'Password harus diisi',
    ]);

    $identifier = $request->identifier;
    $password   = $request->password;

    //Login siswa
    if (is_numeric($identifier)) {
        $siswa = Siswa::where('nis', $identifier)->first();

        if ($siswa) {
            if (!str_starts_with($siswa->password, '$2y$')) {
                if ($siswa->password == $password) {
                    $siswa->password = Hash::make($password);
                    $siswa->save();
                } else {
                    return redirect()->back()->withErrors(['login' => 'NIS atau password salah'])
                        ->withInput($request->only('identifier'));
                }
            }

            if (Hash::check($password, $siswa->password)) {
                Auth::guard('siswa')->login($siswa);
                return redirect()->route('siswa.dashboard_siswa');
            }
        }

        return redirect()->back()->withErrors(['login' => 'NIS atau password salah'])
            ->withInput($request->only('identifier'));
    }

    //Lofin admin
    $admin = Admin::where('username', $identifier)->first();

    if ($admin) {
        if (!str_starts_with($admin->password, '$2y$')) {
            if ($admin->password == $password) {
                $admin->password = Hash::make($password);
                $admin->save();
            } else {
                return redirect()->back()->withErrors(['login' => 'Username atau password salah'])
                    ->withInput($request->only('identifier'));
            }
        }

        if (Hash::check($password, $admin->password)) {
            Auth::guard('admin')->login($admin);
            return redirect()->route('admin.dashboard_admin');
        }
    }

    return redirect()->back()->withErrors(['login' => 'Username atau password salah'])
        ->withInput($request->only('identifier'));
}

    public function logout(Request $request)
    {
        Auth::guard('siswa')->logout();
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}