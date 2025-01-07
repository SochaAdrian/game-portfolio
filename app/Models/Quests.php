<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quests extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'type',
        'requirement'
    ];

    public function localizationNpcs()
    {
        return $this->hasMany(LocalizationNpcs::class);
    }

    public function items()
    {
        return $this->hasMany(Items::class, 'quest_id');
    }

    public function userQuests()
    {
        return $this->hasMany(CharacterQuests::class);
    }

    public function questRewards()
    {
        return $this->hasMany(QuestRewards::class);
    }


    public function localizations()
    {
        //we have to query localizations through the localizationNpcs relationship localization npcs has a quest_id and localization_id
        //so we can get the localizaitons for particalar quest from the localizationNpcs relationship

        return $this->hasManyThrough(Localizations::class, LocalizationNpcs::class, 'quests_id', 'id', 'id',
            'localizations_id');
    }

    public function progress()
    {
        $this->hasOne(QuestProgress::class);
    }

    public function scopeAvailable()
    {
        return $this->whereNotIn('id', array_merge(
            QuestsCompleted::where('user_character_id', auth()->id())->pluck('quests_id')->toArray(),
            CharacterQuests::where('character_id', auth()->id())->pluck('quests_id')->toArray()
        ));
    }


}
