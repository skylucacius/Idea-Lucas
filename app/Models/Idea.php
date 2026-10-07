<?php

namespace App\Models;

use App\Enums\IdeaStatus;
use Database\Factories\IdeaFactory;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string|null $image_path
 * @property string|null $description
 * @property IdeaStatus $status
 * @property \Illuminate\Database\Eloquent\Casts\ArrayObject<array-key, mixed> $links
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Step> $steps
 * @property-read int|null $steps_count
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\IdeaFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Idea newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Idea newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Idea query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Idea whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Idea whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Idea whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Idea whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Idea whereLinks($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Idea whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Idea whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Idea whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Idea whereUserId($value)
 * @mixin \Eloquent
 */


class Idea extends Model
{
    /** @use HasFactory<\Database\Factories\IdeaFactory> */
    use HasFactory;
    protected $table = 'ideas';

    protected $casts = [
        'status' => IdeaStatus::class,
        'links' => AsArrayObject::class,
    ];

    protected $fillable = [
        'user_id',
        'title',
        'image_path',
        'description',
        'start_date',
        'status',
        'links',
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
