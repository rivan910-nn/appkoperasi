<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Angsuran extends Model
{
    protected $table = 'angsuran';

    protected $fillable = [
        'pinjaman_id',
        'angsuran_ke',
        'jatuh_tempo',
        'jumlah_tagihan',
        'jumlah_bayar',
        'tanggal_bayar',
        'status',
    ];

    protected $casts = [
        'angsuran_ke' => 'integer',
        'jatuh_tempo' => 'date',
        'jumlah_tagihan' => 'decimal:2',
        'jumlah_bayar' => 'decimal:2',
        'tanggal_bayar' => 'date',
    ];

    public function pinjaman(): BelongsTo
    {
        return $this->belongsTo(Pinjaman::class);
    }
}
