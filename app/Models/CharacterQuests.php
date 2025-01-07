<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CharacterQuests extends Model
{
    use HasFactory;

    protected $fillable = [
        'character_id',
        'quests_id',
    ];

    public function userCharacter()
    {
        return $this->belongsTo(UserCharacter::class, 'character_id');
    }

    public function quests()
    {
        return $this->belongsTo(Quests::class, 'quests_id');
    }

    public function progress()
    {
        return $this->hasMany(QuestProgress::class, 'quests_id', 'quests_id');
    }
}
