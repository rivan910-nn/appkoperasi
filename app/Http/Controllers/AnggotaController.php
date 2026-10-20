<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AnggotaController extends Controller
{
    public function index(Request $request)
    {
        $query = Anggota::query();

        if ($request->filled('cari')) {
            $cari = $request->cari;
            $query->where(function ($q) use ($cari) {
                $q->where('no_anggota', 'like', "%{$cari}%")
                  ->orWhere('nik', 'like', "%{$cari}%")
                  ->orWhere('nama', 'like', "%{$cari}%")
                  ->orWhere('no_hp', 'like', "%{$cari}%");
            });
        }

        if ($request->filled('status') && in_array($request->status, ['aktif', 'nonaktif'], true)) {
            $query->where('status', $request->status);
        }

        $anggota = $query->latest()->paginate(10)->withQueryString();

        return view('anggota.index', compact('anggota'));
    }

    public function create()
    {
        return view('anggota.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_anggota' => ['required', 'string', 'max:30', 'unique:anggota,no_anggota'],
            'nik' => ['required', 'string', 'size:16', 'unique:anggota,nik'],
            'nama' => ['required', 'string', 'max:150'],
            'jenis_kelamin' => ['required', Rule::in(['L', 'P'])],
            'tempat_lahir' => ['nullable', 'string', 'max:100'],
            'tanggal_lahir' => ['nullable', 'date', 'before_or_equal:today'],
            'alamat' => ['required', 'string'],
            'no_hp' => ['required', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255', 'unique:anggota,email'],
            'tanggal_bergabung' => ['required', 'date'],
            'status' => ['required', Rule::in(['aktif', 'nonaktif'])],
        ], [
            'nik.size' => 'NIK harus terdiri dari tepat 16 digit.',
            'jenis_kelamin.in' => 'Pilih jenis kelamin yang tersedia.',
            'no_anggota.unique' => 'Nomor anggota sudah digunakan.',
            'nik.unique' => 'NIK sudah terdaftar.',
            'email.unique' => 'Email sudah digunakan.',
        ]);

        Anggota::create($validated);

        return redirect()->route('anggota.index')
            ->with('success', 'Data anggota berhasil ditambahkan.');
    }

    public function show(Anggota $anggota)
    {
        return view('anggota.show', compact('anggota'));
    }

    public function edit(Anggota $anggota)
    {
        return view('anggota.edit', compact('anggota'));
    }

    public function update(Request $request, Anggota $anggota)
    {
        $validated = $request->validate([
            'no_anggota' => ['required', 'string', 'max:30', Rule::unique('anggota', 'no_anggota')->ignore($anggota->id)],
            'nik' => ['required', 'string', 'size:16', Rule::unique('anggota', 'nik')->ignore($anggota->id)],
            'nama' => ['required', 'string', 'max:150'],
            'jenis_kelamin' => ['required', Rule::in(['L', 'P'])],
            'tempat_lahir' => ['nullable', 'string', 'max:100'],
            'tanggal_lahir' => ['nullable', 'date', 'before_or_equal:today'],
            'alamat' => ['required', 'string'],
            'no_hp' => ['required', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255', Rule::unique('anggota', 'email')->ignore($anggota->id)],
            'tanggal_bergabung' => ['required', 'date'],
            'status' => ['required', Rule::in(['aktif', 'nonaktif'])],
        ], [
            'nik.size' => 'NIK harus terdiri dari tepat 16 digit.',
            'no_anggota.unique' => 'Nomor anggota sudah digunakan.',
            'nik.unique' => 'NIK sudah terdaftar.',
            'email.unique' => 'Email sudah digunakan.',
        ]);

        $anggota->update($validated);

        return redirect()->route('anggota.index')
            ->with('success', 'Data anggota berhasil diperbarui.');
    }

    public function destroy(Anggota $anggota)
    {
        $anggota->delete();

        return redirect()->route('anggota.index')
            ->with('success', 'Data anggota berhasil dihapus.');
    }
}
