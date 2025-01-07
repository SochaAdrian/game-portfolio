<?php

namespace App\Http\Services;

use App\Http\Helpers\Helpers;
use App\Models\Buildings;
use App\Models\CharacterBuildings;
use App\Models\CharacterLocalization;
use App\Models\CharacterQuests;
use App\Models\CharacterResources;
use App\Models\LocalizationNpcs;
use App\Models\Localizations;
use App\Models\QuestProgress;
use App\Models\Quests;
use App\Models\QuestsCompleted;
use App\Models\Resources;
use App\Models\User;
use App\Models\UserCharacter;
use App\Models\UserEquipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GameService
{

    public function __construct()
    {
    }

    private static function awardQuest(Quests $quest, UserCharacter $character): void
    {
        $questRewards = $quest->questRewards()->get();


        foreach($questRewards as $reward){
            //award statistics
            if($reward->statistics_id){
                $character->statistics()
                    ->where('statistics_id', $reward->statistics_id)
                    ->increment('value',$reward->value);
            }

            //award resources
            if($reward->resources_id){
                $character->resources()
                    ->where('resources_id',$reward->resources_id)
                    ->increment('value', $reward->value);
            }


            //award buildings
            if($reward->buildings_id){
                if($character->buildings()->where('buildings_id', $reward->buildings_id)->exists()) {
                    $character->buildings()->increment('count', $reward->value);
                } else {
                    CharacterBuildings::create([
                        'character_id' => $character->id,
                        'buildings_id' => $reward->buildings_id,
                        'count' => $reward->value,
                    ]);
                }
            }

        }


        //award items
        if($quest->items()->exists()){
            foreach($quest->items()->get() as $item){
                UserEquipment::create([
                    'user_character_id' => $character->id,
                    'items_id' => $item->id,
                ]);
            }
        }

    }

    public function incrementResource($resources, User $user)
    {
        $userCharacterId = session('character');
        $character = $user->characters()->find($userCharacterId);

        if (!$character) {
            return response()->json(['error' => 'Character not found'], 404);
        }

        $query = CharacterResources::find($resources);
        $query->increment('value');
        return response()->json(['newValue' => $query->value]);
    }

    public function changeLocalization($id, Request $request)
    {
        $user = $request->user();
        $character = $user->characters()->find(session('character'));

        if (!$character) {
            return response()->json(['error' => 'Character not found'], 404);
        }

        $localization = CharacterLocalization::firstOrCreate(
            ['user_character_id' => $character->id],
            ['localizations_id' => $id]
        );

        if ($localization->wasRecentlyCreated === false && $localization->localizations_id != $id) {
            $localization->update(['localizations_id' => $id]);
        }

        return response()->json(['success' => true, 'localization' => $localization]);

    }

    public function startQuest($id, Request $request)
    {
        $user = $request->user();
        $character = $user->characters()->find(session('character'));

        if (!$character) {
            return response()->json(['error' => 'Character not found'], 404);
        }

        $quest = $character->quests()->where('quests_id', $id)->first();

        if ($quest) {
            return response()->json(['error' => 'Quest already started'], 400);
        }

        CharacterQuests::create([
            'character_id' => $character->id,
            'quests_id' => $id,
        ]);

        QuestProgress::create([
            'user_character_id' => $character->id,
            'quests_id' => $id,
            'current_value' => 0,
            'expected_value' => Quests::find($id)->requirement,
        ]);

        return response()->json(['success' => true, 'quest' => $id]);
    }

    public function getNpcs(Localizations $localization, Request $request)
    {
        $user = $request->user();
        $character = $user->characters()->find(session('character'));

        if (!$character) {
            return response()->json(['error' => 'Character not found'], 404);
        }

        $npcs = $localization->npcs()->get();

        //we should check if user has quest with this npc and if so, return it in response
        $npcs->map(function ($npc) use ($character) {
            $quest = $npc->quests()->first();
            $questProgress = $character->quests()->where('quests_id', $quest->id)->first();
            $npc->quest = $questProgress;
        });

        return response()->json($npcs);
    }

    public function talkToNpc($npc, Request $request)
    {
        $user = $request->user();
        $character = $user->characters()->find(session('character'));

        if (!$character) {
            return response()->json(['error' => 'Character not found'], 404);
        }

        $npc = LocalizationNpcs::find($npc);

        if (!$npc) {
            return response()->json(['error' => 'NPC not found'], 404);
        }

        if (!in_array($npc->quests_id, $character->quests->pluck('id')->toArray())) {
            return response(fake()->sentence(12), 200);
        }

        if (QuestsCompleted::where('quests_id', $npc->quests_id)->where('user_character_id',
            $character->id)->exists()) {
            return response('Skonczyłeś już zadanie - nie męcz mnie', 200);
        }

        $questProgress = QuestProgress::where('quests_id', $npc->quests_id)
            ->where('user_character_id', $character->id);

        $questProgress->increment('current_value');
        QuestsCompleted::insert([
            'user_character_id' => $character->id,
            'quests_id' => $npc->quests_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response('Zakończyłeś misje', 201);
    }

    public function finishQuest($id, Request $request)
    {
        $user = $request->user();
        $character = $user->characters()->find(session('character'));

        if (!$character) {
            return response()->json(['error' => 'Character not found'], 404);
        }

        $quest = $character->quests()->where('quests_id', $id)->first();

        if (!$quest) {
            return response()->json(['error' => 'Quest not found'], 404);
        }

        if (QuestsCompleted::where('quests_id', $id)->where('user_character_id', $character->id)->exists()) {
            return response()->json(['error' => 'Quest already completed'], 400);
        }

        QuestsCompleted::create([
            'user_character_id' => $character->id,
            'quests_id' => $id,
        ]);

        $questProgress = QuestProgress::where('quests_id', $id)
            ->where('user_character_id', $character->id)
            ->first();

        if ($questProgress) {
            $questProgress->delete();
        }

        // Give rewards
        self::awardQuest($quest, $character);

        return response()->json([
            'success' => true,
            'quest' => [
                'id' => $id,
                'status' => 'Zakończona!',
            ],
        ]);
    }

    public function buildBuilding($building, Request $request)
    {

        $user = $request->user();
        $character = $user->characters()->find(session('character'));

        if (!$character) {
            return response()->json(['error' => 'Character not found'], 404);
        }

        $building = Buildings::find($building);

        if (!$building) {
            return response()->json(['error' => 'Building not found'], 404);
        }

        $userResources = $character->resources()->get();
        $buildingRequirements = $building->buildingRequirements()->get();

        foreach($buildingRequirements as $requirement){
            $resource = $userResources->where('resources_id', $requirement->resources_id)->first();
            if($resource->value < $requirement->value){
                return response()->json(['error' => 'Not enough resources'], 400);
            }
        }

        DB::transaction(function () use ($character, $building, $buildingRequirements) {
            foreach($buildingRequirements as $requirement){
                $resource = $character->resources()->where('resources_id', $requirement->resources_id)->first();
                $resource->decrement('value', $requirement->value);
            }

            $characterBuilding = $character->buildings()->where('buildings_id', $building->id)->first();

            if ($characterBuilding) {
                $characterBuilding->increment('count');
            } else {
                CharacterBuildings::create([
                    'character_id' => $character->id,
                    'buildings_id' => $building->id,
                    'count' => 1,
                ]);
            }
        });


        return response()->json(['success' => true, 'owned' => $character->buildings()->where('buildings_id', $building->id)->first()->count]);
    }


}
