<?php

namespace App\Http\Controllers;

use App\Models\Items;
use Illuminate\Http\Request;

class ItemsController extends Controller
{
    public function index()
    {
        return Items::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required'],
            'rarity' => ['required'],
            'strength' => ['required', 'integer'],
            'dexterity' => ['required', 'integer'],
            'agility' => ['required', 'integer'],
            'inteligence' => ['required', 'integer'],
        ]);

        return Items::create($data);
    }

    public function show(Items $items)
    {
        return $items;
    }

    public function update(Request $request, Items $items)
    {
        $data = $request->validate([
            'name' => ['required'],
            'rarity' => ['required'],
            'strength' => ['required', 'integer'],
            'dexterity' => ['required', 'integer'],
            'agility' => ['required', 'integer'],
            'inteligence' => ['required', 'integer'],
        ]);

        $items->update($data);

        return $items;
    }

    public function destroy(Items $items)
    {
        $items->delete();

        return response()->json();
    }
}
