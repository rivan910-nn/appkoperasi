<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Simpanan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SimpananController extends Controller
{
    
public function index()
{
    $simpanan = Simpanan::with('anggota')
        ->latest()
        ->get();

    $totalSimpanan = Simpanan::where('status', 'disetujui')
        ->sum('nominal');

    $totalTransaksi = Simpanan::count();

    $totalMenunggu = Simpanan::where('status', 'menunggu')
        ->count();

    return view('simpanan.index', compact(
        'simpanan',
        'totalSimpanan',
        'totalTransaksi',
        'totalMenunggu'
    ));
}


    public function create()
    {
        $anggotas = Anggota::orderBy('nama')->get();

        return view('simpanan.create', compact('anggotas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'anggota_id' => [
                'required',
                'exists:anggota,id',
            ],
            'jenis' => [
                'required',
                Rule::in(['pokok', 'wajib', 'sukarela']),
            ],
            'nominal' => [
                'required',
                'numeric',
                'min:0.01',
                'max:9999999999999.99',
            ],
            'tanggal_transaksi' => [
                'required',
                'date',
            ],
            'status' => [
                'required',
                Rule::in(['menunggu', 'disetujui', 'ditolak']),
            ],
        ]);

        $validated['created_by'] = auth()->id();

        Simpanan::create($validated);

        return redirect()
            ->route('simpanan.index')
            ->with('success', 'Data simpanan berhasil ditambahkan.');
    }

    public function show(Simpanan $simpanan)
    {
        $simpanan->load(['anggota', 'pembuat']);

        return view('simpanan.show', compact('simpanan'));
    }

    public function edit(Simpanan $simpanan)
    {
        $anggotas = Anggota::orderBy('nama')->get();

        return view('simpanan.edit', compact(
            'simpanan',
            'anggotas'
        ));
    }

    public function update(Request $request, Simpanan $simpanan)
    {
        $validated = $request->validate([
            'anggota_id' => [
                'required',
                'exists:anggota,id',
            ],
            'jenis' => [
                'required',
                Rule::in(['pokok', 'wajib', 'sukarela']),
            ],
            'nominal' => [
                'required',
                'numeric',
                'min:0.01',
                'max:9999999999999.99',
            ],
            'tanggal_transaksi' => [
                'required',
                'date',
            ],
            'status' => [
                'required',
                Rule::in(['menunggu', 'disetujui', 'ditolak']),
            ],
        ]);

        // created_by tetap menggunakan pembuat awal.
        $simpanan->update($validated);

        return redirect()
            ->route('simpanan.index')
            ->with('success', 'Data simpanan berhasil diperbarui.');
    }

    public function destroy(Simpanan $simpanan)
    {
        $simpanan->delete();

        return redirect()
            ->route('simpanan.index')
            ->with('success', 'Data simpanan berhasil dihapus.');
    }
}
