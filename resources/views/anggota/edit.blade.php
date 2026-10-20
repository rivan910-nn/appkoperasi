@extends('layouts.app')

@section('page-title', 'Edit Data Anggota')
@section('page-description', 'Perbarui informasi anggota koperasi.')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form action="{{ route('anggota.update', $anggota) }}" method="POST">
            @csrf
            @method('PUT')
            @include('anggota._form')
        </form>
    </div>
</div>
@endsection
