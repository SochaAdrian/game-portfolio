<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CharacterResources extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_character_id',
        'resources_id',
        'value',
    ];

    public function userCharacter()
    {
        return $this->belongsTo(UserCharacter::class);
    }

    public function resources()
    {
        return $this->belongsTo(Resources::class);
    }
}
