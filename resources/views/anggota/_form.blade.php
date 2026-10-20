@php
    $isEdit = isset($anggota);
@endphp

<div class="row g-3">
    <div class="col-md-6">
        <label for="no_anggota" class="form-label">Nomor Anggota <span class="text-danger">*</span></label>
        <input id="no_anggota" name="no_anggota" type="text" maxlength="30"
               class="form-control @error('no_anggota') is-invalid @enderror"
               value="{{ old('no_anggota', $anggota->no_anggota ?? '') }}" required>
        @error('no_anggota') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label for="nik" class="form-label">NIK (16 digit) <span class="text-danger">*</span></label>
        <input id="nik" name="nik" type="text" inputmode="numeric" minlength="16" maxlength="16"
               pattern="[0-9]{16}" class="form-control @error('nik') is-invalid @enderror"
               value="{{ old('nik', $anggota->nik ?? '') }}" required>
        @error('nik') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-8">
        <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
        <input id="nama" name="nama" type="text" maxlength="150"
               class="form-control @error('nama') is-invalid @enderror"
               value="{{ old('nama', $anggota->nama ?? '') }}" required>
        @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4">
        <label for="jenis_kelamin" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
        <select id="jenis_kelamin" name="jenis_kelamin"
                class="form-select @error('jenis_kelamin') is-invalid @enderror" required>
            <option value="">-- Pilih --</option>
            <option value="L" @selected(old('jenis_kelamin', $anggota->jenis_kelamin ?? '') === 'L')>Laki-laki</option>
            <option value="P" @selected(old('jenis_kelamin', $anggota->jenis_kelamin ?? '') === 'P')>Perempuan</option>
        </select>
        @error('jenis_kelamin') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
        <input id="tempat_lahir" name="tempat_lahir" type="text" maxlength="100"
               class="form-control @error('tempat_lahir') is-invalid @enderror"
               value="{{ old('tempat_lahir', $anggota->tempat_lahir ?? '') }}">
        @error('tempat_lahir') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
        <input id="tanggal_lahir" name="tanggal_lahir" type="date" max="{{ now()->toDateString() }}"
               class="form-control @error('tanggal_lahir') is-invalid @enderror"
               value="{{ old('tanggal_lahir', isset($anggota) && $anggota->tanggal_lahir ? $anggota->tanggal_lahir->format('Y-m-d') : '') }}">
        @error('tanggal_lahir') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-12">
        <label for="alamat" class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
        <textarea id="alamat" name="alamat" rows="3"
                  class="form-control @error('alamat') is-invalid @enderror" required>{{ old('alamat', $anggota->alamat ?? '') }}</textarea>
        @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label for="no_hp" class="form-label">Nomor HP <span class="text-danger">*</span></label>
        <input id="no_hp" name="no_hp" type="tel" maxlength="20"
               class="form-control @error('no_hp') is-invalid @enderror"
               value="{{ old('no_hp', $anggota->no_hp ?? '') }}" required>
        @error('no_hp') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label for="email" class="form-label">Email</label>
        <input id="email" name="email" type="email" maxlength="255"
               class="form-control @error('email') is-invalid @enderror"
               value="{{ old('email', $anggota->email ?? '') }}">
        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label for="tanggal_bergabung" class="form-label">Tanggal Bergabung <span class="text-danger">*</span></label>
        <input id="tanggal_bergabung" name="tanggal_bergabung" type="date"
               class="form-control @error('tanggal_bergabung') is-invalid @enderror"
               value="{{ old('tanggal_bergabung', isset($anggota) && $anggota->tanggal_bergabung ? $anggota->tanggal_bergabung->format('Y-m-d') : now()->toDateString()) }}" required>
        @error('tanggal_bergabung') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
        <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
            <option value="aktif" @selected(old('status', $anggota->status ?? 'aktif') === 'aktif')>Aktif</option>
            <option value="nonaktif" @selected(old('status', $anggota->status ?? 'aktif') === 'nonaktif')>Nonaktif</option>
        </select>
        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<div class="d-flex flex-wrap gap-2 mt-4">
    <button type="submit" class="btn btn-primary">{{ $isEdit ? 'Simpan Perubahan' : 'Simpan Anggota' }}</button>
    <a href="{{ route('anggota.index') }}" class="btn btn-outline-secondary">Batal</a>
</div>
