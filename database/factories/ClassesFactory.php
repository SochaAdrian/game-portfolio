<?php

namespace Database\Factories;

use App\Models\Classes;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ClassesFactory extends Factory
{
    protected $model = Classes::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'hit_attribute' => $this->faker->randomElement(['strength', 'dexterity', 'inteligence', 'agility', 'charisma', 'durability']),
            'damage_stat' => $this->faker->randomElement(['strength', 'dexterity', 'inteligence', 'agility', 'charisma', 'durability']),
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
