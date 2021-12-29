<?php

namespace App\Models\Lesson;

use App\Models\Category\Course;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Lesson extends Model
{
    use HasFactory,  HasSlug;

    protected $fillable = [ 'title', 'course_id','price', 'time','user_id','status','price_user','type_video','type_text','type_image', 'slug'];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
