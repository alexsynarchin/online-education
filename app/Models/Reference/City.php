<?php

namespace App\Models\Reference;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\SlugOptions;

class City extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'slug'
    ];
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }
    public function eduInstitutions()
    {
        return $this -> hasMany(EduInstitution::class);
    }
}
