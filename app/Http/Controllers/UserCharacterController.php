<?php

namespace App\Http\Controllers;

use App\Http\Resources\JsonResources\GameResource;
use App\Http\Services\CharacterService;
use App\Models\UserCharacter;
use Illuminate\Http\Request;

class UserCharacterController extends Controller
{

    public function __construct()
    {
        $this->service = new CharacterService();
    }

    public function index()
    {
        return UserCharacter::ownedByUser()->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required'],
            'races_id' => ['required', 'integer', 'exists:races,id'],
            'classes_id' => ['required', 'integer', 'exists:classes,id'],
            'bio' => ['nullable', 'string', 'max:255'],
        ]);

        $data['user_id'] = auth()->user()->id;

        $character = UserCharacter::create($data);
        $this->service->addStatistics($character);
        $this->service->assignDefaultResources($character);

        return redirect()->route('games.choose-character', $character);
    }

    public function show(UserCharacter $userCharacter)
    {
        return $userCharacter;
    }

    // This method rather won't be used in the game
    public function update(Request $request, UserCharacter $userCharacter)
    {
        $data = $request->validate([
            'name' => ['required'],
            'races_id' => ['required', 'exists:races'],
            'classes_id' => ['required', 'exists:classes'],
        ]);

        $userCharacter->update($data);

        return $userCharacter;
    }

    public function destroy(UserCharacter $userCharacter)
    {
        $userCharacter->delete();

        return response()->json();
    }

    public function getResources(Request $request)
    {
        $user = $request->user();
        $userCharacter = $user->characters()->find(session('character'));
        return GameResource::collection($userCharacter->resources);
    }
}
