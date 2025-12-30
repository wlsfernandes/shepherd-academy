<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'institution_id',

        // Identity
        'title',
        'slug',
        'summary',
        'description',
        'image_url',

        // Commerce
        'price',
        'allow_installments',

        // Timeline
        'start_date',
        'end_date',

        // Visibility
        'is_published',
        'publish_start_at',
        'publish_end_at',
    ];

    protected $casts = [
        'allow_installments' => 'boolean',
        'is_published' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
        'publish_start_at' => 'datetime',
        'publish_end_at' => 'datetime',
        'price' => 'decimal:2',
    ];


    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    public function modules()
    {
        return $this->hasMany(Module::class);
    }

    /*
   |--------------------------------------------------------------------------
   | Scopes (VERY IMPORTANT FOR SIMPLICITY)
   |--------------------------------------------------------------------------
   */
    protected static function generateUniqueSlug(Course $course): string
    {
        $baseSlug = Str::slug($course->title);

        $query = self::where('slug', 'LIKE', "{$baseSlug}%");

        // 🔒 Scope uniqueness by institution
        if ($course->institution_id) {
            $query->where('institution_id', $course->institution_id);
        }

        // Ignore current record when updating
        if ($course->exists) {
            $query->where('id', '!=', $course->id);
        }

        $count = $query->count();

        return $count === 0
            ? $baseSlug
            : "{$baseSlug}-" . ($count + 1);
    }

    /**
     * Only courses visible to the public
     */
    public function scopePublished($query)
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
}
