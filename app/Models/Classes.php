<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'hit_attribute',
        'damage_stat',
        'strength',
        'dexterity',
        'inteligence',
        'agility',
        'charisma',
        'durability',
    ];

    protected $appends = [
        'class_description',
    ];

    public function getClassDescriptionAttribute()
    {
        return "Siła: {$this->strength}, Zręczność: {$this->dexterity}, Inteligencja: {$this->inteligence}, Zwinność: {$this->agility}, Charyzma: {$this->charisma}, Wytrzymałość: {$this->durability}, Atrybut trafienia: {$this->hit_attribute}, Statystyka obrażeń: {$this->damage_stat}";
    }
}
