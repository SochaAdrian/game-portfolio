<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CharacterBuildings extends Model
{
    use HasFactory;

    protected $fillable = [
        'character_id',
        'buildings_id',
        'count',
    ];

    public function character(): BelongsTo
    {
        return $this->belongsTo(UserCharacter::class);
    }

    public function buildings(): BelongsTo
    {
        return $this->belongsTo(Buildings::class);
    }
}
