<?php

namespace App\Http\Resources\JsonResources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestCompletedResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->quests->id,
            'name' => $this->quests->name,
            'description' => $this->quests->description,
        ];
    }
}
