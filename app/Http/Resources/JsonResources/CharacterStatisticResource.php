<?php

namespace App\Http\Resources\JsonResources;

use App\Models\CharacterStatistics;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin CharacterStatistics */
class CharacterStatisticResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'statistics_id' => $this->statistics_id,
            'statistic_value' => $this->value,
            'statistic_name' => ucfirst($this->statistics->name),
        ];
    }
}
