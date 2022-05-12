<?php

namespace App\Models\Category;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class CategoryType extends Model
{
    use HasFactory, HasSlug;

    protected $fillable =[
        'title', 'slug', 'type', 'parent_id', 'edu_type_id', 'active',
    ];
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }
    public function categories()
    {
        return $this->hasMany(Category::class, 'category_type_id');
    }
    public function coursesSpecialty()
    {
        return $this->hasMany(Course::class, 'specialty_id');
    }
    public function coursesLevel()
    {
        return $this->hasMany(Course::class, 'edu_level_id');
    }
    public function coursesTheme()
    {
        return $this->belongsToMany(Course::class, 'course_theme','theme_id', 'course_id' );
    }
    public function coursesSubject()
    {
        return $this->hasMany(Course::class, 'subject_id');
    }
    public function levels()
    {
        return $this->hasMany(CategoryType::class, 'parent_id');
    }
    public function parent()
    {
        return $this->belongsTo(CategoryType::class, 'parent_id');
    }

    public function teacherModerate()
    {
        return $this->belongsToMany(CategoryType::class, 'category_type_teacher', 'category_type_id', 'user_id');
    }
}
