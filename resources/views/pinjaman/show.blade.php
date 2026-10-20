
@extends('layouts.app')

@section('title', 'Detail Pinjaman')
@section('page-title', 'Detail Pinjaman')
@section('page-description', 'Informasi lengkap pengajuan pinjaman anggota.')

@section('content')
<div class="container-fluid px-0">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Detail Pinjaman #{{ $pinjaman->id }}</h5>

            @if ($pinjaman->status === 'disetujui')
                <span class="badge bg-success">Disetujui</span>
            @elseif ($pinjaman->status === 'ditolak')
                <span class="badge bg-danger">Ditolak</span>
            @else
                <span class="badge bg-warning text-dark">Diajukan</span>
            @endif
        </div>

        <div class="card-body">
            <div class="row g-4">
                <div class="col-md-6">
                    <label class="text-muted small">Nomor Anggota</label>
                    <div class="fw-semibold">
                        {{ $pinjaman->anggota?->no_anggota ?? '-' }}
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="text-muted small">Nama Anggota</label>
                    <div class="fw-semibold">
                        {{ $pinjaman->anggota?->nama ?? 'Anggota tidak tersedia' }}
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="text-muted small">Jumlah Pengajuan</label>
                    <div class="fw-semibold">
                        Rp {{ number_format((float) $pinjaman->jumlah_pengajuan, 0, ',', '.') }}
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="text-muted small">Jumlah Disetujui</label>
                    <div class="fw-semibold">
                        @if ($pinjaman->jumlah_disetujui !== null)
                            Rp {{ number_format((float) $pinjaman->jumlah_disetujui, 0, ',', '.') }}
                        @else
                            Belum ditentukan
                        @endif
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="text-muted small">Bunga</label>
                    <div class="fw-semibold">
                        {{ number_format((float) $pinjaman->bunga_persen, 2, ',', '.') }}%
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="text-muted small">Tenor</label>
                    <div class="fw-semibold">{{ $pinjaman->tenor_bulan }} bulan</div>
                </div>

                <div class="col-md-6">
                    <label class="text-muted small">Disetujui Oleh</label>
                    <div class="fw-semibold">
                        {{ $pinjaman->penyetuju?->name ?? '-' }}
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="text-muted small">Tanggal Pengajuan</label>
                    <div class="fw-semibold">
                        {{ $pinjaman->created_at?->format('d-m-Y H:i') ?? '-' }}
                    </div>
                </div>
            </div>

            <hr>

            <div class="d-flex gap-2">
                <a href="{{ route('pinjaman.edit', $pinjaman->id) }}"
                   class="btn btn-warning">
                    <i class="bi bi-pencil"></i> Edit
                </a>

                <a href="{{ route('pinjaman.index') }}" class="btn btn-secondary">
                    Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
