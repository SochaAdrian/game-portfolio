<?php

namespace App\Http\Controllers;

use App\Models\CharacterResources;
use Illuminate\Http\Request;

class CharacterResourcesController extends Controller
{
    public function index()
    {
        return CharacterResources::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_character_id' => ['required', 'exists:user_characters'],
            'resources_id' => ['required', 'exists:resources'],
            'value' => ['required', 'integer'],
        ]);

        return CharacterResources::create($data);
    }

    public function show(CharacterResources $characterResources)
    {
        return $characterResources;
    }

    public function update(Request $request, CharacterResources $characterResources)
    {
        $data = $request->validate([
            'user_character_id' => ['required', 'exists:user_characters'],
            'resources_id' => ['required', 'exists:resources'],
            'value' => ['required', 'integer'],
        ]);

        $characterResources->update($data);

        return $characterResources;
    }

    public function destroy(CharacterResources $characterResources)
    {
        $characterResources->delete();

        return response()->json();
    }
}
