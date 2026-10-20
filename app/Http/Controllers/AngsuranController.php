<?php

namespace App\Http\Controllers;

use App\Models\Angsuran;
use App\Models\Pinjaman;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AngsuranController extends Controller
{
    public function index(Request $request)
    {
        $query = Angsuran::with('pinjaman.anggota');

        if ($request->filled('cari')) {
            $cari = $request->cari;

            $query->where(function ($q) use ($cari) {
                $q->where('angsuran_ke', 'like', "%{$cari}%")
                    ->orWhereHas('pinjaman', function ($p) use ($cari) {
                        $p->where('id', 'like', "%{$cari}%")
                            ->orWhereHas('anggota', function ($a) use ($cari) {
                                $a->where('nama', 'like', "%{$cari}%")
                                    ->orWhere('no_anggota', 'like', "%{$cari}%");
                            });
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $angsuran = $query
            ->latest('jatuh_tempo')
            ->paginate(10)
            ->withQueryString();

        return view('angsuran.index', compact('angsuran'));
    }

    public function create()
    {
        $pinjaman = Pinjaman::with('anggota')->get();

        return view('angsuran.create', compact('pinjaman'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pinjaman_id' => [
                'required',
                'exists:pinjaman,id',
            ],
            'angsuran_ke' => [
                'required',
                'integer',
                'min:1',
                'max:65535',
                Rule::unique('angsuran', 'angsuran_ke')
                    ->where('pinjaman_id', $request->pinjaman_id),
            ],
            'jatuh_tempo' => ['required', 'date'],
            'jumlah_tagihan' => ['required', 'numeric', 'min:0.01'],
            'jumlah_bayar' => ['required', 'numeric', 'min:0'],
            'tanggal_bayar' => ['nullable', 'date'],
            'status' => [
                'required',
                Rule::in(['belum_bayar', 'dibayar', 'terlambat']),
            ],
        ]);

        if ((float) $validated['jumlah_bayar'] > (float) $validated['jumlah_tagihan']) {
            return back()
                ->withInput()
                ->withErrors([
                    'jumlah_bayar' => 'Jumlah bayar tidak boleh melebihi jumlah tagihan.',
                ]);
        }

        Angsuran::create($validated);

        return redirect()
            ->route('angsuran.index')
            ->with('success', 'Data angsuran berhasil ditambahkan.');
    }

    public function show(Angsuran $angsuran)
    {
        $angsuran->load('pinjaman.anggota');

        return view('angsuran.show', compact('angsuran'));
    }

    public function edit(Angsuran $angsuran)
    {
        $pinjaman = Pinjaman::with('anggota')->get();

        return view('angsuran.edit', compact('angsuran', 'pinjaman'));
    }

    public function update(Request $request, Angsuran $angsuran)
    {
        $validated = $request->validate([
            'pinjaman_id' => [
                'required',
                'exists:pinjaman,id',
            ],
            'angsuran_ke' => [
                'required',
                'integer',
                'min:1',
                'max:65535',
                Rule::unique('angsuran', 'angsuran_ke')
                    ->where('pinjaman_id', $request->pinjaman_id)
                    ->ignore($angsuran->id),
            ],
            'jatuh_tempo' => ['required', 'date'],
            'jumlah_tagihan' => ['required', 'numeric', 'min:0.01'],
            'jumlah_bayar' => ['required', 'numeric', 'min:0'],
            'tanggal_bayar' => ['nullable', 'date'],
            'status' => [
                'required',
                Rule::in(['belum_bayar', 'dibayar', 'terlambat']),
            ],
        ]);

        if ((float) $validated['jumlah_bayar'] > (float) $validated['jumlah_tagihan']) {
            return back()
                ->withInput()
                ->withErrors([
                    'jumlah_bayar' => 'Jumlah bayar tidak boleh melebihi jumlah tagihan.',
                ]);
        }

        $angsuran->update($validated);

        return redirect()
            ->route('angsuran.index')
            ->with('success', 'Data angsuran berhasil diperbarui.');
    }

    public function destroy(Angsuran $angsuran)
    {
        $angsuran->delete();

        return redirect()
            ->route('angsuran.index')
            ->with('success', 'Data angsuran berhasil dihapus.');
    }
}
