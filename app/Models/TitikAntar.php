<?php

namespace App\Models;

use App\Models\Barang;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TitikAntar extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'kota',
        'kode_pos',
        'alamat_lengkap',
        'kontak_nama',
        'kontak_nomor',
    ];

    /**
     * Get the barang for the titik antar.
     */
    public function barang(): HasMany
    {
        return $this->hasMany(Barang::class, 'titikantar_id');
    }
}
