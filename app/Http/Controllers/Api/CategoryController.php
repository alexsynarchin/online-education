<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category\CategoryType;
use Illuminate\Http\Request;
use Auth;

class CategoryController extends Controller
{
    public function typeList(Request  $request, $type, $parent_id = null)
    {

        $active = 1;
        if(Auth::check() && Auth::user()->profile_type === '') {
            $active = 0;
        }
        $categories = (new CategoryType) -> newQuery();

        $categories = $categories -> where('type', $type)->where('active', $active);
        if($parent_id) {
            $categories = $categories -> where('parent_id', $parent_id);
        }
        if($request->has('edu_type_id') && $type === 'specialty') {
            $categories = $categories -> where(function($query) use ($request) {
                $query->where('edu_type_id', $request->get('edu_type_id'));
                if($request->get('edu_type_id') != 4) {
                    $query -> orWhereNull('edu_type_id');
                }

            });
            if(!$parent_id && $request->get('edu_type_id') != 4) {
                $categories = $categories->whereNull('parent_id');
            }
        }

        $categories = $categories -> get(['id', 'title']);
        if(Auth::check() && Auth::user()->profile_type === 'teacher') {
            $user_id = Auth::user()->id;
            $categories_teacher = CategoryType::where('active', 0) -> whereHas('teacherModerate', function ($query) use($user_id){
                $query->where('user_id', $user_id);
            })-> get(['id', 'title']);
            $categories = $categories -> merge($categories_teacher);
        }
        return $categories;
    }
}
