<?php

namespace App\Http\Controllers;

use App\Models\races;
use Illuminate\Http\Request;

class RacesController extends Controller
{
    public function index()
    {
        return races::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required'],
            'strength' => ['required'],
            'dexterity' => ['required'],
            'inteligence' => ['required'],
            'agility' => ['required'],
            'charisma' => ['required'],
            'durability' => ['required'],
        ]);

        return Races::create($data);
    }

    public function show(races $races)
    {
        return $races;
    }

    public function update(Request $request, races $races)
    {
        $data = $request->validate([
            'name' => ['required'],
            'strength' => ['required'],
            'dexterity' => ['required'],
            'inteligence' => ['required'],
            'agility' => ['required'],
            'charisma' => ['required'],
            'durability' => ['required'],
        ]);

        $races->update($data);

        return $races;
    }

    public function destroy(races $races)
    {
        $races->delete();

        return response()->json();
    }
}
