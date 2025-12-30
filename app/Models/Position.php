<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class Position extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'title_en',
        'title_es',
        'content_en',
        'content_es',
        'publish_start_at',
        'publish_end_at',
        'is_published',
        'image_url',
        'file_url_en',
        'file_url_es',
        'external_link',
    ];

    protected $casts = [
        'publish_start_at' => 'datetime',
        'publish_end_at' => 'datetime',
        'is_published' => 'boolean',
    ];

    /**
     * Scope: only currently visible positions.
     */
    public function scopeVisible($query)
    {
        return $query
            ->where('is_published', true)
            ->where(function ($q) {
                $q->whereNull('publish_start_at')
                    ->orWhere('publish_start_at', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('publish_end_at')
                    ->orWhere('publish_end_at', '>=', now());
            });
    }

    /**
     * Model-level observability (lightweight).
     * Controller-level logging is handled via SystemLogger.
     */
    protected static function booted()
    {
        static::updated(fn() => \Log::info('POSITION updated fired'));
    }
}
