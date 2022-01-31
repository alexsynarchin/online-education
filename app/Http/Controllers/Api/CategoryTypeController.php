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
        $selected = $request->get('selected');
        $selected = json_decode($selected, true);

        if($type === 'subject') {
            $categoryTypes = $categoryTypes ->whereHas('coursesSubject', function ($query) use ($selected){
                $query->where('status', 2);
                $query->where('edu_type_id', $selected['edu_type']);
            });
        }
        if($parent_id) {
            $categoryTypes = $categoryTypes -> where('parent_id', $parent_id);
            if($type === 'specialty') {
                $categoryTypes = $categoryTypes ->whereHas('coursesSpecialty',function ($query) use ($selected){
                    $query->where('status', 2);
                    $query->where('edu_type_id', $selected['edu_type']);
                });
            }
            if(($request->has('edu_type_id')) && ($type === 'specialty')) {
                $categoryTypes = $categoryTypes->where(function($query) use ($request){
                    $query->where('edu_type_id', $request->get('edu_type_id'));
                    $query -> orWhereNull('edu_type_id');
                });
            }
        }
        $count = '';
        if($type === 'specialty') {
            $categoryTypes = $categoryTypes->withCount('coursesSpecialty');
            $count = 'courses_specialty';
        }
        if($type === 'subject') {
            $categoryTypes = $categoryTypes->withCount('coursesSubject');
            $count = 'courses_subject';
        }
        if($type === 'theme') {
            $categoryTypes = $categoryTypes->withCount('coursesTheme');
            $count = 'courses_theme';
        }
        if($type === 'edu_level') {
            $categoryTypes = $categoryTypes->withCount('coursesLevel');
            $count = 'courses_level';
        }

        $categoryTypes = $categoryTypes -> get(['id', 'title', $count]);
        return $categoryTypes;
    }

}
