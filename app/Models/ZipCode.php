<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ZipCode extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'zip_code',
        'locality',
        'municipality_id',
    ];

    /**
     * Gets the federal entity to which the zip code belongs.
     */
    public function federalEntity(): BelongsTo
    {
        return $this->belongsTo(FederalEntity::class);
    }

    /**
     * Get the municipality to which the zip code belongs.
     */
    public function municipality(): BelongsTo
    {
        return $this->belongsTo(Municipality::class);
    }

    /**
     * Gets the settlements that belong to the zip code.
     */
    public function settlements(): HasMany
    {
        return $this->hasMany(Settlement::class);
    }
}
