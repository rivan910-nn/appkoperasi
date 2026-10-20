<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Anggota extends Model
{
    use HasFactory;

    protected $table = 'anggota';

    protected $fillable = [
        'no_anggota',
        'nik',
        'nama',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'no_hp',
        'email',
        'tanggal_bergabung',
        'status',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_bergabung' => 'date',
    ];

    public function pinjaman(): HasMany
    {
        return $this->hasMany(Pinjaman::class, 'anggota_id');
    }
}
