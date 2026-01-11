<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Certification extends Model
{
    /** @use HasFactory<\Database\Factories\CertificationFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'issuer',
        'issue_date',
        'expiry_date',
        'url',
    ];

    /**
     * Get the user that owns the certification.
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
            'issue_date' => 'date',
            'expiry_date' => 'date',
        ];
    }
}