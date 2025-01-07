<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocalizationNpcs extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'localizations_id',
        'quests_id',
        'appearance',
    ];

    public function localizations()
    {
        return $this->belongsTo(Localizations::class);
    }

    public function quests()
    {
        return $this->belongsTo(Quests::class);
    }

    protected function casts()
    {
        return [
            'appearance' => 'array',
        ];
    }
}
