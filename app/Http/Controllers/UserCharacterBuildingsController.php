<?php

namespace App\Http\Controllers;

use App\Models\CharacterBuildings;
use Illuminate\Http\Request;

class UserCharacterBuildingsController extends Controller
{
    public function index()
    {
        return CharacterBuildings::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'character_id' => ['required', 'exists:users'],
            'buildings_id' => ['required', 'exists:buildings'],
            'count' => ['required', 'integer'],
        ]);

        return CharacterBuildings::create($data);
    }

    public function show(CharacterBuildings $userBuildings)
    {
        return $userBuildings;
    }

    public function update(Request $request, CharacterBuildings $userBuildings)
    {
        $data = $request->validate([
            'user_id' => ['required', 'exists:users'],
            'buildings_id' => ['required', 'exists:buildings'],
            'count' => ['required', 'integer'],
        ]);

        $userBuildings->update($data);

        return $userBuildings;
    }

    public function destroy(CharacterBuildings $userBuildings)
    {
        $userBuildings->delete();

        return response()->json();
    }
}
