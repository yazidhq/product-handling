<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Armada extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kendaraan',
        'plat_nomor',
        'container_nomor',
    ];

    /**
     * Get the barang for the armada.
     */
    public function barang(): HasMany
    {
        return $this->hasMany(Barang::class, 'armada_id');
    }
}
