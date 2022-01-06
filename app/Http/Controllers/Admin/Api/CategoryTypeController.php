<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Category\CategoryType;
use Illuminate\Http\Request;

class CategoryTypeController extends Controller
{
    public function getList($type, Request $request)
    {
        $list = (new CategoryType) -> newQuery();
        $list = $list -> where('type', $type);
        if($request->has('edu_type_id')) {
            $list = $list -> where('parent_id', $request-> get('edu_type_id'));
        }
        $list = $list -> get(['id', 'title']);
        return $list;
    }
    public function show($type, $id)
    {

        $categoryType = (new CategoryType) -> newQuery();
        $categoryType = CategoryType::where('type', $type) -> where('id', $id);
        $categoryType = $categoryType -> firstOrFail();
        return $categoryType;
    }

    public function store(Request $request)
    {

    }
    public function update(Request $request)
    {
        $categoryType= CategoryType::findOrFail($request->get('id'));
        $categoryType -> update($request->except('id'));
        return $categoryType;
    }
    public function remove($id)
    {
        $categoryType = CategoryType::findOrFail($id);
        if($categoryType -> type === 'edu_level') {

        }
        $categoryType -> delete();
    }
}
