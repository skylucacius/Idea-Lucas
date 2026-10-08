<?php

namespace App\Models;

use App\Enums\IdeaStatus;
use Database\Factories\IdeaFactory;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Idea extends Model
{
    /** @use HasFactory<\Database\Factories\IdeaFactory> */
    use HasFactory;
    protected $table = 'ideas';

    protected $casts = [
        'status' => IdeaStatus::class,
        'links' => AsArrayObject::class,
        'start_date' => 'date',
        'end_date'   => 'date',        ];

    protected $fillable = [
        'user_id',
        'title',
        'image_path',
        'description',
        'start_date',
        'end_date',
        'status',
        'links',
    ];
    /**
     * Formatador para start_date (d/m/Y)
     */
    protected function startDateFormatted(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->start_date?->format('d/m/Y')
        );
    }

    /**
     * Formatador para end_date (d/m/Y)
     */
    protected function endDateFormatted(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->end_date?->format('d/m/Y')
        );
    }
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
