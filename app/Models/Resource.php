<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class Resource extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'title_en',
        'title_es',
        'description_en',
        'description_es',
        'file_url_en',
        'file_url_es',
        'external_link',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    /**
     * Scope: only published resources.
     */
    public function scopeVisible($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Lightweight model-level observability.
     * Full logging handled in controllers via SystemLogger.
     */
    protected static function booted()
    {
        static::updated(fn() => \Log::info('RESOURCE updated fired'));
    }
}
