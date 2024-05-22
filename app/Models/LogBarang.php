<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LogBarang extends Model
{
    use HasFactory;

    protected $fillable = [
        'status_pengiriman',
        'datetime',
    ];

    /**
     * Get the Barang that owns the log.
     */
    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }
}
