<?php

namespace App\Http\Controllers;

use App\Models\QuestProgress;
use Illuminate\Http\Request;

class QuestProgressController extends Controller
{
    public function index()
    {
        return QuestProgress::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'quests_id' => ['required', 'exists:quests'],
            'current_value' => ['required', 'integer'],
            'expected_value' => ['required', 'integer'],
        ]);

        return QuestProgress::create($data);
    }

    public function show(QuestProgress $questProgress)
    {
        return $questProgress;
    }

    public function update(Request $request, QuestProgress $questProgress)
    {
        $data = $request->validate([
            'quests_id' => ['required', 'exists:quests'],
            'current_value' => ['required', 'integer'],
            'expected_value' => ['required', 'integer'],
        ]);

        $questProgress->update($data);

        return $questProgress;
    }

    public function destroy(QuestProgress $questProgress)
    {
        $questProgress->delete();

        return response()->json();
    }
}
