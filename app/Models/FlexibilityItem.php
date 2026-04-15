<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlexibilityItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_name',
        'description',
        'point_cost',
        'stock_limit',
        'is_active',
    ];
}
