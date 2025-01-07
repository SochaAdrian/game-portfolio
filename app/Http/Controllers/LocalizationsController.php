<?php

namespace App\Http\Controllers;

use App\Models\Localizations;
use Illuminate\Http\Request;

class LocalizationsController extends Controller
{
    public function index()
    {
        return Localizations::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required'],
            'description' => ['required'],
        ]);

        return Localizations::create($data);
    }

    public function show(Localizations $localizations)
    {
        return $localizations;
    }

    public function update(Request $request, Localizations $localizations)
    {
        $data = $request->validate([
            'name' => ['required'],
            'description' => ['required'],
        ]);

        $localizations->update($data);

        return $localizations;
    }

    public function destroy(Localizations $localizations)
    {
        $localizations->delete();

        return response()->json();
    }
}
