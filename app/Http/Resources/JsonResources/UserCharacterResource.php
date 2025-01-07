<?php

namespace App\Http\Resources\JsonResources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserCharacterResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'race' => $this->races->name,
            'class' => $this->classes->name,
            'bio' => $this->bio,
            'appearance' => $this->appearance,
        ];
    }

}
