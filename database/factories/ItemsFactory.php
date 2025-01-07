<?php

namespace Database\Factories;

use App\Models\Items;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ItemsFactory extends Factory
{
    protected $model = Items::class;

    public function definition()
    {
        return [
            'name' => $this->generateRandomItemName(),
            'rarity' => $this->faker->word(),
            'strength' => $this->faker->randomNumber(),
            'dexterity' => $this->faker->randomNumber(),
            'agility' => $this->faker->randomNumber(),
            'inteligence' => $this->faker->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }

    public function generateRandomItemName()
    {

        $adjectives = [
            "szybki",
            "wolny",
            "duży",
            "mały",
            "piękny",
            "brzydki",
            "nowoczesny",
            "stary",
            "wysoki",
            "niski",
            "ciepły",
            "zimny",
            "ciężki",
            "lekki",
            "drogi",
            "tani",
            "cichy",
            "głośny",
            "silny",
            "słaby",
            "ostry",
            "tępy",
            "kolorowy",
            "ciemny",
            "jasny"
        ];

        $items = [
            "krzesło",
            "stół",
            "komputer",
            "telefon",
            "książka",
            "zegarek",
            "rower",
            "samochód",
            "długopis",
            "plecak",
            "kanapa",
            "kubek",
            "klawiatura",
            "myszka",
            "telewizor",
            "drzwi",
            "okno",
            "lodówka",
            "kuchenka",
            "lustro",
            "aparat",
            "kamera",
            "piłka",
            "kapelusz",
            "szafa"
        ];

        // Zeby wygenerowac jakis losowy item i dodac do tego troche chaosu
        // To dodamy do nazwy itemu losowy przymiotnik z tablicy $adjectives
        // A czasem dodamy nawet drugi przymiotnik z tej tablicy

        $name = $this->faker->randomElement($adjectives)." ".$this->faker->randomElement($items);

        $this->faker->boolean(70) ? $name = $this->faker->randomElement($adjectives)." ".$name : null;
        return $name;
    }
}
