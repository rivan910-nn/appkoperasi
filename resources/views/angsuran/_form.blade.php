
@php
    $isEdit = isset($angsuran);
@endphp

@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Periksa kembali data yang diisi:</strong>
        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row g-3">
    <div class="col-md-6">
        <label for="pinjaman_id" class="form-label">Pinjaman</label>
        <select name="pinjaman_id" id="pinjaman_id"
                class="form-select @error('pinjaman_id') is-invalid @enderror"
                required>
            <option value="">-- Pilih Pinjaman --</option>
            @foreach ($pinjaman as $p)
                <option value="{{ $p->id }}"
                    @selected(old('pinjaman_id', $angsuran->pinjaman_id ?? '') == $p->id)>
                    Pinjaman #{{ $p->id }}
                    — {{ $p->anggota?->nama ?? 'Anggota tidak tersedia' }}
                </option>
            @endforeach
        </select>
        @error('pinjaman_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="angsuran_ke" class="form-label">Angsuran Ke</label>
        <input type="number" name="angsuran_ke" id="angsuran_ke"
               class="form-control @error('angsuran_ke') is-invalid @enderror"
               min="1" max="65535" required
               value="{{ old('angsuran_ke', $angsuran->angsuran_ke ?? '') }}">
        @error('angsuran_ke')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="jatuh_tempo" class="form-label">Tanggal Jatuh Tempo</label>
        <input type="date" name="jatuh_tempo" id="jatuh_tempo"
               class="form-control @error('jatuh_tempo') is-invalid @enderror"
               required
               value="{{ old('jatuh_tempo', isset($angsuran) ? $angsuran->jatuh_tempo?->format('Y-m-d') : '') }}">
        @error('jatuh_tempo')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="jumlah_tagihan" class="form-label">Jumlah Tagihan (Rp)</label>
        <input type="number" name="jumlah_tagihan" id="jumlah_tagihan"
               class="form-control @error('jumlah_tagihan') is-invalid @enderror"
               min="0.01" step="0.01" required
               value="{{ old('jumlah_tagihan', $angsuran->jumlah_tagihan ?? '') }}">
        @error('jumlah_tagihan')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="jumlah_bayar" class="form-label">Jumlah Bayar (Rp)</label>
        <input type="number" name="jumlah_bayar" id="jumlah_bayar"
               class="form-control @error('jumlah_bayar') is-invalid @enderror"
               min="0" step="0.01" required
               value="{{ old('jumlah_bayar', $angsuran->jumlah_bayar ?? 0) }}">
        @error('jumlah_bayar')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="tanggal_bayar" class="form-label">Tanggal Bayar</label>
        <input type="date" name="tanggal_bayar" id="tanggal_bayar"
               class="form-control @error('tanggal_bayar') is-invalid @enderror"
               value="{{ old('tanggal_bayar', isset($angsuran) ? $angsuran->tanggal_bayar?->format('Y-m-d') : '') }}">
        @error('tanggal_bayar')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="status" class="form-label">Status</label>
        <select name="status" id="status"
                class="form-select @error('status') is-invalid @enderror" required>
            <option value="belum_bayar"
                @selected(old('status', $angsuran->status ?? 'belum_bayar') == 'belum_bayar')>
                Belum Bayar
            </option>
            <option value="dibayar"
                @selected(old('status', $angsuran->status ?? '') == 'dibayar')>
                Dibayar
            </option>
            <option value="terlambat"
                @selected(old('status', $angsuran->status ?? '') == 'terlambat')>
                Terlambat
            </option>
        </select>
        @error('status')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="d-flex gap-2 mt-4">
    <button type="submit" class="btn btn-primary">
        {{ $isEdit ? 'Simpan Perubahan' : 'Simpan Angsuran' }}
    </button>
    <a href="{{ route('angsuran.index') }}" class="btn btn-secondary">
        Kembali
    </a>
</div>
