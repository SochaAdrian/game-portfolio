<?php

namespace Database\Factories;

use App\Models\Quests;
use App\Models\QuestsCompleted;
use App\Models\UserCharacter;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class QuestsCompletedFactory extends Factory
{
    protected $model = QuestsCompleted::class;

    public function definition()
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'user_character_id' => UserCharacter::factory(),
            'quests_id' => Quests::factory(),
        ];
    }
}
