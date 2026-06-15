<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController
{
    public function showLogin()
    {
        return view('pages.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = DB::table('users')->where('username', $request->username)->first();

        if ($user) {
            Auth::loginUsingId($user->id);

            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'loginError' => 'Username atau password salah!',
        ])->withInput($request->only('username'));
    }

    public function showRegister()
    {
        return view('pages.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|string|min:6|confirmed',
            'role'     => 'required|in:admin,member',
        ], [
            'password.confirmed' => 'Password tidak cocok! Silakan cek kembali cocokloginya.',
            'password.min'       => 'Password minimal harus 6 karakter ya!',
            'username.unique'    => 'Username ini sudah dipakai orang lain, bray.',
            'role.in'            => 'Role yang dipilih tidak valid!'
        ]);

        DB::table('users')->insert([
            'name'       => $request->name,
            'username'   => $request->username,
            'password'   => Hash::make($request->password),
            'role'       => $request->role,
            'created_at' => now(),
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}