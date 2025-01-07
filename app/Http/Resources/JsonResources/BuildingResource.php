<?php

namespace App\Http\Resources\JsonResources;

use App\Models\Buildings;
use App\Models\Resources;
use App\Models\UserCharacter;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Buildings */
class BuildingResource extends JsonResource
{
    public function toArray(Request $request): array
    {

        $requirements = $this->buildings?->buildingRequirements->first();
        $owned = 0;
        //quite tricky since we sometimes pass relationship and sometimes buildings
        if(!$requirements){
            $requirements = $this->buildingRequirements->first();
        }

        $user = $request->user();
        if($user){
            $character = UserCharacter::find(session('character'));
            if($character){
                $owned = $character->buildings->where('buildings_id', $this->id)->first()->count ?? 0;
            }
        }

        return [
            'id' => $this->id,
            'name' => ucfirst($this->name),
            'description' => $this->description,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'owned' => $owned,
            'building_cost' => $requirements->value ?? 0,
            'building_resource' => $requirements->resources_id ?? 0,
            'building_resource_name' => ucfirst(Resources::find($requirements->resources_id)->name) ?? 'None',
        ];
    }
}
