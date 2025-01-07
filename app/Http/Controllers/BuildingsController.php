<?php

namespace App\Http\Controllers;

use App\Models\Buildings;
use Illuminate\Http\Request;

class BuildingsController extends Controller
{
    public function index()
    {
        return Buildings::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required'],
            'description' => ['required'],
        ]);

        return Buildings::create($data);
    }

    public function show(Buildings $buildings)
    {
        return $buildings;
    }

    public function update(Request $request, Buildings $buildings)
    {
        $data = $request->validate([
            'name' => ['required'],
            'description' => ['required'],
        ]);

        $buildings->update($data);

        return $buildings;
    }

    public function destroy(Buildings $buildings)
    {
        $buildings->delete();

        return response()->json();
    }
}
