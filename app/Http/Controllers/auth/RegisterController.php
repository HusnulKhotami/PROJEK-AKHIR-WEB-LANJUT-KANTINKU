<?php

namespace App\Http\Controllers\auth;

use App\Models\User;
use App\Models\Pedagang;   // <-- WAJIB ditambahkan
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // VALIDASI DASAR
        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:user,email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:mahasiswa,penjual',
            'phone' => 'nullable|string|max:12',
            'lokasi' => 'nullable|string|max:100',
        ]);

        // VALIDASI TAMBAHAN KHUSUS ROLE
        if ($request->role === 'mahasiswa') {
            $request->validate([
                'phone' => 'required|string|max:12'
            ]);
        }

        if ($request->role === 'penjual') {
            $request->validate([
                'lokasi' => 'required|string|max:100'
            ]);
        }

        // SIMPAN USER
        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'phone' => $request->role === 'mahasiswa' ? $request->phone : null,
            'lokasi' => $request->role === 'penjual' ? $request->lokasi : null,
        ]);

        // EVENT VERIFIKASI EMAIL
        event(new Registered($user));

        // ======================================================
        //   FIX TERPENTING: BUAT DATA PEDAGANG OTOMATIS
        // ======================================================
        if ($user->role === 'penjual') {
            Pedagang::create([
                'user_id' => $user->id,
                'nama_kantin' => $user->nama, // Nama kantin dari field nama
                'lokasi' => $user->lokasi,
            ]);
        }

        return redirect()->route('verification.notice')
            ->with('success', 'Pendaftaran berhasil! Silakan cek email untuk verifikasi.');
    }
}
