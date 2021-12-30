<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category\CategoryType;
use App\Models\Category\Course;
use App\Models\Category\EduType;
use App\Models\Category\Level;
use App\Models\Category\Subject;
use Illuminate\Http\Request;

class HeaderNavController extends Controller
{
    public function eduTypesList()
    {
        $edu_types = CategoryType::where('type', 'edu_type') -> get();
        return $edu_types;
    }
    public function eduLevelsList(Request $request)
    {
        $id = $request->get('id');


            $data = [
                'id' => $id,
                'subject_id' => $request->get('subject_id')
            ];
         $levels = CategoryType::where('type', 'edu_level') -> where('parent_id', $id) ->with('categories')->get();
        foreach ($levels as $level) {
            if(count(Course::where('edu_level_id', $level -> id)->where('status', 2) -> whereHas('lessons', function($query) {
                $query -> where('status', 2);
                })) > 0) {
                $level -> disabled = false;
            } else {
                $level -> disabled = true;
            }
            $level -> selected = false;
        }
        return $levels;
    }
    public function filter(Request $request)
    {
        $url = route('catalog', [$request->get('edu_type'), $request->get('subject'), $request->get('level')]);
        return $url;
    }
    public function eduSubjectsList(Request $request)
    {
        $id = $request->get('id');

        $subjects = CategoryType::where('type', 'subject')->with('categories')->get();
        foreach ($subjects as $subject) {
            if(count($subject['categories']) > 0) {
                $subject -> disabled = false;
            } else {
                $subject -> disabled = true;
            }
            $subject -> selected = false;
        }
        return $subjects;
    }
}
