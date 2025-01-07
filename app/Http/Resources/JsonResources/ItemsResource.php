<?php

namespace App\Http\Resources\JsonResources;

use App\Models\Items;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Items */
class ItemsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'rarity' => $this->rarity,
            'strength' => $this->strength,
            'dexterity' => $this->dexterity,
            'agility' => $this->agility,
            'inteligence' => $this->inteligence,
            'quest_id' => $this->quest_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
