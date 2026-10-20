
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Edit Data Simpanan</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('simpanan.update', $simpanan->id) }}"
                  method="POST">
                @csrf
                @method('PUT')

                @include('simpanan._form')
            </form>
        </div>
    </div>
</div>
@endsection
