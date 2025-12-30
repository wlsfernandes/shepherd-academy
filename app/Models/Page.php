<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;
use Illuminate\Support\Str;

class Page extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'title_en',
        'title_es',
        'slug',
        'image_url',
        'content_en',
        'content_es',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    /**
     * Boot method to handle slug generation.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function (Page $page) {
            $page->slug = static::generateUniqueSlug($page->title_en);
        });

        static::updating(function (Page $page) {
            if ($page->isDirty('title_en')) {
                $page->slug = static::generateUniqueSlug(
                    $page->title_en,
                    $page->id
                );
            }
        });
    }

    /**
     * Generate a unique slug based on the English title.
     */
    protected static function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $slug = Str::slug($title);
        $original = $slug;
        $counter = 1;

        while (
            static::where('slug', $slug)
                ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = "{$original}-{$counter}";
            $counter++;
        }

        return $slug;
    }

    /**
     * Scope: only visible pages.
     */
    public function scopeVisible($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Lightweight model-level observability.
     * Controller handles full SystemLogger logging.
     */
    protected static function booted()
    {
        static::updated(fn() => \Log::info('PAGE updated fired'));
    }
}
