<?php

namespace App\Http\Controllers;

use App\Models\BuildingRequirements;
use Illuminate\Http\Request;

class BuildingRequirementsController extends Controller
{
    public function index()
    {
        return BuildingRequirements::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'buildings_id' => ['required', 'exists:buildings'],
            'resources_id' => ['required', 'exists:resources'],
            'statistics_id' => ['required', 'exists:statistics'],
        ]);

        return BuildingRequirements::create($data);
    }

    public function show(BuildingRequirements $buildingRequirements)
    {
        return $buildingRequirements;
    }

    public function update(Request $request, BuildingRequirements $buildingRequirements)
    {
        $data = $request->validate([
            'buildings_id' => ['required', 'exists:buildings'],
            'resources_id' => ['required', 'exists:resources'],
            'statistics_id' => ['required', 'exists:statistics'],
        ]);

        $buildingRequirements->update($data);

        return $buildingRequirements;
    }

    public function destroy(BuildingRequirements $buildingRequirements)
    {
        $buildingRequirements->delete();

        return response()->json();
    }
}
