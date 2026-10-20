
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Tambah Data Simpanan</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('simpanan.store') }}" method="POST">
                @csrf

                @include('simpanan._form')
            </form>
        </div>
    </div>
</div>
@endsection
