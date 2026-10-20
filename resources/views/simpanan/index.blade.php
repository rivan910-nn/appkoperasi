
@extends('layouts.app')

@section('title', 'Data Simpanan')
@section('page-title', 'Data Simpanan')
@section('page-description', 'Kelola dan pantau transaksi simpanan anggota koperasi.')

@section('content')

<style>
    .simpanan-stat {
        border: none;
        border-radius: 16px;
        padding: 22px;
        height: 100%;
        box-shadow: 0 4px 18px rgba(30, 41, 59, .05);
    }

    .simpanan-stat-icon {
        width: 46px;
        height: 46px;
        border-radius: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
    }

    .simpanan-stat h3 {
        font-size: 25px;
        font-weight: 750;
        margin: 15px 0 4px;
        color: #172033;
    }

    .simpanan-stat p {
        margin: 0;
        font-size: 13px;
        color: #748094;
    }

    .simpanan-panel {
        background: #fff;
        border-radius: 16px;
        padding: 22px;
        border: 1px solid #edf0f5;
        box-shadow: 0 4px 18px rgba(30, 41, 59, .04);
    }

    .simpanan-table th {
        background: #f7f9fc;
        color: #667085;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: .4px;
        padding: 15px 12px;
        white-space: nowrap;
    }

    .simpanan-table td {
        padding: 15px 12px;
        vertical-align: middle;
        font-size: 13px;
    }

    .simpanan-badge {
        padding: 7px 11px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 650;
        display: inline-block;
    }

    .badge-menunggu {
        background: #fff4d6;
        color: #946200;
    }

    .badge-disetujui {
        background: #d9f8e7;
        color: #157347;
    }

    .badge-ditolak {
        background: #ffe1e1;
        color: #b42318;
    }

    .simpanan-search {
        max-width: 350px;
    }

    .simpanan-table tbody tr:hover {
        background: #fafcff;
    }

    .simpanan-nama {
        font-weight: 650;
        color: #172033;
    }

    .simpanan-sub {
        font-size: 11px;
        color: #8791a2;
        margin-top: 3px;
    }

    @media (max-width: 768px) {
        .simpanan-panel {
            padding: 14px;
        }

        .simpanan-search {
            max-width: 100%;
            width: 100%;
        }
    }
</style>

