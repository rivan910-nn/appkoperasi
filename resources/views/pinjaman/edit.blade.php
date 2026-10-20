
@extends('layouts.app')

@section('title', 'Edit Pinjaman')
@section('page-title', 'Edit Pinjaman')
@section('page-description', 'Perbarui data pengajuan dan persetujuan pinjaman.')

@section('content')
<div class="container-fluid px-0">
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ route('pinjaman.update', $pinjaman->id) }}" method="POST">
                @csrf
                @method('PUT')
                @include('pinjaman._form')
            </form>
        </div>
    </div>
</div>
@endsection
