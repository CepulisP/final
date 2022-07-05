<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    public function unit()
    {
        return $this->hasOne(Unit::class, 'id', 'unit_id');
    }
}
