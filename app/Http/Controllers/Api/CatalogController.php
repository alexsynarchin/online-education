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
            $direction = '';
            if($request->has('direction')) {
                $direction = CategoryType::findOrFail($request->get('direction'));
                $direction= $direction -> slug;
            }
            return route('catalog', [
                'edu_slug' => $edu_type->slug,
                'direction' => $direction,
                'subjects' => $request->get('subjects'),
                'levels' => $request->get('levels'),
                'themes' => $request->get('themes'),
                'specialties' => $request->get('specialties'),
            ]);
        } else {
            $courses = $filterService-> filter($request->all());
            return $courses;
        }
    }
}
