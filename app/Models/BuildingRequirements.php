<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuildingRequirements extends Model
{
    use HasFactory;

    protected $fillable = [
        'buildings_id',
        'resources_id',
        'value',
    ];

    public function buildings()
    {
        return $this->belongsTo(Buildings::class);
    }

    public function resources()
    {
        return $this->belongsTo(Resources::class);
    }

}
