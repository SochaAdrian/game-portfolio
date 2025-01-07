<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CharacterLocalization extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_character_id',
        'localizations_id',
    ];

    public function userCharacter()
    {
        return $this->belongsTo(UserCharacter::class);
    }

    public function localizations()
    {
        return $this->belongsTo(Localizations::class);
    }

    public function localizationName()
    {
        return $this->localizations->name;
    }
}
