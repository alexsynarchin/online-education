<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Category\Course;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        if($request->get('type')) {
            $themes = Course::whereHas('themes', function ($query) use ($request){
                $query -> where('title', $request->get('search'));
            }) -> whereHas('lessons', function ($query){
                $query -> where('status', 2);
            }) -> with('author') -> with('lessons', function($query) {
                $query -> where('status', 2);
                $query -> take(3);
            }) -> get();
            $courses = [];
        } else {
            $themes = Course::whereHas('themes', function ($query) use ($request){
                $query -> where('title', 'like', '%' .  $request->get('search') . '%');
            }) -> whereHas('lessons', function ($query){
                $query -> where('status', 2);
            }) -> with('author') -> with('lessons', function($query) {
                $query -> where('status', 2);
                $query -> take(3);
            }) -> get();
            $courses = Course::where('title', 'like', '%' . $request->get('search') . '%')
                -> whereHas('lessons', function ($query){
                $query -> where('status', 2);
            }) -> with('author') -> with('lessons', function($query) {
                $query -> where('status', 2);
                $query -> take(3);
            }) -> get();
        }

        return view('site.search.index',['courses' => $courses, 'themes' => $themes]);
    }
}
