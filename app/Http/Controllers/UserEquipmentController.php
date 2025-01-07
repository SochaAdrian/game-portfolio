<?php

namespace App\Http\Controllers;

use App\Models\UserEquipment;
use Illuminate\Http\Request;

class UserEquipmentController extends Controller
{
    public function index()
    {
        return UserEquipment::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'items_id' => ['required', 'exists:items'],
            'user_character_id' => ['required', 'exists:user_characters'],
        ]);

        return UserEquipment::create($data);
    }

    public function show(UserEquipment $userEquipment)
    {
        return $userEquipment;
    }

    public function update(Request $request, UserEquipment $userEquipment)
    {
        $data = $request->validate([
            'items_id' => ['required', 'exists:items'],
            'user_character_id' => ['required', 'exists:user_characters'],
        ]);

        $userEquipment->update($data);

        return $userEquipment;
    }

    public function destroy(UserEquipment $userEquipment)
    {
        $userEquipment->delete();

        return response()->json();
    }
}