<div class="container-fluid px-0">

    {{-- Notifikasi --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close"
                    data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close"
                    data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Data belum berhasil diproses.</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Ringkasan --}}
    <div class="row g-3 mb-4">

        <div class="col-12 col-md-4">
            <div class="card simpanan-stat">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p>Total Simpanan Disetujui</p>
                        <h3>
                            Rp {{ number_format((float) $totalSimpanan, 0, ',', '.') }}
                        </h3>
                    </div>
                    <div class="simpanan-stat-icon"
                         style="background:#dcfce7;color:#15803d;">
                        💰
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card simpanan-stat">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p>Total Transaksi</p>
                        <h3>{{ number_format($totalTransaksi, 0, ',', '.') }}</h3>
                    </div>
                    <div class="simpanan-stat-icon"
                         style="background:#dbeafe;color:#1d4ed8;">
                        📋
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card simpanan-stat">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p>Transaksi Menunggu</p>
                        <h3>{{ number_format($totalMenunggu, 0, ',', '.') }}</h3>
                    </div>
                    <div class="simpanan-stat-icon"
                         style="background:#fef3c7;color:#b45309;">
                        ⏳
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Daftar transaksi --}}
    <div class="simpanan-panel">

        <div class="d-flex flex-column flex-md-row
                    justify-content-between align-items-md-center gap-3 mb-4">
            <div>
                <h5 class="fw-bold mb-1">Daftar Transaksi Simpanan</h5>
                <p class="text-secondary small mb-0">
                    Informasi simpanan pokok, wajib, dan sukarela anggota.
                </p>
            </div>

            <a href="{{ route('simpanan.create') }}" class="btn btn-primary">
                + Tambah Simpanan
            </a>
        </div>

        {{-- Pencarian --}}
        <div class="mb-3">
            <input type="text"
                   id="cariSimpanan"
                   class="form-control simpanan-search"
                   placeholder="Cari nama, nomor anggota, atau jenis...">
        </div>

        <div class="table-responsive">
            <table class="table simpanan-table align-middle mb-0"
                   id="tabelSimpanan">

                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Anggota</th>
                        <th>Jenis Simpanan</th>
                        <th>Nominal</th>
                        <th>Tanggal Transaksi</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($simpanan as $item)
                        @php
                            $status = strtolower($item->status ?? 'menunggu');

                            $jenisLabel = [
                                'pokok' => 'Simpanan Pokok',
                                'wajib' => 'Simpanan Wajib',
                                'sukarela' => 'Simpanan Sukarela',
                            ];

                            $badgeClass = match ($status) {
                                'disetujui' => 'badge-disetujui',
                                'ditolak' => 'badge-ditolak',
                                default => 'badge-menunggu',
                            };
                        @endphp

                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>
                                <div class="simpanan-nama">
                                    {{ $item->anggota->nama ?? 'Anggota tidak ditemukan' }}
                                </div>
                                <div class="simpanan-sub">
                                    {{ $item->anggota->no_anggota ?? '-' }}
                                </div>
                            </td>

                            <td>
                                {{ $jenisLabel[$item->jenis] ?? ucfirst($item->jenis) }}
                            </td>

                            <td class="fw-bold text-nowrap">
                                Rp {{ number_format((float) $item->nominal, 0, ',', '.') }}
                            </td>

                            <td class="text-nowrap">
                                {{ $item->tanggal_transaksi?->format('d/m/Y H:i') ?? '-' }}
                            </td>

                            <td>
                                <span class="simpanan-badge {{ $badgeClass }}">
                                    {{ ucfirst($status) }}
                                </span>
                            </td>

                            <td>
                                <div class="d-flex justify-content-center
                                            align-items-center gap-2 flex-wrap">

                                    {{-- Detail --}}
                                    <a href="{{ route('simpanan.show', $item) }}"
                                       class="btn btn-sm btn-outline-info"
                                       title="Detail"
                                       aria-label="Detail simpanan">
                                        👁️
                                    </a>

                                    {{-- Edit hanya untuk transaksi yang belum disetujui --}}
                                    @if (in_array($status, ['menunggu', 'ditolak']))
                                        <a href="{{ route('simpanan.edit', $item) }}"
                                           class="btn btn-sm btn-outline-primary"
                                           title="Edit"
                                           aria-label="Edit simpanan">
                                            ✏️
                                        </a>
                                    @endif

                                    {{-- Hapus hanya untuk transaksi yang belum disetujui --}}
                                    @if ($status !== 'disetujui')
                                        <form action="{{ route('simpanan.destroy', $item) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="btn btn-sm btn-outline-danger"
                                                    title="Hapus"
                                                    aria-label="Hapus simpanan">
                                                🗑️
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-success small">
                                            ✓ Disetujui
                                        </span>
                                    @endif

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr id="barisKosong">
                            <td colspan="7" class="text-center py-5">
                                <div style="font-size:40px;">💳</div>
                                <h6 class="fw-bold mt-2">Belum Ada Transaksi</h6>
                                <p class="text-secondary small mb-3">
                                    Data transaksi simpanan akan muncul di sini.
                                </p>
                                <a href="{{ route('simpanan.create') }}"
                                   class="btn btn-primary btn-sm">
                                    Tambah Simpanan Pertama
                                </a>
                            </td>
                        </tr>
                    @endforelse

                    <tr id="hasilTidakDitemukan" style="display:none;">
                        <td colspan="7" class="text-center text-secondary py-4">
                            Data simpanan yang dicari tidak ditemukan.
                        </td>
                    </tr>
                </tbody>

            </table>
        </div>

        <div class="mt-3 text-secondary small" id="jumlahTransaksi">
            Menampilkan {{ $simpanan->count() }} transaksi simpanan.
        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('cariSimpanan');
    const tabel = document.getElementById('tabelSimpanan');
    const hasilTidakDitemukan = document.getElementById('hasilTidakDitemukan');
    const jumlahTransaksi = document.getElementById('jumlahTransaksi');
    const barisKosong = document.getElementById('barisKosong');

    if (!input || !tabel) return;

    input.addEventListener('input', function () {
        const kataKunci = this.value.toLowerCase().trim();

        const baris = tabel.querySelectorAll(
            'tbody tr:not(#hasilTidakDitemukan):not(#barisKosong)'
        );

        let jumlahTampil = 0;

        baris.forEach(function (tr) {
            const cocok = tr.textContent.toLowerCase().includes(kataKunci);

            tr.style.display = cocok ? '' : 'none';

            if (cocok) {
                jumlahTampil++;
            }
        });

        if (hasilTidakDitemukan) {
            hasilTidakDitemukan.style.display =
                (baris.length > 0 && jumlahTampil === 0) ? '' : 'none';
        }

        if (barisKosong && baris.length > 0) {
            barisKosong.style.display = 'none';
        } else if (barisKosong) {
            barisKosong.style.display = '';
        }

        if (jumlahTransaksi) {
            jumlahTransaksi.textContent =
                'Menampilkan ' + jumlahTampil + ' transaksi simpanan.';
        }
    });
});
</script>

@endsection
