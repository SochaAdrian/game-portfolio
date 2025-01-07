<?php

namespace Database\Factories;

use App\Models\Buildings;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class BuildingsFactory extends Factory
{
    protected $model = Buildings::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'generate_resource' => $this->faker->randomElement(['wood','stone', 'gold','food','iron','water']),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
