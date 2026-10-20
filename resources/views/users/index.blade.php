
@extends('layouts.app')

@section('title', 'Manajemen User')

@section('page-title', 'Manajemen User')

@section('page-description', 'Kelola akun pengguna dan hak akses sistem KoperasiKu.')

@section('content')

<style>
    .user-stat {
        border: none;
        border-radius: 16px;
        padding: 22px;
        height: 100%;
        background: #fff;
        box-shadow: 0 4px 18px rgba(30, 41, 59, .05);
    }

    .user-stat-icon {
        width: 46px;
        height: 46px;
        border-radius: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
    }

    .user-stat p {
        margin: 0;
        color: #748094;
        font-size: 13px;
    }

    .user-stat h3 {
        margin: 12px 0 0;
        font-size: 27px;
        font-weight: 750;
        color: #172033;
    }

    .user-panel {
        background: #fff;
        border: 1px solid #edf0f5;
        border-radius: 16px;
        padding: 22px;
        box-shadow: 0 4px 18px rgba(30, 41, 59, .04);
    }

    .user-table {
        margin-bottom: 0;
    }

    .user-table thead th {
        background: #f7f9fc;
        color: #667085;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: .4px;
        white-space: nowrap;
        padding: 15px 12px;
        border-bottom: 1px solid #edf0f5;
    }

    .user-table tbody td {
        padding: 14px 12px;
        vertical-align: middle;
        font-size: 13px;
    }

    .user-table tbody tr:hover {
        background: #fafcff;
    }

    .user-avatar {
        width: 42px;
        height: 42px;
        border-radius: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #e5edff;
        color: #3159b7;
        font-size: 14px;
        font-weight: 750;
        flex-shrink: 0;
    }

    .user-name {
        font-size: 13px;
        font-weight: 700;
        color: #172033;
    }

    .user-subtitle {
        font-size: 11px;
        color: #8791a2;
        margin-top: 3px;
    }

    .user-badge {
        display: inline-block;
        padding: 7px 11px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 650;
        white-space: nowrap;
    }

    .user-active {
        background: #d9f8e7;
        color: #157347;
    }

    .user-inactive {
        background: #ffe1e1;
        color: #b42318;
    }

    .role-admin {
        background: #eee5ff;
        color: #6941c6;
    }

    .role-pengurus {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .role-bendahara {
        background: #fff0d9;
        color: #a15c00;
    }

    .role-anggota {
        background: #e7f5ed;
        color: #247348;
    }

    .user-search {
        min-width: 220px;
    }

    .user-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 34px;
        height: 34px;
        border-radius: 9px;
        text-decoration: none;
    }

    .user-action-detail {
        color: #2563eb;
        background: #eff6ff;
    }

    .user-action-edit {
        color: #a16207;
        background: #fef3c7;
    }

    .user-action-delete {
        color: #dc2626;
        background: #fee2e2;
        border: 0;
    }

    .user-action:hover {
        filter: brightness(.96);
        transform: translateY(-1px);
    }

    .user-filter {
        background: #f8fafc;
        border: 1px solid #e5eaf1;
        border-radius: 12px;
        padding: 14px;
    }

    @media (max-width: 768px) {
        .user-panel {
            padding: 14px;
        }

        .user-search {
            min-width: 0;
        }
    }
</style>

@php
    $totalUser = $users->total();

    $totalAktif = \App\Models\User::where('is_active', true)->count();

    $totalNonaktif = \App\Models\User::where('is_active', false)->count();

    $totalAdmin = \App\Models\User::where('role', 'admin')->count();
@endphp

