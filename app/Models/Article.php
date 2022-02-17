<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Article extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, HasSlug;
    protected $fillable = ['slug', 'title', 'text', ];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('articles')
            ->singleFile()
            ->useDisk('article');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(480)
            ->height(320)
            ->crop(Manipulations::CROP_CENTER, 480, 320)
            ->nonQueued();
    }

    protected $appends = ['image'];

    public function getImageAttribute()
    {
        $image = $this ->getFirstMediaUrl('articles','thumb');
        return $image;
    }

    public function seo()
    {
        return $this->morphOne(Seo::class,'pageable');
    }
}
