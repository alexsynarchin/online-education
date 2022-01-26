<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category\CategoryType;
use Illuminate\Http\Request;

class CategoryTypeController extends Controller
{
    public function listByType(Request $request, $type, $parent_id = null)
    {
        $categoryTypes = (new CategoryType) ->newQuery();
        $categoryTypes = $categoryTypes -> where('type', $type)->where('active', 1);
        if($parent_id) {
            $categoryTypes = $categoryTypes -> where('parent_id', $parent_id);
            if($request->has('edu_type_id')) {
                $categoryTypes = $categoryTypes->where(function($query) use ($request){
                    $query->where('edu_type_id', $request->get('edu_type_id'));
                    $query -> orWhereNull('edu_type_id');
                });
            }
        }
        $categoryTypes = $categoryTypes -> get(['id', 'title']);
        return $categoryTypes;
    }

}
