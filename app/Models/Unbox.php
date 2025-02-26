<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unbox extends Model
{
    public function case()
    {
        return $this->belongsTo(GameCase::class);
    }

    public function item()
    {
        return $this->belongsTo(GameItem::class);
    }
}
