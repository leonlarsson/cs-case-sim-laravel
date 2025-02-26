<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unbox extends Model
{
    use HasFactory;

    protected $hidden = [
        'unboxer_id'
    ];

    protected $casts = [
        'is_stat_trak' => 'boolean',
    ];

    public function case()
    {
        return $this->belongsTo(GameCase::class);
    }

    public function item()
    {
        return $this->belongsTo(GameItem::class);
    }
}
