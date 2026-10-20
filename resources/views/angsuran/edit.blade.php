
@extends('layouts.app')

@section('title', 'Edit Angsuran')
@section('page-title', 'Edit Angsuran')
@section('page-description', 'Perbarui data angsuran pinjaman anggota.')

@section('content')
<div class="container-fluid px-0">
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ route('angsuran.update', $angsuran->id) }}" method="POST">
                @csrf
                @method('PUT')
                @include('angsuran._form')
            </form>
        </div>
    </div>
</div>
@endsection
