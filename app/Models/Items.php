<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'rarity',
        'strength',
        'dexterity',
        'agility',
        'inteligence',
        'quest_id',
    ];

    public function quest()
    {
        return $this->belongsTo(Quests::class);
    }

    public function user()
    {
        return $this->belongsToMany(User::class);
    }


}
