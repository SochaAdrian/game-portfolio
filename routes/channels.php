<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('user.{userId}.character.{characterId}', function ($user, $userId, $characterId) {
    return (int) $user->id === (int) $userId;
});
