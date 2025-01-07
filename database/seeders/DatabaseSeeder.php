<?php

namespace Database\Seeders;

use App\Models\Buildings;
use App\Models\Classes;
use App\Models\Items;
use App\Models\LocalizationNpcs;
use App\Models\Localizations;
use App\Models\QuestRewards;
use App\Models\Quests;
use App\Models\Races;
use App\Models\Resources;
use App\Models\Statistics;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Factories\ItemsFactory;
use Database\Factories\LocalizationNpcsFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Do startu gry potrzebujemy takich informacji jak:
        // Rasy, Questy i Nagrody, Resourcy, Itemy, Budynki, Statystyki, Klasy, Lokalizacje

        // Rasy Człowiek Elf Niziołek Ork Ogr
        $races = ['Człowiek', 'Elf', 'Niziołek', 'Ork', 'Ogr'];
        foreach ($races as $raceName) {
            Races::firstOrCreate(['name' => $raceName],
                [
                    'strength' => fake()->numberBetween(1, 10),
                    'dexterity' => fake()->numberBetween(1, 10),
                    'inteligence' => fake()->numberBetween(1, 10),
                    'agility' => fake()->numberBetween(1, 10),
                    'charisma' => fake()->numberBetween(1, 10),
                    'durability' => fake()->numberBetween(1, 10),
                ]);
        }

        // Klasy Wojownik Mag Łucznik Skrzypek
        $classes = ['Wojownik', 'Mag', 'Łucznik', 'Skrzypek'];
        foreach ($classes as $className) {
            Classes::firstOrCreate(['name' => $className],
                [
                    'hit_attribute' => fake()->randomElement(['strength', 'dexterity', 'intelligence', 'agility']),
                    'damage_stat' => fake()->randomElement(['strength', 'dexterity', 'intelligence', 'agility']),
                    'strength' => fake()->numberBetween(1, 10),
                    'dexterity' => fake()->numberBetween(1, 10),
                    'inteligence' => fake()->numberBetween(1, 10),
                    'agility' => fake()->numberBetween(1, 10),
                    'charisma' => fake()->numberBetween(1, 10),
                    'durability' => fake()->numberBetween(1, 10),
                ]
            );
        }

        // Tworzymy staystyki
        $statisticsType = [
            'strength' => 'Niesamowita siła płynie z mięśni',
            'dexterity' => 'Warto być sprawnym w zyciu',
            'agility' => 'Zwinność, możliwe że dzieki niej dosiegniesz palcami rąk ziemi',
            'inteligence' => 'Dzieki niej możesz czytać książki',
            'charisma' => 'Uśmiech, to twoje największe oręż',
            'durability' => 'Spróbuj mnie zabić, zobaczymy kto wytrzyma dłużej'
        ];

        foreach ($statisticsType as $statisticName => $statisticDescription) {
            Statistics::firstOrCreate(['name' => $statisticName, 'description' => $statisticDescription]);
        }

        // Tworzymy resourcy
        $resourcesType = [
            'gold' => 'Za pieniądze szczęścia nie kupisz ale jedzenie i umiejetnosci tak',
            'wood' => 'Rośnie w lesie - kto by się spodziewał',
            'stone' => 'Szukając pod ziemią najpierw znajdziesz kamień',
            'iron' => 'Kopiemy, topimy, przetapiamy',
            'food' => 'Bez jedzenia nie ma życia',
            'water' => 'Nie jesteśmy wielbłądami, woda jest potrzebna'
        ];
        foreach ($resourcesType as $resourceName => $resourceDescription) {
            Resources::firstOrCreate(['name' => $resourceName, 'description' => $resourceDescription]);
        }

        // Tworzymy budynki
        $buildingsType = [
            'tavern' => ['Desc' => 'Generuje jedzenie', 'generate_resource' => 'food'],
            'blacksmith' => ['Desc' => 'Generuje żelazo', 'generate_resource' => 'iron'],
            'market' => ['Desc' => 'Generuje złoto', 'generate_resource' => 'gold'],
            'quarry' => ['Desc' => 'Generuje kamień', 'generate_resource' => 'stone'],
            'sawmill' => ['Desc' => 'Generuje drewno', 'generate_resource' => 'wood'],
            'well' => ['Desc' => 'Generuje wodę', 'generate_resource' => 'water'],
        ];
        foreach ($buildingsType as $buildingName => $buildingDescription) {
            $resource = Resources::where('name', $buildingDescription['generate_resource'])->first();
            Buildings::firstOrCreate(['name' => $buildingName, 'description' => $buildingDescription['Desc'], 'generate_resource' => $resource->id]);
        }

        //Tworzymy zapotrzebowanie dla budynkow do zbudowania
        $resources = Resources::all()->pluck('id')->toArray();
        foreach (Buildings::all() as $building) {
            $randomResource = fake()->randomElement($resources);
            if(!$building->buildingRequirements()->exists()){
                $building->buildingRequirements()->create([
                    'resources_id' => $randomResource,
                    'value' => fake()->numberBetween(10, 25),
                ]);
                $resources = array_diff($resources, [$randomResource]);
            }
        }


        //Tworzymy kilka questów
        $quests = Quests::factory(50)->create()->each(function ($quest) {
            if ($quest->type === 'collect') {
                Items::create([
                    'name' => Items::factory()->make()->name, // Generate a random item name
                    'quest_id' => $quest->id,
                    'rarity' => fake()->randomElement(['common', 'rare', 'epic', 'legendary']),
                    'strength' => 0,
                    'dexterity' => 0,
                    'agility' => 0,
                    'inteligence' => 0,
                ]);
            }
        });



        //Tworzymy dla questów jakieś super nagrody
        $rewardType = ['resources', 'statistics', 'buildings'];
        for ($i = 0; $i < 50; $i++) {
            $rewardForQuest = fake()->randomElement($rewardType);
            switch ($rewardForQuest) {
                case 'resources':
                    $reward = QuestRewards::factory()->create([
                        'value' => fake()->numberBetween(1, 10),
                        'resources_id' => Resources::inRandomOrder()->first()->id,
                        'statistics_id' => null,
                        'buildings_id' => null,
                        'quests_id' => Quests::inRandomOrder()->first()->id,
                    ]);
                    break;
                case 'statistics':
                    $reward = QuestRewards::factory()->create([
                        'value' => fake()->numberBetween(1, 10),
                        'statistics_id' => Statistics::inRandomOrder()->first()->id,
                        'resources_id' => null,
                        'buildings_id' => null,
                        'quests_id' => Quests::inRandomOrder()->first()->id,
                    ]);
                    break;
                case 'buildings':
                    $reward = QuestRewards::factory()->create([
                        'value' => fake()->numberBetween(1, 10),
                        'buildings_id' => Buildings::inRandomOrder()->first()->id,
                        'resources_id' => null,
                        'statistics_id' => null,
                        'quests_id' => Quests::inRandomOrder()->first()->id,
                    ]);
                    break;
            }
        }


        $localizations = [
            'Las',
            'Góry',
            'Równina',
            'Pustynia',
            'Bagna',
            'Jaskinia',
            'Ruiny',
            'Miasto',
            'Wioska',
            'Zamek'
        ];
        foreach ($localizations as $localizationName) {
            Localizations::firstOrCreate([
                'name' => $localizationName,
                'description' => 'Wieści mówią o tym miejscu:'.fake()->realText()
            ]);
        }


        // Tworzymy kilku npców
        Localizations::all()->each(function ($localization) {
            LocalizationNpcs::factory()->create([
                'localizations_id' => $localization->id,
                'quests_id' => Quests::where('type','talk')->inRandomOrder()->first()->id,
            ]);
        });

    }


}
