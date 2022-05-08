<?php

namespace App\Models\Reference;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class EduInstitution extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'type', 'title', 'slug', 'city_id'
    ];
    protected $appends = [
        'region'
    ];
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    public function getRegionAttribute()
    {
        $city = $this->city;
        $region = Region::find($city->region_id);
        return [
            'id' => $region->id,
            'title' => $region->title
        ];
    }
}
