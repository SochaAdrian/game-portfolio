<?php

namespace App\Http\Resources\JsonResources;

use App\Models\Statistics;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Statistics */
class StatisticsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => ucfirst($this->name),
            'description' => $this->description,
        ];
    }
}
