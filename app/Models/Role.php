<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
    ];

    /**
     * Get the user associated with the role.
     */
    public function user(): HasMany
    {
        return $this->hasMany(User::class, 'role_id');
    }
}
