@extends('layouts.app')

@section('page-title', 'Detail Anggota')
@section('page-description', 'Informasi lengkap anggota koperasi.')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <div class="d-flex flex-column flex-sm-row justify-content-between gap-3 mb-4">
            <div>
                <h5 class="mb-1">{{ $anggota->nama }}</h5>
                <span class="badge {{ $anggota->status === 'aktif' ? 'text-bg-success' : 'text-bg-secondary' }}">{{ ucfirst($anggota->status) }}</span>
            </div>
            <div class="d-flex gap-2 align-items-start">
                <a href="{{ route('anggota.edit', $anggota) }}" class="btn btn-warning">Edit</a>
                <a href="{{ route('anggota.index') }}" class="btn btn-outline-secondary">Kembali</a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table">
                <tr><th style="width: 240px">Nomor Anggota</th><td>{{ $anggota->no_anggota }}</td></tr>
                <tr><th>NIK</th><td>{{ $anggota->nik }}</td></tr>
                <tr><th>Nama Lengkap</th><td>{{ $anggota->nama }}</td></tr>
                <tr><th>Jenis Kelamin</th><td>{{ $anggota->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</td></tr>
                <tr><th>Tempat, Tanggal Lahir</th><td>{{ $anggota->tempat_lahir ?: '-' }}, {{ $anggota->tanggal_lahir?->format('d-m-Y') ?? '-' }}</td></tr>
                <tr><th>Alamat</th><td>{{ $anggota->alamat }}</td></tr>
                <tr><th>Nomor HP</th><td>{{ $anggota->no_hp }}</td></tr>
                <tr><th>Email</th><td>{{ $anggota->email ?: '-' }}</td></tr>
                <tr><th>Tanggal Bergabung</th><td>{{ $anggota->tanggal_bergabung?->format('d-m-Y') ?? '-' }}</td></tr>
                <tr><th>Dibuat</th><td>{{ $anggota->created_at?->format('d-m-Y H:i') ?? '-' }}</td></tr>
                <tr><th>Terakhir Diperbarui</th><td>{{ $anggota->updated_at?->format('d-m-Y H:i') ?? '-' }}</td></tr>
            </table>
        </div>
    </div>
</div>
@endsection
