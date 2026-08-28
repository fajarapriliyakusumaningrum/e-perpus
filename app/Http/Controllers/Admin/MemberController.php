<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    // Menampilkan daftar anggota + pencarian
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Kita ambil user yang role-nya 'user' (anggota/siswa)
        $members = User::where('role', 'user')
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.member.index', compact('members', 'search'));
    }

    // Menyimpan anggota baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', // Set otomatis sebagai user/anggota
        ]);

        return redirect()->route('admin.member.index')->with('success', 'Anggota baru berhasil ditambahkan!');
    }

    // Mengupdate data anggota
    public function update(Request $request, User $member)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $member->id,
            'password' => 'nullable|string|min:6',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        // Jika password diisi, update password baru. Jika kosong, biarkan password lama.
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $member->update($data);

        return redirect()->route('admin.member.index')->with('success', 'Data anggota berhasil diperbarui!');
    }

    // Menghapus anggota
    public function destroy(User $member)
    {
        $member->delete();
        return redirect()->route('admin.member.index')->with('success', 'Anggota berhasil dihapus!');
    }
}