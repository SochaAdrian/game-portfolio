<?php

namespace App\Http\Controllers;

use App\Models\Statistics;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function index()
    {
        return Statistics::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required'],
            'description' => ['required'],
        ]);

        return Statistics::create($data);
    }

    public function show(Statistics $statistics)
    {
        return $statistics;
    }

    public function update(Request $request, Statistics $statistics)
    {
        $data = $request->validate([
            'name' => ['required'],
            'description' => ['required'],
        ]);

        $statistics->update($data);

        return $statistics;
    }

    public function destroy(Statistics $statistics)
    {
        $statistics->delete();

        return response()->json();
    }
}
