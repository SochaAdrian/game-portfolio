<?php

namespace App\Http\Controllers;

use App\Http\Services\GameService;
use App\Models\Resources;
use Illuminate\Http\Request;

class ResourcesController extends Controller
{

    protected $gameService;

    public function __construct()
    {
        $this->gameService = new GameService();
    }

    public function index()
    {
        return Resources::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required'],
            'description' => ['required'],
        ]);

        return Resources::create($data);
    }

    public function show(Resources $resources)
    {
        return $resources;
    }

    public function update(Request $request, Resources $resources)
    {
        $data = $request->validate([
            'name' => ['required'],
            'description' => ['required'],
        ]);

        $resources->update($data);

        return $resources;
    }

    public function destroy(Resources $resources)
    {
        $resources->delete();

        return response()->json();
    }

    public function increment(Request $request, $resources)
    {
        return $this->gameService->incrementResource($resources, $request->user());
    }
}
