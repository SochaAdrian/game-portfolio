<?php

namespace Database\Factories;

use App\Models\Classes;
use App\Models\Races;
use App\Models\User;
use App\Models\UserCharacter;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class UserCharacterFactory extends Factory
{
    protected $model = UserCharacter::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'races_id' => Races::factory(),
            'classes_id' => Classes::factory(),
            'user_id' => User::factory(),
        ];
    }
}
