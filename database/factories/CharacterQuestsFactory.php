<?php

namespace Database\Factories;

use App\Models\Quests;
use App\Models\User;
use App\Models\CharacterQuests;
use App\Models\UserCharacter;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CharacterQuestsFactory extends Factory
{
    protected $model = CharacterQuests::class;

    public function definition()
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'character_id' => UserCharacter::factory(),
            'quests_id' => Quests::factory(),
        ];
    }
}
