<?php

namespace App\Http\Resources\Collections;

use App\Http\Resources\JsonResources\UserCharacterResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/** @see \App\Models\UserCharacter */
class UserCharacterCollection extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return $this->collection->map(function ($userCharacter) use ($request) {
            return (new UserCharacterResource($userCharacter))->toArray($request);
        })->all();
    }
}
