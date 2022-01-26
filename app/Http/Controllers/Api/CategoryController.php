<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category\CategoryType;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function typeList(Request  $request, $type, $parent_id = null)
    {
        $categories = (new CategoryType) -> newQuery();

        $categories = $categories -> where('type', $type);
        if($parent_id) {
            $categories = $categories -> where('parent_id', $parent_id);
        }
        if($request->has('edu_type_id') && $type === 'specialty') {
            $categories = $categories -> where(function($query) use ($request) {
                $query->where('edu_type_id', $request->get('edu_type_id'));
                $query -> orWhereNull('edu_type_id');
            });
            if(!$parent_id) {
                $categories = $categories->whereNull('parent_id');
            }
        }

        $categories = $categories -> get(['id', 'title']);
        return $categories;
    }
}
