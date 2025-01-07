<?php

namespace Database\Factories;

use App\Models\LocalizationNpcs;
use App\Models\Localizations;
use App\Models\Quests;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class LocalizationNpcsFactory extends Factory
{
    protected $model = LocalizationNpcs::class;

    public function definition()
    {
        return [
            'name' => $this->generateRandomName(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'localizations_id' => Localizations::factory(),
            'quests_id' => Quests::factory(),
            'appearance' => $this->generateAppearance(),
        ];
    }

    private function generateRandomName()
    {
        return $this->faker->name().' The '.$this->faker->randomElement([
                'Brave',
                'Wise',
                'Strong',
                'Clever',
                'Kind',
                'Evil',
                'Cunning',
                'Mighty',
                'Swift',
                'Loyal',
                'Honest',
                'Fair',
                'Noble',
                'Wicked',
                'Greedy',
                'Lazy',
                'Cowardly',
                'Vain',
                'Proud',
                'Foolish',
                'Cruel',
                'Gentle',
                'Generous'
            ]);
    }

    private function generateAppearance(): array
    {
        return [
            'gender' => fake()->randomElement(['man', 'woman']),
            'skin_color' => fake()->randomElement(['light', 'tan', 'brown', 'dark']),
            'hair_color' => fake()->randomElement(['blonde', 'brown', 'black', 'red', 'gray', 'white']),
            'face_expression' => fake()->randomElement(['happy', 'sad', 'angry', 'neutral', 'surprised']),
        ];

    }
}
