<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Routing\Controller as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends BaseController
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'id_user' => 'required',
            'password' => 'required'
        ]);

        // Debug untuk melihat input
        \Log::info('Login attempt:', [
            'id_user' => $request->id_user,
            'password' => $request->password
        ]);

        // Query dengan decrypt yang benar
        $user = DB::select("SELECT u.*, p.nama, p.jbtn,
            AES_DECRYPT(u.id_user, 'nur') as username,
            AES_DECRYPT(u.password, 'windi') as decrypted_password
            FROM user u
            LEFT JOIN pegawai p ON AES_DECRYPT(u.id_user, 'nur') = p.nik 
            WHERE AES_DECRYPT(u.id_user, 'nur') = ?", 
            [$request->id_user]
        );

        // Debug untuk melihat hasil query
        \Log::info('Query result:', ['user' => $user]);

        if (count($user) > 0) {
            $user = $user[0];
            
            // Debug password comparison
            \Log::info('Password comparison:', [
                'input_password' => $request->password,
                'db_password' => $user->decrypted_password
            ]);
            
            if ($request->password === $user->decrypted_password) {
                // Convert DB result to User model
                $userModel = User::where('id_user', $user->id_user)->first();
                Auth::login($userModel);
                Session::put('user', $user);
                Session::put('nama_pegawai', $user->nama);
                Session::put('jabatan', $user->jbtn);
                return redirect()->intended('dashboard');
            }
        }

        return back()->withErrors([
            'id_user' => 'ID User atau Password salah',
        ]);
    }

    public function dashboard()
    {
        $data = [
            'rawatInap' => 1,
            'pasienPulang' => 0,
            'pasienMasuk' => 0,
            'surveilans' => [
                'IAD' => 0,
                'PLEB' => 0,
                'ISK' => 0,
                'ILO' => 0,
                'HAP' => 0
            ],
            'alatTerpasang' => [
                'ETT' => 0,
                'CVL' => 0,
                'IVL' => 0,
                'UC' => 0
            ]
        ];
        return view('dashboard', compact('data'));
    }

    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect()->route('login');
    }
} 