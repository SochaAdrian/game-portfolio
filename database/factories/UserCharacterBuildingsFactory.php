<?php

namespace Database\Factories;

use App\Models\Buildings;
use App\Models\User;
use App\Models\CharacterBuildings;
use App\Models\UserCharacter;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class UserCharacterBuildingsFactory extends Factory
{
    protected $model = CharacterBuildings::class;

    public function definition(): array
    {
        return [
            'count' => $this->faker->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'character' => UserCharacter::factory(),
            'buildings_id' => Buildings::factory(),
        ];
    }
}
