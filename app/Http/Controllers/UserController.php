<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Menampilkan daftar pengguna.
     */
    public function index(Request $request)
    {
        $users = User::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $keyword = $request->search;

                $query->where(function ($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%")
                      ->orWhere('email', 'like', "%{$keyword}%");
                });
            })
            ->when($request->filled('role'), function ($query) use ($request) {
                $query->where('role', $request->role);
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('users.index', compact('users'));
    }

    /**
     * Menampilkan formulir tambah pengguna.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Menyimpan pengguna baru.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'role' => [
                'required',
                Rule::in([
                    'admin',
                    'pengurus',
                    'bendahara',
                    'anggota',
                ]),
            ],

            'password' => [
                'required',
                'string',
                'min:12',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[^a-zA-Z0-9]/',
                'confirmed',
            ],

            'is_active' => ['required', 'boolean'],
        ], [
            'password.min' =>
                'Password harus minimal 12 karakter.',

            'password.regex' =>
                'Password harus mengandung huruf kecil, huruf besar, angka, dan simbol.',

            'password.confirmed' =>
                'Konfirmasi password tidak cocok.',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $user->role = $data['role'];
        $user->is_active = (bool) $data['is_active'];
        $user->save();

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail pengguna.
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Menampilkan formulir edit pengguna.
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Memperbarui data pengguna.
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],

            'role' => [
                'required',
                Rule::in([
                    'admin',
                    'pengurus',
                    'bendahara',
                    'anggota',
                ]),
            ],

            'password' => [
                'nullable',
                'string',
                'min:12',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[^a-zA-Z0-9]/',
                'confirmed',
            ],

            'is_active' => ['required', 'boolean'],
        ], [
            'password.min' =>
                'Password harus minimal 12 karakter.',

            'password.regex' =>
                'Password harus mengandung huruf kecil, huruf besar, angka, dan simbol.',

            'password.confirmed' =>
                'Konfirmasi password tidak cocok.',
        ]);

        // Mencegah admin aktif terakhir kehilangan hak admin
        // atau dinonaktifkan.
        $demotingLastAdmin =
            $user->role === 'admin'
            && $user->is_active
            && (
                $data['role'] !== 'admin'
                || ! (bool) $data['is_active']
            );

        if ($demotingLastAdmin) {
            $otherActiveAdmins = User::where('role', 'admin')
                ->where('is_active', true)
                ->whereKeyNot($user->id)
                ->exists();

            if (! $otherActiveAdmins) {
                return back()
                    ->withInput($request->except(
                        'password',
                        'password_confirmation'
                    ))
                    ->withErrors([
                        'role' =>
                            'Admin terakhir tidak boleh diturunkan rolenya atau dinonaktifkan.',
                    ]);
            }
        }

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->role = $data['role'];
        $user->is_active = (bool) $data['is_active'];

        // Password hanya diubah jika kolom diisi.
        if (! empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        // Logout jika pengguna menonaktifkan akunnya sendiri.
        if (
            $request->user()->is($user)
            && ! $user->is_active
        ) {
            auth()->logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('login')
                ->with(
                    'success',
                    'Akun dinonaktifkan dan Anda telah logout.'
                );
        }

        return redirect()
            ->route('users.index')
            ->with('success', 'Data user berhasil diperbarui.');
    }

    /**
     * Menghapus pengguna.
     */
    public function destroy(Request $request, User $user)
    {
        // Pengguna tidak boleh menghapus akunnya sendiri.
        if ($request->user()->is($user)) {
            return back()->with(
                'error',
                'Anda tidak dapat menghapus akun sendiri.'
            );
        }

        // Admin aktif terakhir tidak boleh dihapus.
        if (
            $user->role === 'admin'
            && $user->is_active
            && ! User::where('role', 'admin')
                ->where('is_active', true)
                ->whereKeyNot($user->id)
                ->exists()
        ) {
            return back()->with(
                'error',
                'Admin terakhir tidak boleh dihapus.'
            );
        }

        // Pengguna dengan riwayat simpanan tidak boleh dihapus.
        if (
            $user->simpananDibuat()->exists()
            || $user->simpananDiverifikasi()->exists()
        ) {
            return back()->with(
                'error',
                'User memiliki riwayat transaksi. Nonaktifkan akun, jangan hapus.'
            );
        }

        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil dihapus.');
    }
}
