<?php

namespace App\Http\Controllers;

use App\Models\QuestRewards;
use Illuminate\Http\Request;

class QuestRewardsController extends Controller
{
    public function index()
    {
        return QuestRewards::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'statistics_id' => ['required', 'exists:statistics'],
            'resources_id' => ['required', 'exists:resources'],
            'buildings_id' => ['required', 'exists:buildings'],
        ]);

        return QuestRewards::create($data);
    }

    public function show(QuestRewards $questRewards)
    {
        return $questRewards;
    }

    public function update(Request $request, QuestRewards $questRewards)
    {
        $data = $request->validate([
            'statistics_id' => ['required', 'exists:statistics'],
            'resources_id' => ['required', 'exists:resources'],
            'buildings_id' => ['required', 'exists:buildings'],
        ]);

        $questRewards->update($data);

        return $questRewards;
    }

    public function destroy(QuestRewards $questRewards)
    {
        $questRewards->delete();

        return response()->json();
    }
}
