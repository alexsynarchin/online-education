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


        $categories = (new CategoryType) -> newQuery();

        $categories = $categories -> where('type', $type);
        if(Auth::check() && Auth::user()->profile_type != '') {
            $categories = $categories ->where('active', 1);
        }
        if($parent_id) {

            $categories = $categories -> where('parent_id', $parent_id);
        }
        if($request->has('edu_type_id') && $type === 'specialty' && $parent_id == null)  {
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
            if($parent_id) {
                $categories_teacher = CategoryType::where('active', 0) -> where('parent_id', $parent_id) ->  where('type', $type) -> whereHas('teacherModerate', function ($query) use($user_id){
                    $query->where('user_id', $user_id);
                })-> get(['id', 'title']);
            } else {
                $categories_teacher = CategoryType::where('active', 0)  -> where('parent_id', null)->  where('type', $type) -> whereHas('teacherModerate', function ($query) use($user_id){
                    $query->where('user_id', $user_id);
                })-> get(['id', 'title']);
            }

            $categories = $categories -> merge($categories_teacher);
        }
        return $categories;
    }
}
