<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Municipality extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'key'];

    /**
     * Get the zip codes that belong to the municipality.
     */
    public function zipCodes(): HasMany
    {
        return $this->hasMany(ZipCode::class);
    }
}
