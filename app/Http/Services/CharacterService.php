<?php

namespace App\Http\Services;

use App\Models\Resources;
use App\Models\Statistics;
use App\Models\UserCharacter;

class CharacterService
{
    public function __construct()
    {
    }

    public function addStatistics(UserCharacter $character): UserCharacter
    {
        $characterRace = $character->races;
        $characterClass = $character->classes;


        $statistics = [
            'strength' => 0,
            'dexterity' => 0,
            'agility' => 0,
            'inteligence' => 0,
            'charisma' => 0,
            'durability' => 0,
        ];


        if ($characterRace) {
            $statistics['strength'] += $characterRace->strength;
            $statistics['dexterity'] += $characterRace->dexterity;
            $statistics['agility'] += $characterRace->agility;
            $statistics['inteligence'] += $characterRace->inteligence;
            $statistics['charisma'] += $characterRace->charisma;
            $statistics['durability'] += $characterRace->durability;
        }

        if ($characterClass) {
            $statistics['strength'] += $characterClass->strength;
            $statistics['dexterity'] += $characterClass->dexterity;
            $statistics['agility'] += $characterClass->agility;
            $statistics['inteligence'] += $characterClass->inteligence;
            $statistics['charisma'] += $characterClass->charisma;
            $statistics['durability'] += $characterClass->durability;
        }


        foreach ($statistics as $statName => $statValue) {
            $stat = Statistics::where('name', $statName)->first();

            if ($stat) {
                $character->statistics()->create([
                    'statistics_id' => $stat->id,
                    'value' => $statValue
                ]);
            }
        }

        return $character;
    }

    public function assignDefaultResources(UserCharacter $character): void
    {
        $availableResources = Resources::all();

        foreach ($availableResources as $resource) {
            $character->resources()->create([
                'resources_id' => $resource->id,
                'value' => 0,
            ]);
        }
    }


}
