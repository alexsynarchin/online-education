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
        $list = $list -> where('type', $type) -> withCount('levels');
        if($type === 'specialty' && !$request->has('parent_id')) {
           $list = $list->whereNull('parent_id');
        }
        if($request->has('parent_id')) {
            $list = $list -> where('parent_id', $request-> get('parent_id'));
        }
        $list = $list -> get(['id', 'title']);
        return $list;
    }
    public function getThemes()
    {
        $themes = CategoryType::where('type', 'theme')->with('parent')->get();
        return $themes;
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
        if($request->get('type') === 'theme') {
            $request -> validate([
                'title' =>'required',
                'parent_id' => 'required',
            ], [
                'title.required' => 'Введите название темы курса',
                'parent_id.required' => 'Выберите  предмет',
            ]);
        }
        $categoryType = CategoryType::create($request->all());
        return $categoryType;
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
