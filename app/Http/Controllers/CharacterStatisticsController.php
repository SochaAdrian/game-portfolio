<?php

namespace App\Http\Controllers;

use App\Models\CharacterStatistics;
use Illuminate\Http\Request;

class CharacterStatisticsController extends Controller
{
    public function index()
    {
        return CharacterStatistics::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_character_id' => ['required', 'exists:user_characters'],
            'statistics_id' => ['required', 'exists:statistics'],
        ]);

        return CharacterStatistics::create($data);
    }

    public function show(CharacterStatistics $characterStatistics)
    {
        return $characterStatistics;
    }

    public function update(Request $request, CharacterStatistics $characterStatistics)
    {
        $data = $request->validate([
            'user_character_id' => ['required', 'exists:user_characters'],
            'statistics_id' => ['required', 'exists:statistics'],
        ]);

        $characterStatistics->update($data);

        return $characterStatistics;
    }

    public function destroy(CharacterStatistics $characterStatistics)
    {
        $characterStatistics->delete();

        return response()->json();
    }
}
