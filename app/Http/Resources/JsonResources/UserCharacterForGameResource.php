<?php

namespace App\Http\Resources\JsonResources;

use App\Models\CharacterLocalization;
use App\Models\UserCharacter;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin UserCharacter */
class UserCharacterForGameResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'bio' => $this->bio,
            'appearance' => $this->appearance,
            'localization' => $this->localizations->first()?->localizationName(),
            'localization_id' => $this->localizations->first()?->id,
            'buildings' => BuildingResource::collection($this->buildings ?? []),
            'damage_stat' => $this->classes->hit_attribute,
            'items' => ItemsResource::collection($this->items ?? []),
            'statistics' => CharacterStatisticResource::collection($this->statistics ?? []),
            'quests' => QuestResource::collection($this->pendingQuests() ?? []),
            'resources' => GameResource::collection($this->resources ?? []),
            'quests_completed' => QuestCompletedResource::collection($this->questsCompleted ?? []),
            'race' => $this->races->name,
            'class' => $this->classes->name,
        ];
    }
}
