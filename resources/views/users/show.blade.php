
@extends('layouts.app')

@section('title', 'Detail User')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Detail User</h3>
        <a href="{{ route('users.index') }}"
            class="btn btn-outline-secondary">Kembali</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            Informasi Akun
        </div>

        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>Nama</th>
                    <td>{{ $user->name }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $user->email }}</td>
                </tr>
                <tr>
                    <th>Role</th>
                    <td>{{ ucfirst($user->role) }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{ $user->is_active ? 'Aktif' : 'Nonaktif' }}</td>
                </tr>
                <tr>
                    <th>Dibuat</th>
                    <td>{{ $user->created_at?->format('d-m-Y H:i') }}</td>
                </tr>
                <tr>
                    <th>Terakhir diperbarui</th>
                    <td>{{ $user->updated_at?->format('d-m-Y H:i') }}</td>
                </tr>
            </table>

            <a href="{{ route('users.edit', $user) }}"
                class="btn btn-warning">Edit User</a>
        </div>
    </div>
</div>
@endsection
