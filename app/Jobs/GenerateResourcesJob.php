<?php

namespace App\Jobs;

use App\Events\ResourceUpdatedEvent;
use App\Models\Buildings;
use App\Models\CharacterResources;
use App\Models\Resources;
use App\Models\User;
use App\Models\UserCharacter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateResourcesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private User $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle(): void
    {
        foreach($this->user->characters as $characters){
            foreach($characters->buildings as $building){
                // We have all buildings that character owns
                // We need to look which resource they generate
                $resourceGenerated = Buildings::where('id', $building->buildings_id)->first()->generate_resource;

                // Now we have the resource that building generates
                // We need to add the value to the character's resources
                $characterResource = CharacterResources::where('user_character_id', $characters->id)
                    ->where('resources_id', $resourceGenerated)
                    ->first()
                    ->increment('value', $building->count);

                broadcast(new ResourceUpdatedEvent($this->user, $characters));
            }
        }

    }
}
