<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestRewards extends Model
{
    use HasFactory;

    protected $fillable = [
        'statistics_id',
        'resources_id',
        'buildings_id',
        'quests_id',
        'value'
    ];

    public function statistics()
    {
        return $this->belongsTo(Statistics::class);
    }

    public function resources()
    {
        return $this->belongsTo(Resources::class);
    }

    public function buildings()
    {
        return $this->belongsTo(Buildings::class);
    }

    public function quests()
    {
        return $this->belongsTo(Quests::class);
    }

    public function getBuildingNameAttribute()
    {
        $building = $this->buildings()->first();
        return $building ? ucfirst($building->name) : null;
    }

    public function getResourceNameAttribute()
    {
        $resource = $this->resources()->first();
        return $resource ? ucfirst($resource->name) : null;
    }

    public function getStatisticNameAttribute()
    {
        $statistic = $this->statistics()->first();
        return $statistic ? ucfirst($statistic->name) : null;
    }


}
