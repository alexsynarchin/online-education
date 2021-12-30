<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Category\CategoryType;
use App\Models\Category\Course;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index($edu_type, Request $request)
    {
        $category_type = CategoryType::where('slug', $edu_type) -> firstOrFail();
        $courses = (new Course) -> newQuery();
        $courses =  $courses ->where('edu_type_id', $category_type -> id) -> where('status', 2) ;
        if($request->has('levels')) {
            $courses = $courses -> where('edu_level_id', $request->get('levels'));
        }
        if($request->has('subjects')) {
            $courses = $courses -> where('subject_id', $request->get('subjects'));
        }
        $courses = $courses -> whereHas('lessons', function ($query){
            $query -> where('status', 2);
        }) -> with('author') -> with('lessons', function($query) {
            $query -> where('status', 2);
            $query -> take(3);
        })->get();
        $filter = [
            'subject' => $request->get('subjects'),
            'level' => $request->get('levels'),
            'edu_type' => $category_type->id
        ];
        return view('site.catalog.index', [
            'courses' => $courses,
            'filter' => $filter,
            'title' => $category_type -> title,
        ]);
    }
    public function show($slug)
    {

    }
}
