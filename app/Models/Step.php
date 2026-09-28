<?php

namespace App\Models;

use Database\Factories\StepFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Step extends Pivot
{
    /** @use HasFactory<\Database\Factories\StepFactory> */
    use HasFactory;
    protected $table = 'steps';

    protected $casts = [
        'completed' => 'boolean',
    ];

    public function idea() : BelongsTo
    {
        return $this->belongsTo(Idea::class);
    }


    protected static function newFactory()
    {
        return StepFactory::new();
    }
}
