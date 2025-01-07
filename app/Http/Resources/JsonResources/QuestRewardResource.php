<?php

namespace App\Http\Resources\JsonResources;

use App\Models\QuestRewards;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin QuestRewards */
class QuestRewardResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'value' => $this->value,

            'quests_id' => $this->quests_id,
            'statistics_id' => $this->statistics_id,
            'resources_id' => $this->resources_id,
            'buildings_id' => $this->buildings_id,
            'buildingName' => $this->getBuildingNameAttribute(),
            'resourceName' => $this->getResourceNameAttribute(),
            'statisticName' => $this->getStatisticNameAttribute(),

            'buildings' => new BuildingResource($this->whenLoaded('buildings')),
            'resources' => new GameResource($this->whenLoaded('resources')),
        ];
    }
}
