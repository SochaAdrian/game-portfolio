<?php

namespace App\Http\Resources\JsonResources;

use App\Models\CharacterLocalization;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin CharacterLocalization */
class CharacterLocalizationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->localizations->name,
        ];
    }
}
