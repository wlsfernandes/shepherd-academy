<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'order', 'type', 'module_id'];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function tests()
    {
        return $this->hasMany(Test::class);
    }
}
