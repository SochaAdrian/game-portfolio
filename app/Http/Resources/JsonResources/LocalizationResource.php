<?php

namespace App\Http\Resources\JsonResources;

use App\Models\Localizations;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Localizations */
class LocalizationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'quests_available' => LocalizationQuestResource::collection($this->questsAvailable()),
        ];
    }
}
