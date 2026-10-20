<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Pinjaman;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PinjamanController extends Controller
{
    private array $statusPilihan = [
        'diajukan',
        'disetujui',
        'ditolak',
    ];

    public function index(Request $request)
    {
        $query = Pinjaman::with('anggota');

        if ($request->filled('cari')) {
            $cari = $request->cari;

            $query->whereHas('anggota', function ($q) use ($cari) {
                $q->where('nama', 'like', "%{$cari}%")
                    ->orWhere('no_anggota', 'like', "%{$cari}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pinjaman = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('pinjaman.index', compact('pinjaman'));
    }

    public function create()
    {
        $anggota = Anggota::orderBy('nama')->get();

        return view('pinjaman.create', compact('anggota'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'anggota_id' => ['required', 'exists:anggota,id'],
            'jumlah_pengajuan' => ['required', 'numeric', 'gt:0'],
            'jumlah_disetujui' => ['nullable', 'numeric', 'gt:0'],
            'bunga_persen' => ['required', 'numeric', 'min:0', 'max:100'],
            'tenor_bulan' => ['required', 'integer', 'min:1', 'max:65535'],
            'status' => [
                'required',
                Rule::in($this->statusPilihan),
            ],
        ]);

        if (
            $validated['status'] === 'disetujui'
            && empty($validated['jumlah_disetujui'])
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'jumlah_disetujui' =>
                        'Jumlah yang disetujui wajib diisi jika status disetujui.',
                ]);
        }

        if (
            isset($validated['jumlah_disetujui'])
            && (float) $validated['jumlah_disetujui'] > (float) $validated['jumlah_pengajuan']
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'jumlah_disetujui' =>
                        'Jumlah yang disetujui tidak boleh melebihi jumlah pengajuan.',
                ]);
        }

        $validated['approved_by'] = $validated['status'] === 'disetujui'
            ? auth()->id()
            : null;

        Pinjaman::create($validated);

        return redirect()
            ->route('pinjaman.index')
            ->with('success', 'Data pinjaman berhasil ditambahkan.');
    }

    public function show(Pinjaman $pinjaman)
    {
        $pinjaman->load(['anggota', 'penyetuju']);

        return view('pinjaman.show', compact('pinjaman'));
    }

    public function edit(Pinjaman $pinjaman)
    {
        $anggota = Anggota::orderBy('nama')->get();

        return view('pinjaman.edit', compact('pinjaman', 'anggota'));
    }

    public function update(Request $request, Pinjaman $pinjaman)
    {
        $validated = $request->validate([
            'anggota_id' => ['required', 'exists:anggota,id'],
            'jumlah_pengajuan' => ['required', 'numeric', 'gt:0'],
            'jumlah_disetujui' => ['nullable', 'numeric', 'gt:0'],
            'bunga_persen' => ['required', 'numeric', 'min:0', 'max:100'],
            'tenor_bulan' => ['required', 'integer', 'min:1', 'max:65535'],
            'status' => [
                'required',
                Rule::in($this->statusPilihan),
            ],
        ]);

        if (
            $validated['status'] === 'disetujui'
            && empty($validated['jumlah_disetujui'])
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'jumlah_disetujui' =>
                        'Jumlah yang disetujui wajib diisi jika status disetujui.',
                ]);
        }

        if (
            isset($validated['jumlah_disetujui'])
            && (float) $validated['jumlah_disetujui'] > (float) $validated['jumlah_pengajuan']
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'jumlah_disetujui' =>
                        'Jumlah yang disetujui tidak boleh melebihi jumlah pengajuan.',
                ]);
        }

        $validated['approved_by'] = $validated['status'] === 'disetujui'
            ? ($pinjaman->status === 'disetujui'
                ? $pinjaman->approved_by
                : auth()->id())
            : null;

        $pinjaman->update($validated);

        return redirect()
            ->route('pinjaman.index')
            ->with('success', 'Data pinjaman berhasil diperbarui.');
    }

    public function destroy(Pinjaman $pinjaman)
    {
        if ($pinjaman->angsuran()->exists()) {
            return redirect()
                ->route('pinjaman.index')
                ->with('error', 'Pinjaman tidak dapat dihapus karena sudah memiliki data angsuran.');
        }

        $pinjaman->delete();

        return redirect()
            ->route('pinjaman.index')
            ->with('success', 'Data pinjaman berhasil dihapus.');
    }
}

