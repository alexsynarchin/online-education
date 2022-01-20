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
        $courses = $filterService-> filter($request->all());
        return $courses;
    }
}
