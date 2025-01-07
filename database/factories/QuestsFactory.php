<?php

namespace Database\Factories;

use App\Models\Quests;
use App\Models\QuestProgress;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class QuestsFactory extends Factory
{
    protected $model = Quests::class;

    public function definition()
    {
        $type = $this->faker->randomElement(['fight', 'collect', 'talk', 'find']);
        $fakeNumberForQuest = fake()->numberBetween(1, 10);
        $description = $this->generateDescription($type, $fakeNumberForQuest);
        $name = $this->generateName($type);

        return [
            'name' => $name,
            'description' => $description,
            'type' => $type,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'requirement' => $type === 'fight' ? $fakeNumberForQuest : 1,
        ];
    }

    private function generateDescription(string $type, int $fakeNumberForQuest): string
    {
        switch ($type) {
            case 'fight':
                return 'Pokonaj '.$fakeNumberForQuest.' '.fake()->randomElement([
                        'goblinów',
                        'orków',
                        'trolli',
                        'smoków',
                        'owieczek',
                        'wiatraków'
                    ]);
            case 'collect':
                return 'Zbierz ogromnie ważny przedmiot potrzebny do uratowania świata';
            case 'talk':
                return 'Musisz pomówić z '.fake()->randomElement([
                        'mądrym druidem',
                        'złym czarownikiem',
                        'wesołym skrzatem',
                        'smutnym elfem'
                    ]);
            case 'find':
                return 'Znajdź '.fake()->randomElement([
                        'ukryty skarb',
                        'zagubioną mapę',
                        'stary pamietnik babci',
                        'klucz do skarbca'
                    ]);
            default:
                return 'Przygotuj się na przygodę!';
        }
    }

    private function generateName(string $type): string
    {
        switch ($type) {
            case 'fight':
                return 'Walka z potworami';
            case 'collect':
                return 'Zbieranie przedmiotów';
            case 'talk':
                return 'Rozmowa z czymś lub kimś?';
            case 'find':
                return 'Poszukiwania';
            default:
                return 'Przygoda';
        }
    }
}
