<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserEquipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'items_id',
        'user_character_id',
    ];

    public function items()
    {
        return $this->belongsTo(Items::class);
    }

    public function userCharacter()
    {
        return $this->belongsTo(UserCharacter::class);
    }
}
