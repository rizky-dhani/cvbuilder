<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkExperience extends Model
{
    /** @use HasFactory<\Database\Factories\WorkExperienceFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company',
        'position',
        'location',
        'start_date',
        'end_date',
        'is_current',
        'description',
    ];

    /**
     * Get the user that owns the work experience.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'is_current' => 'boolean',
        ];
    }
}