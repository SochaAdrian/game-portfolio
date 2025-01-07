<?php

namespace App\Events;

use App\Http\Resources\JsonResources\GameResource;
use App\Models\User;
use App\Models\UserCharacter;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ResourceUpdatedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public User $user;
    public UserCharacter $userCharacter;
    public $resources;

    public function __construct(User $user, UserCharacter $userCharacter)
    {
        $this->user = $user;
        $this->userCharacter = $userCharacter;

        // Prepare resources for broadcast
        $this->resources = GameResource::collection($userCharacter->resources);
    }

    public function broadcastOn()
    {
        return new PrivateChannel('user.' . $this->user->id . '.character.' . $this->userCharacter->id);
    }

    public function broadcastAs()
    {
        return 'resource.updated';
    }

    public function broadcastWith()
    {
        return [
            'resources' => $this->resources,
        ];
    }
}
