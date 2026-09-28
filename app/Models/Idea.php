<?php

namespace App\Models;

use App\Enums\IdeaStatus;
use Database\Factories\IdeaFactory;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Idea extends Pivot
{
    /** @use HasFactory<\Database\Factories\IdeaFactory> */
    use HasFactory;
    protected $table = 'ideas';

    protected $casts = [
        'status' => IdeaStatus::class,
        'links' => AsArrayObject::class,
    ];


    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function steps() : HasMany
    {
        return $this->hasMany(Step::class);
    }

    protected static function newFactory()
    {
        return IdeaFactory::new();
    }

    
}
