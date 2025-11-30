<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Tampilkan daftar pengguna.
     */
    public function index(Request $request)
    {
        $type = $request->get('type'); // mahasiswa / penjual

        if ($type === 'mahasiswa') {
            $users = User::where('role', 'mahasiswa')
                         ->orderBy('created_at', 'desc')
                         ->get();
        } elseif ($type === 'penjual') {
            $users = User::where('role', 'penjual')
                         ->orderBy('created_at', 'desc')
                         ->get();
        } else {
            // Default: Semua role kecuali admin
            $users = User::where('role', '!=', 'admin')
                         ->orderBy('created_at', 'desc')
                         ->get();
        }

        return view('admin.pengguna.index', compact('users', 'type'));
    }

    /**
     * Form tambah pengguna.
     */
    public function create()
    {
        return view('admin.pengguna.create');
    }

    /**
     * Simpan pengguna baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'   => 'required|string|max:100',
            'email'  => 'required|email|unique:user,email',
            'role'   => 'required|in:mahasiswa,penjual,admin',
            'phone'  => 'nullable|string|max:12',
            'password' => 'nullable|string|min:6',
        ]);

        // Jika password kosong → set default
        if (empty($validated['password'])) {
            $validated['password'] = Hash::make('password');
        } else {
            $validated['password'] = Hash::make($validated['password']);
        }

        User::create($validated);

        return redirect()
            ->route('admin.pengguna')
            ->with('success', 'Pengguna berhasil ditambahkan.');
    }

    /**
     * Form edit pengguna.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('admin.pengguna.edit', compact('user'));
    }

    /**
     * Update data pengguna.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'nama'   => 'required|string|max:100',
            'email'  => 'required|email|unique:user,email,' . $user->id,
            'role'   => 'required|in:mahasiswa,penjual,admin',
            'phone'  => 'nullable|string|max:12',
            'password' => 'nullable|string|min:6',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()
            ->route('admin.pengguna')
            ->with('success', 'Data pengguna berhasil diperbarui.');
    }

    /**
     * Halaman konfirmasi hapus pengguna.
     */
    public function confirmDelete($id)
    {
        $user = User::findOrFail($id);

        return view('admin.pengguna.hapus', compact('user'));
    }

    /**
     * Hapus pengguna.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()
            ->route('admin.pengguna')
            ->with('success', 'Pengguna berhasil dihapus.');
    }
}