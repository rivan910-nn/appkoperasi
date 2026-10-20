
@extends('layouts.app')

@section('title', 'Tambah Angsuran')
@section('page-title', 'Tambah Angsuran')
@section('page-description', 'Tambahkan jadwal angsuran pinjaman anggota.')

@section('content')
<div class="container-fluid px-0">
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ route('angsuran.store') }}" method="POST">
                @csrf
                @include('angsuran._form')
            </form>
        </div>
    </div>
</div>
@endsection
