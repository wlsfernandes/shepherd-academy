<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'institution_id'];

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    public function modules()
    {
        return $this->hasMany(Module::class);
    }
}
