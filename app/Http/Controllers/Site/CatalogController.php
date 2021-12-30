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
        $courses = Course::where('status', 2) ->with('author') -> get();
        return view('site.catalog.index', [
            'courses' => $courses,
            'title' => $category_type -> title,
        ]);
    }
}
