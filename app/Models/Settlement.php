<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Settlement extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'key',
        'name',
        'zone_type',
        'settlement_type_id',
    ];

    /**
     * Gets the type of settlement to which the settlement belongs.
     */
    public function settlementType(): BelongsTo
    {
        return $this->belongsTo(SettlementType::class);
    }
}
