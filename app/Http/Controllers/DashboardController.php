<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Simpanan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahAnggota = Anggota::count();

        $totalSimpanan = Simpanan::where('status', 'berhasil')
            ->sum('nominal');

        $totalTransaksi = Simpanan::count();

        $transaksiMenunggu = Simpanan::where('status', 'menunggu')
            ->count();

        $transaksiTerbaru = Simpanan::with('anggota')
            ->latest('tanggal_transaksi')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'jumlahAnggota',
            'totalSimpanan',
            'totalTransaksi',
            'transaksiMenunggu',
            'transaksiTerbaru'
        ));
    }
}
