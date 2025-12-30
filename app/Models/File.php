<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class File extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'url', 'task_id'];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
