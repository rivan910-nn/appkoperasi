
@extends('layouts.app')

@section('title', 'Detail Angsuran')
@section('page-title', 'Detail Angsuran')
@section('page-description', 'Informasi lengkap pembayaran angsuran pinjaman.')

@section('content')
<div class="container-fluid px-0">

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Informasi Angsuran</h5>
            <span class="badge
                {{ $angsuran->status === 'dibayar' ? 'bg-success' :
                    ($angsuran->status === 'terlambat' ? 'bg-danger' : 'bg-warning text-dark') }}">
                {{ ucwords(str_replace('_', ' ', $angsuran->status)) }}
            </span>
        </div>

        <div class="card-body">
            <div class="row g-4">
                <div class="col-md-6">
                    <label class="text-muted small">ID Angsuran</label>
                    <div class="fw-semibold">{{ $angsuran->id }}</div>
                </div>

                <div class="col-md-6">
                    <label class="text-muted small">Nomor Pinjaman</label>
                    <div class="fw-semibold">Pinjaman #{{ $angsuran->pinjaman_id }}</div>
                </div>

                <div class="col-md-6">
                    <label class="text-muted small">Nama Anggota</label>
                    <div class="fw-semibold">
                        {{ $angsuran->pinjaman?->anggota?->nama ?? 'Anggota tidak tersedia' }}
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="text-muted small">Angsuran Ke</label>
                    <div class="fw-semibold">{{ $angsuran->angsuran_ke }}</div>
                </div>

                <div class="col-md-6">
                    <label class="text-muted small">Tanggal Jatuh Tempo</label>
                    <div class="fw-semibold">
                        {{ $angsuran->jatuh_tempo?->format('d-m-Y') }}
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="text-muted small">Tanggal Bayar</label>
                    <div class="fw-semibold">
                        {{ $angsuran->tanggal_bayar?->format('d-m-Y') ?? '-' }}
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="text-muted small">Jumlah Tagihan</label>
                    <div class="fw-semibold">
                        Rp {{ number_format((float) $angsuran->jumlah_tagihan, 0, ',', '.') }}
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="text-muted small">Jumlah Bayar</label>
                    <div class="fw-semibold">
                        Rp {{ number_format((float) $angsuran->jumlah_bayar, 0, ',', '.') }}
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="text-muted small">Sisa Tagihan</label>
                    <div class="fw-semibold">
                        Rp {{ number_format(
                            max(0, (float) $angsuran->jumlah_tagihan - (float) $angsuran->jumlah_bayar),
                            0, ',', '.'
                        ) }}
                    </div>
                </div>
            </div>

            <hr>

            <div class="d-flex gap-2">
                <a href="{{ route('angsuran.edit', $angsuran->id) }}"
                   class="btn btn-warning">
                    <i class="bi bi-pencil"></i> Edit
                </a>

                <a href="{{ route('angsuran.index') }}" class="btn btn-secondary">
                    Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
