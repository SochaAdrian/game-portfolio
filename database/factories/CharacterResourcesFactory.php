<?php

namespace Database\Factories;

use App\Models\CharacterResources;
use App\Models\Resources;
use App\Models\UserCharacter;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CharacterResourcesFactory extends Factory
{
    protected $model = CharacterResources::class;

    public function definition()
    {
        return [
            'value' => $this->faker->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'user_character_id' => UserCharacter::factory(),
            'resources_id' => Resources::factory(),
        ];
    }
}
