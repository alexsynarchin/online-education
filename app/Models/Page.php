<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Page extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    protected $fillable =[
        'name', 'active', 'slug', 'blocks', 'text', 'type'
    ];
    protected $casts = [
        'active' => 'boolean',
        'blocks' => 'array'
    ];
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('pages')
            ->useDisk('page');
    }
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(120)
            ->height(120)
            ->crop(Manipulations::CROP_CENTER, 120, 120)
            ->performOnCollections('pages')
            ->nonQueued();

        $this->addMediaConversion('preview')
            ->width(400)
            ->height(255)
            ->crop(Manipulations::CROP_CENTER, 400, 255)
            ->performOnCollections('pages')
            ->nonQueued();
    }
    public function seo()
    {
        return $this->morphOne(Seo::class,'pageable');
    }
}
