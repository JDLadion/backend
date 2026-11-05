<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MenuItem extends Model
{
    protected $fillable = [
        'name',
        'category',
        'price',
        'stock',
        'favorite',
        'emoji',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'float',
            'favorite' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
