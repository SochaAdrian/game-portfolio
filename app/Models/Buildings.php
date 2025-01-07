<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;

class Buildings extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'generate_resource',
    ];

    public static function boot()
    {
        parent::boot();

        static::updated(function ($building) {
            Cache::forget("building_generate_resource_{$building->generate_resource}");
        });

        static::deleted(function ($building) {
            Cache::forget("building_generate_resource_{$building->generate_resource}");
        });
    }


    public function buildingRequirements(): HasMany
    {
        return $this->hasMany(BuildingRequirements::class);
    }

    public function userBuildings(): HasMany
    {
        return $this->hasMany(CharacterBuildings::class);
    }
}
