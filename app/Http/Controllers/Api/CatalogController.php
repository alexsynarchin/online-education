<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Services\CatalogFilterService;
use App\Models\Category\CategoryType;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function filter(Request $request, CatalogFilterService $filterService)
    {
        if($request->has('redirect')) {
            $edu_type = CategoryType::findOrFail($request->get('edu_type'));
            return route('catalog', ['edu_slug' => $edu_type->slug,
                'subjects' => $request->get('subjects'),
                'levels' => $request->get('levels'),
                'themes' => $request->get('themes'),
            ]);
        } else {
            $courses = $filterService-> filter($request->all());
            return $courses;
        }
    }
}
