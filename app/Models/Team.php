<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;
use Illuminate\Support\Str;

class Team extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'name',
        'slug',
        'role',
        'content_en',
        'content_es',
        'image_url',
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

        static::creating(function (Team $team) {
            $team->slug = static::generateUniqueSlug($team->name);
        });

        static::updating(function (Team $team) {
            if ($team->isDirty('name')) {
                $team->slug = static::generateUniqueSlug(
                    $team->name,
                    $team->id
                );
            }
        });
    }

    /**
     * Generate a unique slug based on the name.
     */
    protected static function generateUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $slug = Str::slug($name);
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
     * Scope: only visible team members.
     */
    public function scopeVisible($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Lightweight model-level observability.
     * Full logging is handled in controllers via SystemLogger.
     */
    protected static function booted()
    {
        static::updated(fn() => \Log::info('TEAM updated fired'));
    }
}
