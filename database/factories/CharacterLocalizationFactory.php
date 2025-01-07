<?php

namespace Database\Factories;

use App\Models\CharacterLocalization;
use App\Models\Localizations;
use App\Models\UserCharacter;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CharacterLocalizationFactory extends Factory
{
    protected $model = CharacterLocalization::class;

    public function definition()
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'user_character_id' => UserCharacter::factory(),
            'localizations_id' => Localizations::factory(),
        ];
    }
}
