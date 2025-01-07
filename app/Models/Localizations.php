<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Localizations extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function npcs()
    {
        return $this->hasMany(LocalizationNpcs::class);
    }

    public function questsAvailable()
    {
        $npcsInLocalization = $this->npcs;
        $quests = [];
        foreach ($npcsInLocalization as $npc) {
            $quests[] = $npc->quests;
        }
        return $quests;
    }
}
