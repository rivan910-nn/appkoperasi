
@extends('layouts.app')

@section('title', 'Data Pinjaman')
@section('page-title', 'Data Pinjaman')
@section('page-description', 'Kelola pengajuan dan persetujuan pinjaman anggota koperasi.')

@section('content')
<div class="container-fluid px-0">

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <form action="{{ route('pinjaman.index') }}" method="GET" class="row g-2 mb-4">
                <div class="col-md-6">
                    <input type="text"
                           name="cari"
                           class="form-control"
                           placeholder="Cari nama atau nomor anggota..."
                           value="{{ request('cari') }}">
                </div>

                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="diajukan" @selected(request('status') === 'diajukan')>
                            Diajukan
                        </option>
                        <option value="disetujui" @selected(request('status') === 'disetujui')>
                            Disetujui
                        </option>
                        <option value="ditolak" @selected(request('status') === 'ditolak')>
                            Ditolak
                        </option>
                    </select>
                </div>

                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search"></i> Cari
                    </button>
                    <a href="{{ route('pinjaman.index') }}" class="btn btn-outline-secondary">
                        Reset
                    </a>
                </div>
            </form>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Daftar Pinjaman</h5>
                <a href="{{ route('pinjaman.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg"></i> Tambah Pinjaman
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No.</th>
                            <th>Anggota</th>
                            <th>Jumlah Pengajuan</th>
                            <th>Jumlah Disetujui</th>
                            <th>Bunga</th>
                            <th>Tenor</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pinjaman as $item)
                            <tr>
                                <td>{{ $pinjaman->firstItem() + $loop->index }}</td>
                                <td>
                                    <div class="fw-semibold">
                                        {{ $item->anggota?->nama ?? 'Anggota tidak tersedia' }}
                                    </div>
                                    <small class="text-muted">
                                        {{ $item->anggota?->no_anggota ?? '-' }}
                                    </small>
                                </td>
                                <td>
                                    Rp {{ number_format((float) $item->jumlah_pengajuan, 0, ',', '.') }}
                                </td>
                                <td>
                                    @if ($item->jumlah_disetujui !== null)
                                        Rp {{ number_format((float) $item->jumlah_disetujui, 0, ',', '.') }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ number_format((float) $item->bunga_persen, 2, ',', '.') }}%</td>
                                <td>{{ $item->tenor_bulan }} bulan</td>
                                <td>
                                    @if ($item->status === 'disetujui')
                                        <span class="badge bg-success">Disetujui</span>
                                    @elseif ($item->status === 'ditolak')
                                        <span class="badge bg-danger">Ditolak</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Diajukan</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('pinjaman.show', $item->id) }}"
                                           class="btn btn-sm btn-outline-info" title="Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <a href="{{ route('pinjaman.edit', $item->id) }}"
                                           class="btn btn-sm btn-outline-warning" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        <form action="{{ route('pinjaman.destroy', $item->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus pinjaman ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-sm btn-outline-danger"
                                                    title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">
                                    Belum ada data pinjaman.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3">
                <small class="text-muted">
                    Menampilkan {{ $pinjaman->firstItem() ?? 0 }}
                    sampai {{ $pinjaman->lastItem() ?? 0 }}
                    dari {{ $pinjaman->total() }} data
                </small>
                {{ $pinjaman->links() }}
            </div>

        </div>
    </div>
</div>
@endsection
