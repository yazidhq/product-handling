<?php

namespace App\Models;

use App\Models\Armada;
use App\Models\Kategori;
use App\Models\TitikAntar;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Barang extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'titikantar_id',
        'kategori_id',
        'armada_id',
        'nomor_resi',
        'nama_unit',
        'nama_barang',
        'deskripsi',
        'nama_pengirim',
        'nama_penerima',
        'nomor_penerima',
        'kota_penerima',
        'lokasi_penerima',
        'tanggal_pengiriman',
        'status_pengiriman',
    ];

    /**
     * Get the Titik antar that owns the barang.
     */
    public function titikantar(): BelongsTo
    {
        return $this->belongsTo(TitikAntar::class, 'titikantar_id');
    }

    /**
     * Get the Kategori that owns the barang.
     */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    /**
     * Get the Armada that owns the barang.
     */
    public function armada(): BelongsTo
    {
        return $this->belongsTo(Armada::class, 'armada_id');
    }

    /**
     * Get the LogBarang for the barang.
     */
    public function log_barang(): HasMany
    {
        return $this->hasMany(LogBarang::class, 'barang_id');
    }

    /**
     * Generate a random and unique 15-digit nomor_resi.
     */
    // public static function boot()
    // {
    //     parent::boot();
    //     static::creating(function ($barang) {
    //         $barang->nomor_resi = self::generateUniqueNomorResi();
    //     });
    // }

    /**
     * Generate a unique 15-digit nomor_resi.
     */
    // protected static function generateUniqueNomorResi(): int
    // {
    //     $nomorResi = mt_rand(100000000000000, 999999999999999);
    //     while (static::where('nomor_resi', $nomorResi)->exists()) {
    //         $nomorResi = mt_rand(100000000000000, 999999999999999);
    //     }
    //     return $nomorResi;
    // }

    /**
     * Get format date for d-m-y
     */
    public function getTanggalPengirimanAttribute($value)
    {
        return Carbon::parse($value);
    }
}
