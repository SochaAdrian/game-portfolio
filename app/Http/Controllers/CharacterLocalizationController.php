<?php

namespace App\Http\Controllers;

use App\Models\CharacterLocalization;
use Illuminate\Http\Request;

class CharacterLocalizationController extends Controller
{
    public function index()
    {
        return CharacterLocalization::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_character_id' => ['required', 'exists:user_characters'],
            'localizations_id' => ['required', 'exists:localizations'],
        ]);

        return CharacterLocalization::create($data);
    }

    public function show(CharacterLocalization $characterLocalization)
    {
        return $characterLocalization;
    }

    public function update(Request $request, CharacterLocalization $characterLocalization)
    {
        $data = $request->validate([
            'user_character_id' => ['required', 'exists:user_characters'],
            'localizations_id' => ['required', 'exists:localizations'],
        ]);

        $characterLocalization->update($data);

        return $characterLocalization;
    }

    public function destroy(CharacterLocalization $characterLocalization)
    {
        $characterLocalization->delete();

        return response()->json();
    }
}
