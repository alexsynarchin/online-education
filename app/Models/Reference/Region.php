<?php

namespace App\Models\Reference;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Region extends Model
{
    use HasFactory, HasSlug;
    protected $fillable = [
        'title', 'slug', 'active'
    ];
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function cities()
    {
        return $this->hasMany(City::class);
    }
    public static function boot() {
        parent::boot();

        static::deleting(function($region) { // before delete() method call this
            $region->cities()->delete();
            // do the rest of the cleanup...
        });
    }
}
