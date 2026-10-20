@extends('layouts.app')

@section('page-title', 'Data Anggota')
@section('page-description', 'Kelola data anggota koperasi.')

@section('content')
<div class="container-fluid px-0">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="d-flex flex-column flex-md-row justify-content-between gap-3 mb-4">
                <form action="{{ route('anggota.index') }}" method="GET" class="d-flex flex-column flex-sm-row gap-2">
                    <input type="search" name="cari" value="{{ request('cari') }}" class="form-control"
                           placeholder="Cari nama, nomor anggota, NIK..." aria-label="Cari anggota">
                    <select name="status" class="form-select" aria-label="Filter status">
                        <option value="">Semua status</option>
                        <option value="aktif" @selected(request('status') === 'aktif')>Aktif</option>
                        <option value="nonaktif" @selected(request('status') === 'nonaktif')>Nonaktif</option>
                    </select>
                    <button class="btn btn-outline-primary" type="submit">Cari</button>
                    <a href="{{ route('anggota.index') }}" class="btn btn-outline-secondary">Reset</a>
                </form>
                <a href="{{ route('anggota.create') }}" class="btn btn-primary text-nowrap">+ Tambah Anggota</a>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No.</th>
                            <th>Nomor Anggota</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Jenis Kelamin</th>
                            <th>No. HP</th>
                            <th>Tanggal Bergabung</th>
                            <th>Status</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse ($anggota as $item)
                        <tr>
                            <td>{{ $anggota->firstItem() + $loop->index }}</td>
                            <td class="fw-semibold">{{ $item->no_anggota }}</td>
                            <td>{{ $item->nik }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                            <td>{{ $item->no_hp }}</td>
                            <td>{{ $item->tanggal_bergabung?->format('d-m-Y') ?? '-' }}</td>
                            <td>
                                <span class="badge {{ $item->status === 'aktif' ? 'text-bg-success' : 'text-bg-secondary' }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex justify-content-end gap-1">
                                    <a href="{{ route('anggota.show', $item) }}" class="btn btn-sm btn-outline-info">Detail</a>
                                    <a href="{{ route('anggota.edit', $item) }}" class="btn btn-sm btn-outline-warning">Edit</a>
                                    <form action="{{ route('anggota.destroy', $item) }}" method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus data anggota ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="9" class="text-center text-muted py-4">Belum ada data anggota.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2 mt-3">
                <small class="text-muted">Menampilkan {{ $anggota->firstItem() ?? 0 }}–{{ $anggota->lastItem() ?? 0 }} dari {{ $anggota->total() }} anggota</small>
                {{ $anggota->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
