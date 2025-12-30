<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class MenuItem extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'label_en',
        'label_es',
        'url',
        'order',
        'is_active',
        'open_in_new_tab',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'open_in_new_tab' => 'boolean',
    ];

    /**
     * Scope: only active menu items.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: ordered menu items.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    /**
     * Helper: get label based on locale.
     */
    public function label(string $locale = 'en'): string
    {
        return $locale === 'es' && $this->label_es
            ? $this->label_es
            : $this->label_en;
    }

    /**
     * Lightweight model-level observability.
     * Full logging handled in controllers via SystemLogger.
     */
    protected static function booted()
    {
        static::updated(fn() => \Log::info('MENU ITEM updated fired'));
    }
}
