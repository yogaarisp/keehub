<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompatibilityRule extends Model
{
    protected $fillable = [
        'rule_key',
        'title',
        'params',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'params' => 'array',
            'is_active' => 'boolean',
        ];
    }
}
