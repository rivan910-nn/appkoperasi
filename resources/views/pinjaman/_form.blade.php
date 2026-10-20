
@php
    $isEdit = isset($pinjaman);
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
        <label for="anggota_id" class="form-label">Anggota</label>
        <select name="anggota_id" id="anggota_id"
                class="form-select @error('anggota_id') is-invalid @enderror"
                required>
            <option value="">-- Pilih Anggota --</option>
            @foreach ($anggota as $a)
                <option value="{{ $a->id }}"
                    @selected(old('anggota_id', $pinjaman->anggota_id ?? '') == $a->id)>
                    {{ $a->no_anggota }} - {{ $a->nama }}
                </option>
            @endforeach
        </select>
        @error('anggota_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="jumlah_pengajuan" class="form-label">Jumlah Pengajuan (Rp)</label>
        <input type="number" name="jumlah_pengajuan" id="jumlah_pengajuan"
               class="form-control @error('jumlah_pengajuan') is-invalid @enderror"
               min="0.01" step="0.01" required
               value="{{ old('jumlah_pengajuan', $pinjaman->jumlah_pengajuan ?? '') }}">
        @error('jumlah_pengajuan')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="jumlah_disetujui" class="form-label">Jumlah Disetujui (Rp)</label>
        <input type="number" name="jumlah_disetujui" id="jumlah_disetujui"
               class="form-control @error('jumlah_disetujui') is-invalid @enderror"
               min="0.01" step="0.01"
               value="{{ old('jumlah_disetujui', $pinjaman->jumlah_disetujui ?? '') }}">
        <small class="text-muted">Isi jika pinjaman sudah disetujui.</small>
        @error('jumlah_disetujui')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="bunga_persen" class="form-label">Bunga (%)</label>
        <input type="number" name="bunga_persen" id="bunga_persen"
               class="form-control @error('bunga_persen') is-invalid @enderror"
               min="0" max="100" step="0.01" required
               value="{{ old('bunga_persen', $pinjaman->bunga_persen ?? '0') }}">
        @error('bunga_persen')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="tenor_bulan" class="form-label">Tenor (Bulan)</label>
        <input type="number" name="tenor_bulan" id="tenor_bulan"
               class="form-control @error('tenor_bulan') is-invalid @enderror"
               min="1" max="65535" required
               value="{{ old('tenor_bulan', $pinjaman->tenor_bulan ?? '') }}">
        @error('tenor_bulan')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="status" class="form-label">Status Pinjaman</label>
        <select name="status" id="status"
                class="form-select @error('status') is-invalid @enderror" required>
            <option value="diajukan"
                @selected(old('status', $pinjaman->status ?? 'diajukan') === 'diajukan')>
                Diajukan
            </option>
            <option value="disetujui"
                @selected(old('status', $pinjaman->status ?? '') === 'disetujui')>
                Disetujui
            </option>
            <option value="ditolak"
                @selected(old('status', $pinjaman->status ?? '') === 'ditolak')>
                Ditolak
            </option>
        </select>
        @error('status')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="d-flex gap-2 mt-4">
    <button type="submit" class="btn btn-primary">
        {{ $isEdit ? 'Simpan Perubahan' : 'Simpan Pinjaman' }}
    </button>
    <a href="{{ route('pinjaman.index') }}" class="btn btn-secondary">
        Kembali
    </a>
</div>
