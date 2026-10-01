<?php

namespace App\Models;

use Database\Factories\StepFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @property int $id
 * @property bool $completed
 * @property int $idea_id
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\Idea $idea
 * @method static \Database\Factories\StepFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Step newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Step newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Step query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Step whereCompleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Step whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Step whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Step whereIdeaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Step whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
