<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCharacter extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'races_id',
        'classes_id',
        'bio',
        'appearance',
        'user_id'
    ];

    protected $with = ['races', 'classes', 'statistics', 'quests', 'resources', 'buildings', 'items'];

    public function races()
    {
        return $this->belongsTo(Races::class);
    }

    public function classes()
    {
        return $this->belongsTo(Classes::class);
    }

    public function statistics()
    {
        return $this->hasMany(CharacterStatistics::class);
    }

    public function quests()
    {
        return $this->hasManyThrough(Quests::class, CharacterQuests::class, 'character_id', 'id', 'id', 'quests_id');
    }

    public function pendingQuests()
    {
        $quests = $this->quests()->get();
        $completedQuests = $this->questsCompleted()->get();
        $completedQuestsIds = $completedQuests->pluck('quests_id')->toArray();
        return $quests->filter(function ($quest) use ($completedQuestsIds) {
            return !in_array($quest->id, $completedQuestsIds);
        });
    }

    public function resources()
    {
        return $this->hasMany(CharacterResources::class);
    }

    public function buildings()
    {
        return $this->hasMany(CharacterBuildings::class, 'character_id', 'id');
    }

    public function items()
    {
        return $this->hasManyThrough(Items::class, UserEquipment::class, 'user_character_id', 'id', 'id', 'items_id');
    }

    public function questsCompleted()
    {
        return $this->hasMany(QuestsCompleted::class, 'user_character_id', 'id');
    }

    public function scopeOwnedByUser($query)
    {
        return $query->where('user_id', auth()->user()->id);
    }

    public function localizations()
    {
        return $this->hasMany(CharacterLocalization::class);
    }

    public function questProgress()
    {
        return $this->quests()->first()?->progress();
    }
}
