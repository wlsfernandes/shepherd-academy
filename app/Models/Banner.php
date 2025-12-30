<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class Banner extends Model
{
    use Auditable;
    protected $fillable = [
        'title_en',
        'title_es',
        'subtitle_en',
        'subtitle_es',
        'image_url',
        'link',
        'open_in_new_tab',
        'is_published',
        'publish_start_at',
        'publish_end_at',
        'is_published',
        'sort_order',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'open_in_new_tab' => 'boolean',
        'publish_start_at' => 'date',
        'publish_end_at' => 'date',
    ];
}
