<?php

namespace Database\Factories;

use App\Models\BuildingRequirements;
use App\Models\Buildings;
use App\Models\Resources;
use App\Models\Statistics;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class BuildingRequirementsFactory extends Factory
{
    protected $model = BuildingRequirements::class;

    public function definition()
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'buildings_id' => Buildings::factory(),
            'resources_id' => Resources::factory(),
        ];
    }
}
