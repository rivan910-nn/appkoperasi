
@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')
<div class="container py-4">
    <h3 class="mb-1">Tambah User</h3>
    <p class="text-muted">Buat akun untuk petugas atau anggota koperasi.</p>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                @include('users._form')
            </form>
        </div>
    </div>
</div>
@endsection