<div class="container-fluid px-0">

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Kartu statistik --}}
    <div class="row g-3 mb-4">

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card user-stat">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p>Total User</p>
                        <h3>{{ number_format($totalUser, 0, ',', '.') }}</h3>
                    </div>
                    <div class="user-stat-icon"
                         style="background:#dbeafe;color:#1d4ed8;">
                        👥
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card user-stat">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p>User Aktif</p>
                        <h3>{{ number_format($totalAktif, 0, ',', '.') }}</h3>
                    </div>
                    <div class="user-stat-icon"
                         style="background:#dcfce7;color:#15803d;">
                        ✓
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card user-stat">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p>User Nonaktif</p>
                        <h3>{{ number_format($totalNonaktif, 0, ',', '.') }}</h3>
                    </div>
                    <div class="user-stat-icon"
                         style="background:#fee2e2;color:#b91c1c;">
                        ⏸
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card user-stat">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p>Administrator</p>
                        <h3>{{ number_format($totalAdmin, 0, ',', '.') }}</h3>
                    </div>
                    <div class="user-stat-icon"
                         style="background:#eee5ff;color:#6941c6;">
                        🛡️
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Tabel manajemen user --}}
    <div class="user-panel">

        <div class="d-flex flex-column flex-md-row
                    justify-content-between align-items-md-center gap-3 mb-4">

            <div>
                <h5 class="fw-bold mb-1">Daftar Pengguna</h5>
                <p class="text-secondary small mb-0">
                    Kelola informasi akun, role, dan status pengguna.
                </p>
            </div>

            <a href="{{ route('users.create') }}" class="btn btn-primary">
                + Tambah User
            </a>

        </div>

        {{-- Form pencarian dan filter --}}
        <form method="GET"
              action="{{ route('users.index') }}"
              class="user-filter mb-4">

            <div class="row g-3 align-items-end">

                <div class="col-12 col-lg-5">
                    <label class="form-label small fw-semibold">
                        Cari Pengguna
                    </label>

                    <input type="text"
                           name="search"
                           class="form-control user-search"
                           placeholder="Nama atau email pengguna..."
                           value="{{ request('search') }}">
                </div>

                <div class="col-12 col-sm-6 col-lg-3">
                    <label class="form-label small fw-semibold">
                        Filter Role
                    </label>

                    <select name="role" class="form-select">
                        <option value="">Semua Role</option>

                        @foreach(['admin', 'pengurus', 'bendahara', 'anggota'] as $role)
                            <option value="{{ $role }}"
                                @selected(request('role') === $role)>
                                {{ ucfirst($role) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            🔍 Cari
                        </button>

                        <a href="{{ route('users.index') }}"
                           class="btn btn-outline-secondary">
                            Reset
                        </a>
                    </div>
                </div>

            </div>
        </form>

        {{-- Tabel --}}
        <div class="table-responsive">
            <table class="table table-hover user-table align-middle">

                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Pengguna</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($users as $item)
                        @php
                            $nama = trim($item->name ?? '');
                            $inisial = collect(explode(' ', $nama))
                                ->filter()
                                ->take(2)
                                ->map(fn($kata) => mb_strtoupper(mb_substr($kata, 0, 1)))
                                ->implode('');

                            $roleClass = match($item->role) {
                                'admin' => 'role-admin',
                                'pengurus' => 'role-pengurus',
                                'bendahara' => 'role-bendahara',
                                'anggota' => 'role-anggota',
                                default => '',
                            };
                        @endphp

                        <tr>
                            <td>
                                {{ $users->firstItem() + $loop->index }}
                            </td>

                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="user-avatar">
                                        {{ $inisial ?: '?' }}
                                    </div>

                                    <div>
                                        <div class="user-name">
                                            {{ $item->name }}
                                        </div>

                                        <div class="user-subtitle">
                                            ID User: {{ $item->id }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td>{{ $item->email }}</td>

                            <td>
                                <span class="user-badge {{ $roleClass }}">
                                    {{ ucfirst($item->role) }}
                                </span>
                            </td>

                            <td>
                                @if($item->is_active)
                                    <span class="user-badge user-active">
                                        ● Aktif
                                    </span>
                                @else
                                    <span class="user-badge user-inactive">
                                        ● Nonaktif
                                    </span>
                                @endif
                            </td>

                            <td>
                                <div class="d-flex justify-content-center gap-2">

                                    <a href="{{ route('users.show', $item) }}"
                                       class="user-action user-action-detail"
                                       title="Detail pengguna"
                                       aria-label="Detail pengguna">
                                        <icon name="eye" />
                                    </a>

                                    <a href="{{ route('users.edit', $item) }}"
                                       class="user-action user-action-edit"
                                       title="Edit pengguna"
                                       aria-label="Edit pengguna">
                                        <icon name="pencil" />
                                    </a>

                                    @if(auth()->id() !== $item->id)
                                        <form action="{{ route('users.destroy', $item) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="user-action user-action-delete"
                                                    title="Hapus pengguna"
                                                    aria-label="Hapus pengguna">
                                                <icon name="trash-2" />
                                            </button>
                                        </form>
                                    @endif

                                </div>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div style="font-size:40px;">👥</div>

                                <h6 class="fw-bold mt-2">
                                    Data User Belum Tersedia
                                </h6>

                                <p class="text-secondary small mb-3">
                                    Belum ada pengguna yang sesuai dengan pencarian.
                                </p>

                                <a href="{{ route('users.create') }}"
                                   class="btn btn-primary btn-sm">
                                    + Tambah User
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        {{-- Pagination --}}
        <div class="d-flex flex-column flex-md-row
                    justify-content-between align-items-md-center gap-2 mt-4">

            <div class="text-secondary small">
                @if($users->total() > 0)
                    Menampilkan {{ $users->firstItem() }}–{{ $users->lastItem() }}
                    dari {{ $users->total() }} pengguna.
                @else
                    Belum ada pengguna untuk ditampilkan.
                @endif
            </div>

            <div>
                {{ $users->withQueryString()->links() }}
            </div>

        </div>

    </div>

</div>

@endsection
