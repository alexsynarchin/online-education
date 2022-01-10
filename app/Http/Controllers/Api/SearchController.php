<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category\CategoryType;
use App\Models\Category\Course;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function autocomplete(Request $request)
    {
        $search= $request->get('search');
        $courses = [];
        $themes = [];
        if(Course::where('title','like','%'.$search.'%') ->exists()) {
            $courses = Course::where('title','like','%'.$search.'%')->get();
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
}
