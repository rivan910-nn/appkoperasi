
@extends('layouts.app')

@section('title', 'Tambah Pinjaman')
@section('page-title', 'Tambah Pinjaman')
@section('page-description', 'Tambahkan pengajuan pinjaman anggota koperasi.')

@section('content')
<div class="container-fluid px-0">
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ route('pinjaman.store') }}" method="POST">
                @csrf
                @include('pinjaman._form')
            </form>
        </div>
    </div>
</div>
@endsection
