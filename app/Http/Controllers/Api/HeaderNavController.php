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
        $edu_types = CategoryType::where('type', 'edu_type') ->orderBy('menuindex')-> get();
        return $edu_types;
    }
    public function eduLevelsList(Request $request)
    {
        $id = $request->get('id');

        $levels = CategoryType::where('type', 'edu_level') -> where('parent_id', $id) ->with('categories')->get();
        if($request->get('subject_id')) {
            $subject_id =$request->get('subject_id');
            foreach ($levels as $level) {
                if(Course::where('edu_level_id', $level -> id)
                    -> where('subject_id', $subject_id)
                    ->where('status', 2) -> whereHas('lessons', function($query) {
                    $query -> where('status', 2);
                })->exists()) {
                    $level -> disabled = false;
                } else {
                    $level -> disabled = true;
                }
                $level -> selected = false;
            }
        } else {
            foreach ($levels as $level) {
                if(Course::where('edu_level_id', $level -> id)->where('status', 2) -> whereHas('lessons', function($query) {
                    $query -> where('status', 2);
                })->exists()) {
                    $level -> disabled = false;
                } else {
                    $level -> disabled = true;
                }
                $level -> selected = false;
            }
        }


        return $levels;
    }
    public function filter(Request $request)
    {
        $levels[] = (int) $request->get('level');
        $subjects[] = (int) $request -> get('subject');
        $url = route('catalog', [
            'edu_slug' => $request->get('edu_type'),
            'levels' => $levels,
            'subjects' => $subjects,
            ]);
        return $url;
    }
    public function eduSubjectsList(Request $request)
    {
        $id = $request->get('id');

        $subjects = CategoryType::where('type', 'subject')->with('categories')->get();
        if($request->get('level_id')) {
            $level_id = $request->get('level_id');
            foreach ($subjects as $subject) {
                if(Course::where('edu_type_id',  $id) -> where('edu_level_id', $level_id)-> where('subject_id', $subject -> id) -> where('status', 2) -> whereHas('lessons', function($query) {
                    $query -> where('status', 2);
                })->exists()) {
                    $subject -> disabled = false;
                } else {
                    $subject -> disabled = true;
                }
                $subject -> selected = false;
            }
        } else {
            foreach ($subjects as $subject) {
                if(Course::where('edu_type_id',  $id)-> where('subject_id', $subject -> id) -> where('status', 2) -> whereHas('lessons', function($query) {
                    $query -> where('status', 2);
                })->exists()) {
                    $subject -> disabled = false;
                } else {
                    $subject -> disabled = true;
                }
                $subject -> selected = false;
            }
        }

        return $subjects;
    }
    public function getDirections(Request $request)
    {
        $directions = (new CategoryType) -> newQuery();
        if($request->get('edu_type_id') !=4) {
            $directions = $directions ->where(function($query) use ($request) {
                $query->where('edu_type_id', $request->get('edu_type_id'));
                $query -> orWhereNull('edu_type_id');
            });
        } else {
            $directions = $directions ->where(function($query) use ($request) {
                $query->where('edu_type_id', $request->get('edu_type_id'));
            });
        }

        $directions = $directions->where('type', 'specialty')  -> whereNull('parent_id') ->where('active',1)->get();
        return $directions;
    }
    public function redirectDirectionPage(Request $request)
    {
        $url = route('catalog', [
            'edu_slug' => $request->get('edu_type'),
            'direction' => $request->get('direction')
        ]);
        return $url;
    }
}
