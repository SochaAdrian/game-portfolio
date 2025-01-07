<?php

namespace Database\Factories;

use App\Models\Buildings;
use App\Models\QuestRewards;
use App\Models\Resources;
use App\Models\Statistics;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class QuestRewardsFactory extends Factory
{
    protected $model = QuestRewards::class;

    public function definition()
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'value' => $this->faker->numberBetween(1,10),
            'statistics_id' => Statistics::factory(),
            'resources_id' => Resources::factory(),
            'buildings_id' => Buildings::factory(),
        ];
    }
}
