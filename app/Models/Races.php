<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Races extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'strength',
        'dexterity',
        'inteligence',
        'agility',
        'charisma',
        'durability',
    ];

    protected $appends = [
        'race_description',
    ];

    public function getRaceDescriptionAttribute()
    {
        return "Siła: {$this->strength}, Zręczność: {$this->dexterity}, Inteligencja: {$this->inteligence}, Zwinność: {$this->agility}, Charyzma: {$this->charisma}, Wytrzymałość: {$this->durability}";
    }
}
