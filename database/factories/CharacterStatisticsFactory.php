<?php

namespace Database\Factories;

use App\Models\CharacterStatistics;
use App\Models\Statistics;
use App\Models\UserCharacter;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CharacterStatisticsFactory extends Factory
{
    protected $model = CharacterStatistics::class;

    public function definition()
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'user_character_id' => UserCharacter::factory(),
            'statistics_id' => Statistics::factory(),
            'value' => $this->faker->randomNumber()
        ];
    }
}
