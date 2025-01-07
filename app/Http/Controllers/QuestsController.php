<?php

namespace App\Http\Controllers;

use App\Models\Quests;
use Illuminate\Http\Request;

class QuestsController extends Controller
{
    public function index()
    {
        return Quests::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required'],
            'description' => ['required'],
        ]);

        return Quests::create($data);
    }

    public function show(Quests $quests)
    {
        return $quests;
    }

    public function update(Request $request, Quests $quests)
    {
        $data = $request->validate([
            'name' => ['required'],
            'description' => ['required'],
        ]);

        $quests->update($data);

        return $quests;
    }

    public function destroy(Quests $quests)
    {
        $quests->delete();

        return response()->json();
    }
}
