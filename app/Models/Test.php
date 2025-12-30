<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Test extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'instructions', 'task_id'];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

}
