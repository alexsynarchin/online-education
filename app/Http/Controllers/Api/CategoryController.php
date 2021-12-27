<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category\CategoryType;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function typeList($type, $parent_id = null)
    {
        $categories = (new CategoryType) -> newQuery();
        $categories = $categories -> where('type', $type);
        if($parent_id) {
            $categories = $categories -> where('parent_id', $parent_id);
        }
        $categories = $categories -> get(['id', 'title']);
        return $categories;
    }
}
