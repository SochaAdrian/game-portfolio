<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CharacterStatistics extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_character_id',
        'statistics_id',
        'value'
    ];

    public function userCharacter()
    {
        return $this->belongsTo(UserCharacter::class);
    }

    public function statistics()
    {
        return $this->belongsTo(Statistics::class);
    }
}
