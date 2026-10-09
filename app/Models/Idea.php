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
        'start_date' => 'datetime',
        'end_date'   => 'datetime',
    ];

    protected $fillable = [
        'user_id',
        'title',
        'image_path',
        'description',
        'start_date',
        'end_date',
        'email_sent_at',
        'status',
        'links',
    ];

    /**
     * Exibe a data no formato BR (d/m/Y H:i ou d/m/Y)
     */
    protected function startDateFormatted(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (!$this->start_date) return null;
                
                return $this->start_date->format('H:i:s') !== '00:00:00' 
                    ? $this->start_date->format('d/m/Y H:i') 
                    : $this->start_date->format('d/m/Y');
            }
        );
    }

    /**
     * Exibe a data no formato BR (d/m/Y H:i ou d/m/Y)
     */
    protected function endDateFormatted(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (!$this->end_date) return null;

                return $this->end_date->format('H:i:s') !== '00:00:00' 
                    ? $this->end_date->format('d/m/Y H:i') 
                    : $this->end_date->format('d/m/Y');
            }
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
