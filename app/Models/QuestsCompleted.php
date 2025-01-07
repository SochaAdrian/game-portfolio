<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestsCompleted extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_character_id',
        'quests_id',
    ];

    public function userCharacter()
    {
        return $this->belongsTo(UserCharacter::class);
    }

    public function quests()
    {
        return $this->belongsTo(Quests::class);
    }
}
