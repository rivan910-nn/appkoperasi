
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Detail Simpanan</h2>

        <div>
            <a href="{{ route('simpanan.edit', $simpanan->id) }}"
               class="btn btn-warning">
                Edit
            </a>

            <a href="{{ route('simpanan.index') }}"
               class="btn btn-secondary">
                Kembali
            </a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header">
            Informasi Transaksi Simpanan
        </div>

        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th width="30%">ID Transaksi</th>
                    <td>{{ $simpanan->id }}</td>
                </tr>

                <tr>
                    <th>Nomor Anggota</th>
                    <td>{{ $simpanan->anggota->no_anggota ?? '-' }}</td>
                </tr>

                <tr>
                    <th>Nama Anggota</th>
                    <td>{{ $simpanan->anggota->nama ?? '-' }}</td>
                </tr>

                <tr>
                    <th>Jenis Simpanan</th>
                    <td>{{ ucfirst($simpanan->jenis) }}</td>
                </tr>

                <tr>
                    <th>Nominal</th>
                    <td>
                        Rp {{ number_format((float) $simpanan->nominal, 2, ',', '.') }}
                    </td>
                </tr>

                <tr>
                    <th>Tanggal Transaksi</th>
                    <td>
                        {{ $simpanan->tanggal_transaksi->format('d-m-Y H:i:s') }}
                    </td>
                </tr>

                <tr>
                    <th>Status</th>
                    <td>{{ ucfirst($simpanan->status) }}</td>
                </tr>

                <tr>
                    <th>Dibuat Oleh</th>
                    <td>{{ $simpanan->pembuat->name ?? 'Tidak diketahui' }}</td>
                </tr>

                <tr>
                    <th>Dibuat Pada</th>
                    <td>{{ $simpanan->created_at->format('d-m-Y H:i:s') }}</td>
                </tr>

                <tr>
                    <th>Diperbarui Pada</th>
                    <td>{{ $simpanan->updated_at->format('d-m-Y H:i:s') }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection
