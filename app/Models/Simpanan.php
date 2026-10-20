<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Simpanan extends Model
{
    protected $table = 'simpanan';

    protected $fillable = [
        'anggota_id',
        'jenis',
        'nominal',
        'tanggal_transaksi',
        'status',
        'created_by',
    ];

    protected $casts = [
        'nominal' => 'decimal:2',
        'tanggal_transaksi' => 'datetime',
    ];

    public function anggota(): BelongsTo
    {
        return $this->belongsTo(Anggota::class);
    }

    public function pembuat(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
