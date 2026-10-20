@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-description', 'Ringkasan informasi dan aktivitas KoperasiKu.')

@section('content')
@php
    /*
     * Variabel berikut boleh dikirim dari controller agar angka dashboard
     * menggunakan data asli. Jika belum dikirim, nilai default adalah 0.
     */
    $jumlahAnggota = $jumlahAnggota ?? 0;
    $totalSimpanan = $totalSimpanan ?? 0;
    $totalTransaksi = $totalTransaksi ?? 0;
    $transaksiMenunggu = $transaksiMenunggu ?? 0;
    $totalAngsuran = $totalAngsuran ?? 0;
    $angsuranMenunggu = $angsuranMenunggu ?? 0;
    $transaksiTerbaru = $transaksiTerbaru ?? collect();
@endphp

<style>
    .dashboard-welcome {
        padding: 24px;
        border-radius: 18px;
        color: #fff;
        background: linear-gradient(120deg, #17478d, #2563eb);
        box-shadow: 0 10px 28px rgba(37, 99, 235, .13);
    }
    .dashboard-welcome h3 { font-weight: 750; }
    .dashboard-welcome p { color: rgba(255,255,255,.82); margin-bottom: 0; }
    .dashboard-stat {
        height: 100%;
        padding: 22px;
        border: 1px solid #edf0f5;
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 6px 22px rgba(31, 50, 81, .045);
    }
    .stat-label { color: #718096; font-size: 14px; }
    .stat-value { color: #172b4d; font-size: clamp(22px, 2vw, 29px); font-weight: 750; }
    .stat-icon {
        display: flex; align-items: center; justify-content: center;
        width: 48px; height: 48px; border-radius: 14px; font-size: 23px;
    }
    .icon-blue { background: #e0ecff; }
    .icon-green { background: #dcfce7; }
    .icon-yellow { background: #fef3c7; }
    .icon-purple { background: #f0e7ff; }
    .dashboard-panel {
        height: 100%; padding: 22px; border: 1px solid #edf0f5;
        border-radius: 16px; background: #fff;
        box-shadow: 0 6px 22px rgba(31, 50, 81, .045);
    }
    .quick-link {
        display: flex; align-items: center; gap: 12px; padding: 14px;
        border: 1px solid #e9eef6; border-radius: 12px; color: #263449;
        text-decoration: none; transition: .2s ease;
    }
    .quick-link:hover { border-color: #93b4f8; background: #f7faff; transform: translateY(-1px); }
    .quick-link-icon {
        display: flex; align-items: center; justify-content: center;
        width: 42px; height: 42px; flex-shrink: 0; border-radius: 11px;
        background: #e8f0ff; color: #2059c8; font-size: 20px;
    }
    .dashboard-table th { color: #6b7b91; background: #f7f9fc; font-size: 12px; text-transform: uppercase; white-space: nowrap; }
    .dashboard-table td { vertical-align: middle; }
    .empty-state { padding: 28px 12px; color: #778399; text-align: center; }
</style>

<div class="dashboard-welcome mb-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <div>
            <h3 class="mb-2">Selamat datang, {{ auth()->user()->name ?? 'Pengguna' }}! 👋</h3>
            <p>Pantau data anggota, simpanan, dan angsuran koperasi dari satu halaman.</p>
        </div>
        <div class="small text-white-50">
            {{ now()->translatedFormat('l, d F Y') }}
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="dashboard-stat">
            <div class="d-flex justify-content-between align-items-start gap-2">
                <div>
                    <div class="stat-label mb-2">Total Anggota</div>
                    <div class="stat-value">{{ number_format($jumlahAnggota, 0, ',', '.') }}</div>
                </div>
                <div class="stat-icon icon-blue">♙</div>
            </div>
            <div class="small text-muted mt-3">Jumlah anggota terdaftar</div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="dashboard-stat">
            <div class="d-flex justify-content-between align-items-start gap-2">
                <div>
                    <div class="stat-label mb-2">Total Simpanan Berhasil</div>
                    <div class="stat-value">Rp {{ number_format($totalSimpanan, 0, ',', '.') }}</div>
                </div>
                <div class="stat-icon icon-green">💰</div>
            </div>
            <div class="small text-muted mt-3">Akumulasi transaksi berhasil</div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="dashboard-stat">
            <div class="d-flex justify-content-between align-items-start gap-2">
                <div>
                    <div class="stat-label mb-2">Total Transaksi</div>
                    <div class="stat-value">{{ number_format($totalTransaksi, 0, ',', '.') }}</div>
                </div>
                <div class="stat-icon icon-purple">▤</div>
            </div>
            <div class="small text-muted mt-3">Seluruh transaksi simpanan</div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="dashboard-stat">
            <div class="d-flex justify-content-between align-items-start gap-2">
                <div>
                    <div class="stat-label mb-2">Transaksi Menunggu</div>
                    <div class="stat-value">{{ number_format($transaksiMenunggu, 0, ',', '.') }}</div>
                </div>
                <div class="stat-icon icon-yellow">⌛</div>
            </div>
            <div class="small text-muted mt-3">Perlu ditinjau atau diproses</div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-12 col-lg-7">
        <section class="dashboard-panel">
            <div class="d-flex justify-content-between align-items-center gap-2 mb-3">
                <div>
                    <h5 class="fw-bold mb-1">Akses Cepat</h5>
                    <p class="text-muted small mb-0">Pilih menu untuk melanjutkan pekerjaan.</p>
                </div>
            </div>
            <div class="row g-3">
                <div class="col-12 col-md-6">
                    <a class="quick-link" href="{{ route('anggota.index') }}">
                        <span class="quick-link-icon">♙</span>
                        <span><strong class="d-block">Data Anggota</strong><small class="text-muted">Lihat dan kelola anggota</small></span>
                    </a>
                </div>
                <div class="col-12 col-md-6">
                    <a class="quick-link" href="{{ route('simpanan.index') }}">
                        <span class="quick-link-icon">▤</span>
                        <span><strong class="d-block">Simpanan</strong><small class="text-muted">Pantau transaksi simpanan</small></span>
                    </a>
                </div>
                <div class="col-12 col-md-6">
                    @if(\Illuminate\Support\Facades\Route::has('angsuran.index'))
                        <a class="quick-link" href="{{ route('angsuran.index') }}">
                    @else
                        <a class="quick-link" href="{{ url('/angsuran') }}">
                    @endif
                        <span class="quick-link-icon">▣</span>
                        <span><strong class="d-block">Angsuran</strong><small class="text-muted">Kelola angsuran pinjaman</small></span>
                    </a>
                </div>
                @if(auth()->check() && auth()->user()->role === 'admin' && \Illuminate\Support\Facades\Route::has('users.index'))
                    <div class="col-12 col-md-6">
                        <a class="quick-link" href="{{ route('users.index') }}">
                            <span class="quick-link-icon">⚙</span>
                            <span><strong class="d-block">Manajemen User</strong><small class="text-muted">Kelola akun pengguna</small></span>
                        </a>
                    </div>
                @endif
            </div>
        </section>
    </div>

    <div class="col-12 col-lg-5">
        <section class="dashboard-panel">
            <h5 class="fw-bold mb-1">Ringkasan Angsuran</h5>
            <p class="text-muted small mb-3">Informasi angsuran yang dikirim dari controller.</p>
            <div class="d-flex justify-content-between align-items-center p-3 rounded-3 mb-3" style="background:#f7f9fc;">
                <span class="text-muted">Total angsuran</span>
                <strong class="fs-5">{{ number_format($totalAngsuran, 0, ',', '.') }}</strong>
            </div>
            <div class="d-flex justify-content-between align-items-center p-3 rounded-3" style="background:#fff8e5;">
                <span class="text-muted">Angsuran menunggu</span>
                <strong class="fs-5">{{ number_format($angsuranMenunggu, 0, ',', '.') }}</strong>
            </div>
            <small class="text-muted d-block mt-3">Angka akan mengikuti data asli setelah controller mengirimkan variabelnya.</small>
        </section>
    </div>
</div>

<section class="dashboard-panel">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 mb-3">
        <div>
            <h5 class="fw-bold mb-1">Transaksi Simpanan Terbaru</h5>
            <p class="text-muted small mb-0">Daftar transaksi terbaru yang tersedia.</p>
        </div>
        <a href="{{ route('simpanan.index') }}" class="btn btn-outline-primary btn-sm">Lihat Semua</a>
    </div>

    <div class="table-responsive">
        <table class="table dashboard-table align-middle mb-0">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Anggota</th>
                    <th>Jenis Simpanan</th>
                    <th>Nominal</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksiTerbaru as $transaksi)
                    <tr>
                        <td>
                            @if(!empty($transaksi->tanggal_transaksi))
                                {{ \Illuminate\Support\Carbon::parse($transaksi->tanggal_transaksi)->format('d/m/Y') }}
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $transaksi->anggota->nama ?? '-' }}</td>
                        <td>{{ $transaksi->jenis_simpanan ?? '-' }}</td>
                        <td>Rp {{ number_format((float) ($transaksi->nominal ?? 0), 0, ',', '.') }}</td>
                        <td>
                            @php $status = strtolower($transaksi->status ?? 'menunggu'); @endphp
                            <span class="badge rounded-pill {{ $status === 'berhasil' ? 'text-bg-success' : ($status === 'menunggu' ? 'text-bg-warning' : 'text-bg-secondary') }}">
                                {{ ucfirst($status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty-state">
                            Belum ada transaksi untuk ditampilkan.
                            <div class="mt-2"><a href="{{ route('simpanan.index') }}">Buka halaman Simpanan</a></div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
