<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Idea extends Pivot
{
    /** @use HasFactory<\Database\Factories\IdeaFactory> */
    use HasFactory;

    
}
