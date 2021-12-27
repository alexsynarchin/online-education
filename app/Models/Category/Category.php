<?php

namespace App\Models\Category;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable =[
        'category_type_id', 'parent_id',
    ];
    public function categoryType()
    {
        return $this->belongsTo(CategoryType::class,'category_type_id');
    }
}
