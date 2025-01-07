<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use Illuminate\Http\Request;

class ClassesController extends Controller
{
    public function index()
    {
        return Classes::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required'],
            'hit_attribute' => ['required'],
            'damage_stat' => ['required'],
            'strength' => ['required'],
            'dexterity' => ['required'],
            'inteligence' => ['required'],
            'agility' => ['required'],
            'charisma' => ['required'],
            'durability' => ['required'],
        ]);

        return Classes::create($data);
    }

    public function show(Classes $classes)
    {
        return $classes;
    }

    public function update(Request $request, Classes $classes)
    {
        $data = $request->validate([
            'name' => ['required'],
            'hit_attribute' => ['required'],
            'damage_stat' => ['required'],
            'strength' => ['required'],
            'dexterity' => ['required'],
            'inteligence' => ['required'],
            'agility' => ['required'],
            'charisma' => ['required'],
            'durability' => ['required'],
        ]);

        $classes->update($data);

        return $classes;
    }

    public function destroy(Classes $classes)
    {
        $classes->delete();

        return response()->json();
    }
}
