<?php

namespace Database\Factories;

use App\Models\QuestProgress;
use App\Models\Quests;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class QuestProgressFactory extends Factory
{
    protected $model = QuestProgress::class;

    public function definition(): array
    {
        return [
            'current_value' => $this->faker->randomNumber(),
            'expected_value' => $this->faker->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'quests_id' => Quests::factory(),
        ];
    }
}
