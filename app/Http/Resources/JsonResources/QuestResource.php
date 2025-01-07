<?php

namespace App\Http\Resources\JsonResources;

use App\Models\Quests;
use App\Models\UserCharacter;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Quests */
class QuestResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $characterUsed = session('character');
        $progress = [];
        if ($characterUsed) {
            $userCharacter = UserCharacter::find($characterUsed);
            $progress = $userCharacter->questProgress()?->where('quests_id', $this->id)->get();
        }

        $localizedTypes = [
            'fight' => 'walka',
            'collect' => 'zbierz przedmioty',
            'talk' => 'porozmawiaj',
            'find' => 'znajdz',
        ];

        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'type' => ucfirst($localizedTypes[$this->type]) ?? $this->type,
            'rewards' => QuestRewardResource::collection($this->questRewards),
            'localizations' => LocalizationResource::collection($this->localizations()->get()),
            'progress' => QuestProgressResource::collection($progress ?? []),
            'items' => ItemsResource::collection($this->items),
        ];
    }
}
