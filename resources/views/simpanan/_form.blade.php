
@php
    $isEdit = isset($simpanan);
@endphp

<div class="mb-3">
    <label for="anggota_id" class="form-label">Anggota</label>
    <select name="anggota_id" id="anggota_id"
            class="form-select @error('anggota_id') is-invalid @enderror"
            required>
        <option value="">-- Pilih Anggota --</option>

        @foreach ($anggotas as $anggota)
            <option value="{{ $anggota->id }}"
                @selected(old('anggota_id', $simpanan->anggota_id ?? '') == $anggota->id)>
                {{ $anggota->nama }} ({{ $anggota->no_anggota }})
            </option>
        @endforeach
    </select>
    @error('anggota_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="jenis" class="form-label">Jenis Simpanan</label>
    <select name="jenis" id="jenis"
            class="form-select @error('jenis') is-invalid @enderror"
            required>
        <option value="">-- Pilih Jenis --</option>

        @foreach (['pokok', 'wajib', 'sukarela'] as $jenis)
            <option value="{{ $jenis }}"
                @selected(old('jenis', $simpanan->jenis ?? '') === $jenis)>
                {{ ucfirst($jenis) }}
            </option>
        @endforeach
    </select>
    @error('jenis')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="nominal" class="form-label">Nominal (Rp)</label>
    <input type="number" name="nominal" id="nominal"
           class="form-control @error('nominal') is-invalid @enderror"
           min="0.01" step="0.01" required
           value="{{ old('nominal', $simpanan->nominal ?? '') }}"
           placeholder="Contoh: 100000">
    @error('nominal')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="tanggal_transaksi" class="form-label">
        Tanggal Transaksi
    </label>
    <input type="datetime-local"
           name="tanggal_transaksi"
           id="tanggal_transaksi"
           class="form-control @error('tanggal_transaksi') is-invalid @enderror"
           value="{{ old('tanggal_transaksi',
               isset($simpanan)
                   ? $simpanan->tanggal_transaksi->format('Y-m-d\TH:i')
                   : now()->format('Y-m-d\TH:i')) }}"
           required>
    @error('tanggal_transaksi')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="status" class="form-label">Status</label>
    <select name="status" id="status"
            class="form-select @error('status') is-invalid @enderror"
            required>
        @foreach (['menunggu', 'disetujui', 'ditolak'] as $status)
            <option value="{{ $status }}"
                @selected(old('status', $simpanan->status ?? 'menunggu') === $status)>
                {{ ucfirst($status) }}
            </option>
        @endforeach
    </select>
    @error('status')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="d-flex gap-2">
    <button type="submit" class="btn btn-primary">
        {{ $isEdit ? 'Simpan Perubahan' : 'Simpan Simpanan' }}
    </button>

    <a href="{{ route('simpanan.index') }}" class="btn btn-secondary">
        Kembali
    </a>
</div>
