<?php

namespace App\Http\Controllers;

use App\Models\QuestsCompleted;
use Illuminate\Http\Request;

class QuestsCompletedController extends Controller
{
    public function index()
    {
        return QuestsCompleted::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_character_id' => ['required', 'exists:user_characters'],
            'quests_id' => ['required', 'exists:quests'],
        ]);

        return QuestsCompleted::create($data);
    }

    public function show(QuestsCompleted $questsCompleted)
    {
        return $questsCompleted;
    }

    public function update(Request $request, QuestsCompleted $questsCompleted)
    {
        $data = $request->validate([
            'user_character_id' => ['required', 'exists:user_characters'],
            'quests_id' => ['required', 'exists:quests'],
        ]);

        $questsCompleted->update($data);

        return $questsCompleted;
    }

    public function destroy(QuestsCompleted $questsCompleted)
    {
        $questsCompleted->delete();

        return response()->json();
    }
}
