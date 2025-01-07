<?php

namespace Database\Factories;

use App\Models\Items;
use App\Models\UserCharacter;
use App\Models\UserEquipment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class UserEquipmentFactory extends Factory
{
    protected $model = UserEquipment::class;

    public function definition()
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'items_id' => Items::factory(),
            'user_character_id' => UserCharacter::factory(),
        ];
    }
}
