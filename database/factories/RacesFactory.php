<?php

namespace Database\Factories;

use App\Models\races;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class RacesFactory extends Factory
{
    protected $model = Races::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'strength' => $this->faker->numberBetween(1,10),
            'dexterity' => $this->faker->numberBetween(1,10),
            'inteligence' => $this->faker->numberBetween(1,10),
            'agility' => $this->faker->numberBetween(1,10),
            'charisma' => $this->faker->numberBetween(1,10),
            'durability' => $this->faker->numberBetween(1,10),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
