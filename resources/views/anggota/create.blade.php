@extends('layouts.app')

@section('page-title', 'Tambah Anggota')
@section('page-description', 'Masukkan informasi anggota baru koperasi.')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form action="{{ route('anggota.store') }}" method="POST">
            @csrf
            @include('anggota._form')
        </form>
    </div>
</div>
@endsection
