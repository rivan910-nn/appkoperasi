
@extends('layouts.app')

@section('title', 'Data Angsuran')
@section('page-title', 'Data Angsuran')
@section('page-description', 'Kelola data angsuran pinjaman anggota koperasi.')

@section('content')
<div class="container-fluid px-0">

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <form action="{{ route('angsuran.index') }}" method="GET" class="row g-2 mb-4">
                <div class="col-md-6">
                    <input type="text"
                           name="cari"
                           class="form-control"
                           placeholder="Cari nomor pinjaman, anggota, atau angsuran..."
                           value="{{ request('cari') }}">
                </div>

                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="belum_bayar" @selected(request('status') == 'belum_bayar')>
                            Belum Bayar
                        </option>
                        <option value="dibayar" @selected(request('status') == 'dibayar')>
                            Dibayar
                        </option>
                        <option value="terlambat" @selected(request('status') == 'terlambat')>
                            Terlambat
                        </option>
                    </select>
                </div>

                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search"></i> Cari
                    </button>
                    <a href="{{ route('angsuran.index') }}" class="btn btn-outline-secondary">
                        Reset
                    </a>
                </div>
            </form>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Daftar Angsuran</h5>
                <a href="{{ route('angsuran.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg"></i> Tambah Angsuran
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No.</th>
                            <th>Pinjaman</th>
                            <th>Angsuran Ke</th>
                            <th>Jatuh Tempo</th>
                            <th>Jumlah Tagihan</th>
                            <th>Jumlah Bayar</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($angsuran as $item)
                            <tr>
                                <td>{{ $angsuran->firstItem() + $loop->index }}</td>
                                <td>
                                    <div class="fw-semibold">
                                        Pinjaman #{{ $item->pinjaman_id }}
                                    </div>
                                    <small class="text-muted">
                                        {{ $item->pinjaman?->anggota?->nama ?? 'Anggota tidak tersedia' }}
                                    </small>
                                </td>
                                <td>{{ $item->angsuran_ke }}</td>
                                <td>{{ $item->jatuh_tempo?->format('d-m-Y') }}</td>
                                <td>Rp {{ number_format((float) $item->jumlah_tagihan, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format((float) $item->jumlah_bayar, 0, ',', '.') }}</td>
                                <td>
                                    @if ($item->status === 'dibayar')
                                        <span class="badge bg-success">Dibayar</span>
                                    @elseif ($item->status === 'terlambat')
                                        <span class="badge bg-danger">Terlambat</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Belum Bayar</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('angsuran.show', $item->id) }}"
                                           class="btn btn-sm btn-outline-info"
                                           title="Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <a href="{{ route('angsuran.edit', $item->id) }}"
                                           class="btn btn-sm btn-outline-warning"
                                           title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        <form action="{{ route('angsuran.destroy', $item->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus data angsuran ini?')">
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
                                    Belum ada data angsuran.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3">
                <small class="text-muted">
                    Menampilkan {{ $angsuran->firstItem() ?? 0 }}
                    sampai {{ $angsuran->lastItem() ?? 0 }}
                    dari {{ $angsuran->total() }} data
                </small>
                {{ $angsuran->links() }}
            </div>

        </div>
    </div>
</div>
@endsection
