<?php

namespace App\Http\Resources\JsonResources;

use App\Models\QuestProgress;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin QuestProgress */
class QuestProgressResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'current_value' => $this->current_value,
            'expected_value' => $this->expected_value,
            'quests_id' => $this->quests_id,
            'quests_name' => $this->quests->name,
        ];
    }
}
