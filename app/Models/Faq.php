<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'question',
        'answer',
        'order',
        'is_active',
        'show_on_home',
        'show_on_faq',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'show_on_home' => 'boolean',
        'show_on_faq' => 'boolean',
        'order' => 'integer',
    ];
}
