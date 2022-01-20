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
            $courses = $courses -> whereIn('edu_level_id', $request->get('levels'));
        }
        if($request->has('subjects')) {
            $courses = $courses -> whereIn('subject_id', $request->get('subjects'));
        }
        if($request->has('themes') && $request->get('themes')) {
            $courses = $courses -> whereHas('themes', function ($query) use ($request){
                $query->whereIn('theme_id', $request->get('themes'));
            });
        }
        $courses = $courses -> whereHas('lessons', function ($query){
            $query -> where('status', 2);
        }) -> with('author') -> with('lessons', function($query) {
            $query -> where('status', 2);
            $query -> take(3);
        })->get();

        return view('site.catalog.index', [
            'courses' => $courses,
            'title' => $category_type -> title,
            'slug' => $category_type -> slug,
        ]);
    }
    public function show($edu_slug, $slug, Request $request)
    {
        $course = Course::where('slug', $slug) ->with(['edu_type' => function($query) {
            $query -> select(['id', 'slug', 'title']);
        }, 'lessons' => function($query) {
            $query -> where('status', 2);
        }]) -> firstOrFail();
        $other_courses = Course::where('author_id', $course-> author_id)
            ->where('id', '!=', $course-> id)
            ->where('status', 2) -> whereHas('lessons', function ($query){
           $query -> where('status', 2);
        }) -> get();
        $show_comment = '';
        if($request->has('comment')) {
            $show_comment = $request->get('comment');
        }
        $filter = [
            'redirect' => true,
            'yege' => $course->yege ? [1] : [],
            'subjects' => [$course -> subject_id],
            'levels' => [$course -> edu_level_id],
            'edu_type' => $course -> edu_type_id,
            'themes' => [],

        ];
        return view('site.catalog.show',[
            'filter' => $filter,
            'course' => $course,
            'other_courses' => $other_courses,
            'show_comment' => $show_comment,
        ]);
    }
}
