<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category\CategoryType;
use Illuminate\Http\Request;

class CategoryTypeController extends Controller
{
    public function listByType($type, $parent_id = null)
    {
        $categoryTypes = (new CategoryType) ->newQuery();
        $categoryTypes = $categoryTypes -> where('type', $type);
        if($parent_id) {
            $categoryTypes = $categoryTypes -> where('parent_id', $parent_id);
        }
        $categoryTypes = $categoryTypes -> get(['id', 'title']);
        return $categoryTypes;
    }

}
