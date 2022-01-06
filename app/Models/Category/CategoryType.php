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
        'title', 'slug', 'type', 'parent_id',
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

    public function levels()
    {
        return $this->hasMany(CategoryType::class, 'parent_id');
    }


}
