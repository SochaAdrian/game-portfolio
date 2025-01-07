<?php

namespace App\Http\Resources\JsonResources;

use App\Models\Buildings;
use App\Models\Resources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\CharacterBuildings;
use Illuminate\Support\Facades\Cache;

/** @mixin Resources */
class GameResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $buildingsThatGenerateResource = Cache::rememberForever("building_generate_resource_{$this->id}", function () {
            return Buildings::where('generate_resource', $this->id)->value('id');
        });

        $generation = CharacterBuildings::where('character_id', $this->user_character_id)
                ->where('buildings_id', $buildingsThatGenerateResource)
                ->sum('count') * 0.2;

        return [
            'id' => $this->id,
            'value' => $this->value,
            'name' => ucfirst($this->resources->name),
            'generation' => round($generation,1) ?? 0,
            'original_id' => $this->resources->id,
        ];
    }
}
