<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComparisonFeature extends Model
{
    protected $fillable = [
        'name',
        'is_standard',
        'is_express',
        'is_elite',
        'order',
    ];

    protected $casts = [
        'is_standard' => 'boolean',
        'is_express' => 'boolean',
        'is_elite' => 'boolean',
    ];
}
