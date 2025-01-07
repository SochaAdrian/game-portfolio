<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuestProgress extends Model
{
    use HasFactory;

    protected $fillable = [
        'quests_id',
        'user_character_id',
        'current_value',
        'expected_value',
    ];

    public function quests(): BelongsTo
    {
        return $this->belongsTo(Quests::class);
    }

    public function characterQuests(): BelongsTo
    {
        return $this->belongsTo(CharacterQuests::class, 'user_character_id', 'character_id');
    }
}
