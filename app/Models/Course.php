<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    /** @use HasFactory<\Database\Factories\CourseFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'cover_image',
        'slug',
        'level_id',
        'created_by',
        'is_published'
    ];

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function completions()
    {
        return $this->hasMany(CourseCompletion::class);
    }
}
