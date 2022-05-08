<?php

namespace App\Models\Reference;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class City extends Model
{
    use HasFactory, HasSlug;
    protected $fillable = [
        'title', 'slug', 'region_id', 'active'
    ];
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function region()
    {
        return $this ->belongsTo(Region::class, 'region_id');
    }

    public function eduInstitutions()
    {
        return $this -> hasMany(EduInstitution::class);
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($city) { // before delete() method call this
            $city->eduInstitutions()->delete();
            // do the rest of the cleanup...
        });
    }
}
