<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category\CategoryType;
use App\Models\Category\Course;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {

       $request=$request->all();
        return route('search', $request);
    }
    public function autocomplete(Request $request)
    {
        $search= $request->get('search');
        $courses = [];
        $themes = [];
        if(Course::where('title','like','%'.$search.'%') ->exists()) {
            $courses = Course::where('title','like','%'.$search.'%')-> whereHas('lessons', function ($query){
                $query -> where('status', 2);
            }) -> with('author') -> with('lessons', function($query) {
                $query -> where('status', 2);
                $query -> take(3);
            }) ->get();
            $courses = $courses ->pluck('title') ->toArray();
            $courses = array_unique($courses);
        }
        if(CategoryType::where('type', 'theme') ->where('title','like','%'.$search.'%') ->exists()) {
            $themes = CategoryType::where('type', 'theme') ->where('title','like','%'.$search.'%') ->get();
            $themes = $themes ->pluck('title') ->toArray();
            $themes = array_unique($themes);
        }
        $data = [
            'courses' => $courses,
            'themes' => $themes,
        ];
        return $data;
    }

    public function autocompleteToCourse(Request $request)
    {
        $exists = Course::where('title', $request->get('title'))->exists();
        $url = '';
        if($exists) {
            $course = Course::where('title', $request->get('title'))->firstOrFail();
            $edu_type = CategoryType::findOrFail($course -> edu_type_id);
            $url = route('catalog.show', ['edu_slug' => $edu_type -> slug, 'slug' => $course -> slug]);
        }
        return $url;
    }
}
