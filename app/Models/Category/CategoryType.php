<?php

namespace App\Models\Category;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryType extends Model
{
    use HasFactory;

    protected $fillable =[
        'title', 'slug', 'type', 'parent_id',
    ];

    public function categories()
    {
        return $this->hasMany(Category::class, 'category_type_id');
    }

    public function levels()
    {
        return $this->hasMany(CategoryType::class, 'parent_id');
    }


}
