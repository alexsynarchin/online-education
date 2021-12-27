<?php

namespace App\Models\Category;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Course extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, HasSlug;

    protected $fillable = [
        'title',
        'description',
        'category_id',
        'edu_type_id',
        'edu_level_id',
        'subject_id',
        'author_id',
        'slug',
        'lessons_count'
    ];
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('courses')
            ->singleFile()
            ->useDisk('course');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(200)
            ->height(240)
            ->crop(Manipulations::CROP_CENTER, 200, 240)
            ->nonQueued();
    }


    protected $appends = [
        'image','rating', 'price'
    ];
    public function getRatingAttribute()
    {
        return 0;
    }
    public function getPriceAttribute()
    {
        return 0;
    }
    public function getImageAttribute()
    {
        $image = $this ->getFirstMediaUrl('courses','thumb');
        return $image;
    }

    public function author()
    {
        return $this -> belongsTo(User::class, 'author_id');
    }
    public function edu_type()
    {
        return $this -> belongsTo(CategoryType::class, 'edu_type_id');
    }
    public function subject()
    {
        return $this -> belongsTo(CategoryType::class, 'subject_id');
    }
    public function level()
    {
        return $this -> belongsTo(CategoryType::class, 'edu_level_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
}
